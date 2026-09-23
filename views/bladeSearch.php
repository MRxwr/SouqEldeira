<?php
/*
 * Search results page.
 *
 * The filters live inside the url (/search/{category-title}/{categoryId}/{areaId})
 * so a result page can be shared and crawled, and the same form as the home
 * page is rendered again, pre-filled with the filters being searched.
 */
$searchFilters        = SeoUrls::searchFilters();
$searchCategoryId     = $searchFilters["categoryId"];
$searchAreaId         = $searchFilters["areaId"];
$searchPropertyTypeId = $searchFilters["propertyTypeId"];
$searchFrom           = $searchFilters["from"];
$searchTo             = $searchFilters["to"];

$categoryTitle = "";
$areaTitle = "";
$propertyTypeTitle = "";
$ads = array();

if ( $searchCategoryId > 0 && $category = selectDBNew("categories",[$searchCategoryId],"`status` = '0' AND `hidden` = '1' AND `id` = ?","") ){
	$categoryTitle = direction($category[0]["enTitle"],$category[0]["arTitle"]);
	if ( $searchAreaId > 0 && $area = selectDBNew("areas",[$searchAreaId],"`status` = '0' AND `hidden` = '0' AND `id` = ?","") ){
		$areaTitle = direction($area[0]["enTitle"],$area[0]["arTitle"]);
	}
	if ( $searchPropertyTypeId > 0 && $propertyType = selectDBNew("propertyType",[$searchPropertyTypeId],"`status` = '0' AND `hidden` = '1' AND `id` = ?","") ){
		$propertyTypeTitle = direction($propertyType[0]["enTitle"],$propertyType[0]["arTitle"]);
	}
	$searchAreaQuery = ( $searchAreaId > 0 ) ? " AND `areaId` = '{$searchAreaId}' " : "";
	$searchPropertyTypeQuery = ( $searchPropertyTypeId > 0 ) ? " AND `propertyType` = '{$searchPropertyTypeId}' " : "";
	if ( $searchFrom !== "" && $searchTo !== "" ){
		$searchPriceQuery = " AND `price` BETWEEN '{$searchFrom}' AND '{$searchTo}' ";
	}elseif ( $searchFrom !== "" ){
		$searchPriceQuery = " AND `price` >= '{$searchFrom}' ";
	}elseif ( $searchTo !== "" ){
		$searchPriceQuery = " AND `price` <= '{$searchTo}' ";
	}else{
		$searchPriceQuery = "";
	}
	if( $searchResult = selectDBNew("products",[$searchCategoryId],"`status` = '0' AND `hidden` = '1' AND `categoryId` = ? {$searchAreaQuery} {$searchPriceQuery} {$searchPropertyTypeQuery} ","`packageId` DESC,`id` DESC") ){
		$ads = $searchResult;
	}
}else{
	?>
	<script>
		alert('<?php echo direction("Please select category","يرجى اختيار الفئة"); ?>');
		window.location.href = '/home';
	</script>
	<?php
}
?>
<nav aria-label="breadcrumb" class="mb-3">
	<ol class="breadcrumb mb-0">
		<li class="breadcrumb-item"><a href="/"><?php echo direction("Home","الرئيسية"); ?></a></li>
		<li class="breadcrumb-item active" aria-current="page"><?php echo $categoryTitle ?: direction("Search Results","نتائج البحث"); ?></li>
	</ol>
</nav>
<div class="search-ads-options mb-3">
	<div class="div">
		<span class="title"><?php echo direction("Search Options","خيارات البحث"); ?></span>
	</div> 
	<div class="div">
		<span class="title"><?php echo direction("Type","النوع"); ?></span>
		<span class="data">
			<span><?php echo $categoryTitle; ?><span> 
		</span>
	</div>
	<div class="div">
		<span class="title"><?php echo direction("Region","المنطقة"); ?></span>
		<span class="data">
			<span><?php echo $areaTitle; ?></span>
		</span>
	</div>
	<?php if( $propertyTypeTitle !== "" ){ ?>
	<div class="div">
		<span class="title"><?php echo direction("Property Type","نوع العقار"); ?></span>
		<span class="data">
			<span><?php echo $propertyTypeTitle; ?></span>
		</span>
	</div>
	<?php } ?>
	<?php if( $searchFrom !== "" || $searchTo !== "" ){ ?>
	<div class="div">
		<span class="title"><?php echo direction("Price","السعر"); ?></span>
		<span class="data">
			<span><?php echo ( $searchFrom !== "" ? $searchFrom : "-" ) . " / " . ( $searchTo !== "" ? $searchTo : "-" ); ?></span>
		</span>
	</div>
	<?php } ?>
</div>

<?php
/* Same search form as the home page, pre-filled with the filters of this search */
$searchFormClass = "search-area in-page-content";
include 'template/searchForm.php';
?>

<div class="search-title mb-3 mt-2">  
	<h1><i class="bi bi-search"></i><?php echo direction("Search Result","نتيجة البحث"); ?><span><?php echo count($ads) . " " .direction("Ad","إعلان"); ?></span></h1>
</div>

<div class="listings-section">
	<?php include 'template/adsMainList.php'; ?>
	<div class="d-block text-end mt-3">
	<?php /*<a href="" class="btn btn-primary"><?php echo direction("More","المزيد"); ?> ...</a>*/?>
	</div>
</div>
