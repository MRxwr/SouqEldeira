<?php
if ( $offices = selectDBNew("shops",[$_GET["id"]],"`id` = ? AND `status` = '0'","")){
}else{
	$message = direction("Office not found","المكتب غير موجود");
	?>
	<script>
		alert("<?php echo $message; ?>");
		window.location = "?v=Offices";
	</script>
	<?php
}
?>
<div class="row">
	<div class="col-lg-4">
		<div class="office-profile-side with-white-bg px-md-4 py-md-4">
			<div class="card card-office text-center">
				<a class="card-img" href="#">
				<img src="/logos/<?php echo $offices[0]["logo"]; ?>" class="img-fluid">
				</a>
				<div class="card-body">
				<h5 class="card-title fw-bold"><a href="#"><?php echo direction($offices[0]["enTitle"],$offices[0]["arTitle"]); ?></a></h5>
				<div class="card-social"> 
					<ul>
				<?php 
				$arraySMIcons = ["bi bi-facebook","bi bi-twitter-x","bi bi-instagram","bi bi-envelope"];
				$arrayLinks = ["https://www.facebook.com/","https://www.twitter.com/","https://www.instagram.com/","mailto:"]; 
				$arraySM = ["facebook","twitter","instagram","email"];
				for( $j = 0; $j < sizeof($arraySMIcons); $j++ ){
					if( !empty($offices[0][$arraySM[$j]]) ){
					?>
					<li><a href="<?php echo $arrayLinks[$j] . $offices[0][$arraySM[$j]]; ?>"><i class="<?php echo $arraySMIcons[$j]; ?>"></i></a></li>
					<?php
					}
				}
				?>
					</ul>
				</div>
				<div class="mx-0"> 
					<a href="<?php echo $offices[0]["url"]; ?>" class="webURL w-100">
						<i class="bi bi-link-45deg mx-2"></i> 
						<span><?php echo $offices[0]["url"]; ?></span>
					</a>
				</div>
				
				<div class="office-side-desc">  
					<div class="office-description my-3"> 
						<h3 class="mb-2"><?php echo direction("Description","الوصف"); ?></h3>
						<p><?php echo direction($offices[0]["enDetails"],$offices[0]["arDetails"]); ?></p> 
					</div>
					<div class="mx-0"> 
						<a href="tel:<?php echo $offices[0]["mobile"]; ?>" class="btn btn-primary px-4"><i class="bi bi-telephone-fill mx-2"></i><?php echo direction("Call","اتصل"); ?></a>
					</div>
				</div>
				</div>
			</div> 
		</div>
	</div>
	
	<div class="col-lg-8">
		<div class="with-white-bg px-md-4 px-2 py-4 mt-md-0 mt-4"> 
			<div class="list-title mb-3"> 
				<h4><?php echo direction("Office Ads","إعلانات المكتب"); ?></h4> 
			</div>
			<div class="listings-section">
				<?php
				if( $ads = selectDB("products","`status` = '0' AND `hidden` = '1' AND `shopId` = {$offices[0]["id"]} ORDER BY `packageId` DESC,`id` DESC") ){
					include 'template/adsMainList.php';
				}
				?>
				<div class="d-block text-end mt-3">
				<?php /* <a href="?v=AdsList" class="btn btn-primary"><?php echo direction("More","المزيد"); ?> <i class="bi bi-three-dots"></i></a> */ ?>
				</div>
			</div>
		</div> 
	</div>
</div>
