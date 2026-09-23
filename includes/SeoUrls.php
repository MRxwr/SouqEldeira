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

	// Url of a search result page: /search/{category-slug}/{categoryId}/{areaId}
	public static function searchUrl($category, $areaId = 0, $propertyTypeId = "", $from = "", $to = "", $lang = null) {
		$categoryId = (int)($category["id"] ?? 0);
		$url = "/search/" . rawurlencode(self::slugFor($category["enTitle"] ?? "", $category["arTitle"] ?? "", $lang)) . "/" . $categoryId;
		if ( (int)$areaId > 0 ) { $url .= "/" . (int)$areaId; }
		$query = array();
		if ( (int)$propertyTypeId > 0 ) { $query[] = "propertyType=" . (int)$propertyTypeId; }
		if ( is_numeric($from) ) { $query[] = "from=" . rawurlencode($from); }
		if ( is_numeric($to) ) { $query[] = "to=" . rawurlencode($to); }
		if ( $query ) { $url .= "?" . implode("&", $query); }
		return $url;
	}

	// Filters of the request being handled, from the pretty url, the query string or a legacy post
	public static function searchFilters() {
		$request = array_merge($_GET, $_POST);
		$categoryId = 0;
		if ( isset($request["type"]) && $request["type"] !== "" ) {
			$categoryId = (int)$request["type"];
		}elseif ( isset($request["categoryId"]) ) {
			$categoryId = (int)$request["categoryId"];
		}
		$areaId = 0;
		if ( isset($request["area"]) && $request["area"] !== "" ) {
			$areaId = (int)$request["area"];
		}elseif ( isset($request["areaId"]) ) {
			$areaId = (int)$request["areaId"];
		}
		return array(
			"categoryId"     => $categoryId,
			"areaId"         => $areaId,
			"propertyTypeId" => ( isset($request["propertyType"]) && $request["propertyType"] !== "" ) ? (int)$request["propertyType"] : "",
			"from"           => ( isset($request["from"]) && is_numeric($request["from"]) ) ? $request["from"] : "",
			"to"             => ( isset($request["to"]) && is_numeric($request["to"]) ) ? $request["to"] : ""
		);
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
		}elseif ( $view == "Search" ) {
			$filters = self::searchFilters();
			if ( $filters["categoryId"] < 1 ) { return null; }
			if ( !$category = selectDBNew("categories",[$filters["categoryId"]],"`status` = '0' AND `hidden` = '1' AND `id` = ?","") ) { return null; }
			$areaId = $filters["areaId"];
			// Keep the url clean, only a real area is part of the canonical url
			if ( $areaId > 0 && !selectDBNew("areas",[$areaId],"`id` = ?","") ) { $areaId = 0; }
			foreach ( array("ar","en") as $lang ) {
				$paths[$lang] = self::searchUrl($category[0], $areaId, $filters["propertyTypeId"], $filters["from"], $filters["to"], $lang);
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
		$requestedPath = parse_url($_SERVER["REQUEST_URI"] ?? "/", PHP_URL_PATH);
		$canonicalPath = parse_url($canonical, PHP_URL_PATH);
		if ( rawurldecode(rtrim($requestedPath, "/")) === rawurldecode(rtrim($canonicalPath, "/")) ) { return; }
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $canonical);
		exit;
	}
}
