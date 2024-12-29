<?php
if( $category = selectDBNew("categories",[$_POST["categoryId"]],"`status` = '0' AND `hidden` = '1' AND `id` = ?","") ){
	$categoyTitle = direction($category[0]["enTitle"],$category[0]["arTitle"]);
}else{
	?>
	<script>
		alert('<?php echo direction("Could not process your request, Please try again","حدث خطأ أثناء عملية الطلب, يرجى المحاولة مرة أخرى"); ?>');
		window.location.href = 'index.php?v=Home';
	</script>
	<?php
}
if( $area = selectDBNew("areas",[$_POST["areaId"]],"`status` = '0' AND `hidden` = '0' AND `id` = ?","") ){
	$areaTitle = direction($area[0]["enTitle"],$area[0]["arTitle"]);
}else{
	?>
	<script>
		alert('<?php echo direction("Could not process your request, Please try again","حدث خطأ أثناء عملية الطلب, يرجى المحاولة مرة أخرى"); ?>');
		window.location.href = 'index.php?v=Home';
	</script>
	<?php
}
if( isset($_POST["from"]) && !empty($_POST["from"]) && isset($_POST["to"]) && !empty($_POST["to"]) ){
	$price = " AND `price` BETWEEN '{$_POST["from"]}' AND '{$_POST["to"]}' ";
}elseif( isset($_POST["from"]) && !empty($_POST["from"]) ){
	$price = " AND `price` >= '{$_POST["from"]}' ";
}elseif( isset($_POST["to"]) && !empty($_POST["to"]) ){
	$price = " AND `price` <= '{$_POST["to"]}' ";
}else{
	$price = "";
}
if( isset($_POST["propertyType"]) && !empty($_POST["propertyType"]) ){
	$propertyType = " AND `propertyType` = '{$_POST["propertyType"]}' ";
}else{
	$propertyType = "";
}
if( $ads = selectDBNew("products",[$_POST["categoryId"],$_POST["areaId"]],"`status` = '0' AND `hidden` != '2' AND `categoryId` = ? AND `areaId` = ? {$price} {$propertyType} ORDER BY `packageId` DESC,`id` DESC","") ){
}
?>
<div class="search-ads-options mb-3">
	<div class="div">
		<span class="title"><?php echo Trans('app','Search Options'); ?></span>
	</div> 
	<div class="div">
		<span class="title"><?php echo Trans('app','Type'); ?></span>
		<span class="data">
			<span><?php echo $categoyTitle; ?><span> 
		</span>
	</div>
	<div class="div">
		<span class="title"><?php echo Trans('app','Region'); ?></span>
		<span class="data">
			<span><?php echo $areaTitle; ?></span>
		</span>
	</div>
</div>

<div class="search-title mb-3 mt-2">  
	<h4><i class="bi bi-search"></i><?php echo Trans('app','Search Result'); ?><span><?php echo count($ads) . " " .Trans('app','Ad'); ?></span></h4>
</div>

<div class="ads-section">
	<?php include 'template/adsMainList.php'; ?>
	<div class="d-block text-end mt-3">
	<?php /*<a href="" class="btn btn-primary"><?php echo Trans('app','More'); ?> ...</a>*/?>
	</div>
</div>