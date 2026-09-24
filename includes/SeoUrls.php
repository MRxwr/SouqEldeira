<?php
/**
 * Language dependent urls.
 *
 * Pages built around a title (news, ads, search results) keep a single slug
 * that matches the language of the page being rendered, so one url never
 * exposes both the english and the arabic title. Old or mixed urls are sent
 * with a permanent redirect to the canonical one, and every language version
 * is announced to the search engines through its own url.
 */
class SeoUrls {

	// Language of the page being rendered, from the same source as direction()
	public static function currentLang() {
		GLOBAL $directionHTML;
		return ( isset($directionHTML) && $directionHTML == "rtl" ) ? "ar" : "en";
	}

	private static function slugOf($text) {
		$text = (string)$text;
		return function_exists("slug") ? slug($text) : trim(preg_replace('/\s+/u', '-', $text));
	}

	// Slug of a title in the given language, falling back to the other title
	public static function slugFor($enTitle, $arTitle, $lang = null) {
		$lang = empty($lang) ? self::currentLang() : $lang;
		$titleSlug = self::slugOf(($lang == "en") ? $enTitle : $arTitle);
		if ( $titleSlug === "" ) { $titleSlug = self::slugOf($enTitle); }
		if ( $titleSlug === "" ) { $titleSlug = self::slugOf($arTitle); }
		return $titleSlug;
	}

	// Url of a page that ends with its language dependent title
	public static function titleUrl($path, $id, $enTitle, $arTitle, $lang = null) {
		return "/" . trim($path, "/") . "/" . rawurlencode((string)$id) . "/" . rawurlencode(self::slugFor($enTitle, $arTitle, $lang));
	}

	// Rows of a table, loaded once per request
	private static function rowsOf($table, $where) {
		static $cache = array();
		$key = $table . "|" . $where;
		if ( !isset($cache[$key]) ) {
			$rows = function_exists("selectDB") ? selectDB($table, $where) : 0;
			$cache[$key] = is_array($rows) ? $rows : array();
		}
		return $cache[$key];
	}

	// The very rows the search form offers, so every choice can be written as a title
	private static function searchCategories() {
		return self::rowsOf("categories", "`status` = '0' AND `hidden` = '1' ORDER BY `rank` ASC");
	}

	private static function searchAreas() {
		return self::rowsOf("areas", "`status` = '0'");
	}

	private static function searchPropertyTypes() {
		return self::rowsOf("propertyType", "`status` = '0' AND `hidden` = '1' ORDER BY `rank` ASC");
	}

	private static function lower($text) {
		$text = (string)$text;
		return function_exists("mb_strtolower") ? mb_strtolower($text, "UTF-8") : strtolower($text);
	}

	private static function rowById($rows, $id) {
		$id = (int)$id;
		if ( $id < 1 ) { return null; }
		foreach ( $rows as $row ) {
			if ( (int)($row["id"] ?? 0) === $id ) { return $row; }
		}
		return null;
	}

	// Title slug a row answers to in the given language
	private static function rowSlug($row, $lang = null) {
		return self::slugFor($row["enTitle"] ?? "", $row["arTitle"] ?? "", $lang);
	}

	// Row whose title slug, in either language, matches the part of the url
	private static function rowBySlug($rows, $slug) {
		$slug = self::lower(rawurldecode((string)$slug));
		if ( $slug === "" ) { return null; }
		foreach ( $rows as $row ) {
			foreach ( array("en","ar") as $lang ) {
				if ( self::lower(self::rowSlug($row, $lang)) === $slug ) { return $row; }
			}
		}
		return null;
	}

	/*
	 * Url of a search result page: /search/{category}/{area}/{property-type}, every
	 * part the title of the language being rendered, so the url never shows an id.
	 * A price range has no title, so it is the only thing left in the query string.
	 */
	public static function searchUrl($category, $areaId = 0, $propertyTypeId = "", $from = "", $to = "", $lang = null) {
		$lang = empty($lang) ? self::currentLang() : $lang;
		if ( !is_array($category) ) { $category = self::rowById(self::searchCategories(), $category); }
		if ( empty($category) ) { return "/search"; }
		$url = "/search";
		if ( ($slug = self::rowSlug($category, $lang)) !== "" ) { $url .= "/" . rawurlencode($slug); }
		if ( $area = self::rowById(self::searchAreas(), $areaId) ) {
			if ( ($slug = self::rowSlug($area, $lang)) !== "" ) { $url .= "/" . rawurlencode($slug); }
		}
		if ( $propertyType = self::rowById(self::searchPropertyTypes(), $propertyTypeId) ) {
			if ( ($slug = self::rowSlug($propertyType, $lang)) !== "" ) { $url .= "/" . rawurlencode($slug); }
		}
		$query = array();
		if ( $from !== "" && is_numeric($from) ) { $query[] = "from=" . rawurlencode($from); }
		if ( $to !== "" && is_numeric($to) ) { $query[] = "to=" . rawurlencode($to); }
		if ( $query ) { $url .= "?" . implode("&", $query); }
		return $url;
	}

	/*
	 * Filters of the request being handled. The pretty url carries the titles, the
	 * plain search form still sends ids and is cleaned up by the canonical redirect.
	 * A price range has no title, so it rides along in the query string.
	 */
	public static function searchFilters() {
		$request = array_merge($_GET, $_POST);
		$filters = array(
			"categoryId"     => 0,
			"areaId"         => 0,
			"propertyTypeId" => "",
			"from"           => ( isset($request["from"]) && $request["from"] !== "" && is_numeric($request["from"]) ) ? $request["from"] : "",
			"to"             => ( isset($request["to"]) && $request["to"] !== "" && is_numeric($request["to"]) ) ? $request["to"] : ""
		);

		$path = trim((string)($request["searchPath"] ?? ""), "/");
		if ( $path !== "" ) {
			$categories = self::searchCategories();
			$areas = self::searchAreas();
			$propertyTypes = self::searchPropertyTypes();
			foreach ( explode("/", $path) as $index => $segment ) {
				$segment = trim(rawurldecode($segment));
				if ( $segment === "" ) { continue; }
				$numeric = ctype_digit($segment);
				if ( $index === 0 ) {
					// first part is always the category, by title or by an old numeric id
					$row = $numeric ? self::rowById($categories, $segment) : self::rowBySlug($categories, $segment);
					if ( $row ) { $filters["categoryId"] = (int)$row["id"]; }
					continue;
				}
				if ( $numeric && $filters["categoryId"] > 0 && (int)$segment === $filters["categoryId"] ) {
					continue; // numeric id of an old /search/{title}/{id}/{id} url
				}
				// then the area, then the property type, both optional
				if ( $filters["areaId"] < 1 ) {
					$row = $numeric ? self::rowById($areas, $segment) : self::rowBySlug($areas, $segment);
					if ( $row ) { $filters["areaId"] = (int)$row["id"]; continue; }
				}
				if ( $filters["propertyTypeId"] === "" ) {
					$row = $numeric ? self::rowById($propertyTypes, $segment) : self::rowBySlug($propertyTypes, $segment);
					if ( $row ) { $filters["propertyTypeId"] = (int)$row["id"]; continue; }
				}
			}
			if ( $filters["categoryId"] > 0 ) {
				// ids sent by the form still fill whatever the url left out
				if ( $filters["areaId"] < 1 && isset($request["areaId"]) && $request["areaId"] !== "" ) { $filters["areaId"] = (int)$request["areaId"]; }
				if ( $filters["propertyTypeId"] === "" && isset($request["propertyType"]) && $request["propertyType"] !== "" ) { $filters["propertyTypeId"] = (int)$request["propertyType"]; }
				return $filters;
			}
		}

		if ( isset($request["categoryId"]) && $request["categoryId"] !== "" ) { $filters["categoryId"] = (int)$request["categoryId"]; }
		if ( isset($request["areaId"]) && $request["areaId"] !== "" ) { $filters["areaId"] = (int)$request["areaId"]; }
		if ( isset($request["propertyType"]) && $request["propertyType"] !== "" ) { $filters["propertyTypeId"] = (int)$request["propertyType"]; }
		return $filters;
	}

	/**
	 * Canonical url and language alternates of the requested page.
	 * Returns null for pages that do not carry a language dependent title.
	 */
	public static function currentPage() {
		$view = $_GET["v"] ?? "";
		$id = (int)($_GET["id"] ?? 0);
		$paths = array();

		if ( $view == "NewsView" && $id > 0 ) {
			if ( !$news = selectDBNew("news",[$id],"`id` = ? AND `status` = '0' AND `hidden` = '1'","") ) { return null; }
			foreach ( array("ar","en") as $lang ) {
				$paths[$lang] = self::titleUrl("news-view", $news[0]["id"], $news[0]["enTitle"], $news[0]["arTitle"], $lang);
			}
		}elseif ( $view == "AdView" && $id > 0 ) {
			if ( !$ad = selectDBNew("products",[$id],"`id` = ?","") ) { return null; }
			foreach ( array("ar","en") as $lang ) {
				$paths[$lang] = self::titleUrl("ad-view", $ad[0]["id"], $ad[0]["enTitle"], $ad[0]["arTitle"], $lang);
			}
		}elseif ( $view == "OfficeView" && $id > 0 ) {
			if ( !$office = selectDBNew("shops",[$id],"`id` = ? AND `status` = '0'","") ) { return null; }
			foreach ( array("ar","en") as $lang ) {
				$paths[$lang] = self::titleUrl("office-view", $office[0]["id"], $office[0]["enTitle"], $office[0]["arTitle"], $lang);
			}
		}elseif ( $view == "Search" ) {
			$filters = self::searchFilters();
			// only a real category, area and property type reach the canonical url
			$category = self::rowById(self::searchCategories(), $filters["categoryId"]);
			if ( !$category ) { return null; }
			foreach ( array("ar","en") as $lang ) {
				$paths[$lang] = self::searchUrl($category, $filters["areaId"], $filters["propertyTypeId"], $filters["from"], $filters["to"], $lang);
			}
		}else{
			return null;
		}

		$canonical = $paths[self::currentLang()];
		self::redirect($canonical);
		return array("canonical" => $canonical, "alternates" => $paths);
	}

	// Send a permanent redirect so every page keeps a single, language correct url
	private static function redirect($canonical) {
		if ( headers_sent() ) { return; }
		$requested = $_SERVER["REQUEST_URI"] ?? "/";
		$requestedPath = parse_url($requested, PHP_URL_PATH);
		$requestedQuery = (string)parse_url($requested, PHP_URL_QUERY);
		$canonicalPath = parse_url($canonical, PHP_URL_PATH);
		$canonicalQuery = (string)parse_url($canonical, PHP_URL_QUERY);
		$samePath = rawurldecode(rtrim($requestedPath, "/")) === rawurldecode(rtrim($canonicalPath, "/"));
		// only a price range lives in the query string, everything else is a title
		$sameQuery = ( $canonicalQuery === "" || $requestedQuery === $canonicalQuery );
		if ( $samePath && $sameQuery ) { return; }
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $canonical);
		exit;
	}
}
