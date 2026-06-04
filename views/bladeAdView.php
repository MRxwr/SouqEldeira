<?php
if( isset($_GET['id']) && $ad = selectDBNew("products",[$_GET['id']],"`id` = ?","") ){
	$AdUser = selectDBNew("users",[$ad[0]["userId"]],"`id` = ? AND `status` = '0'","");
	$mobile = ( !empty($ad[0]["mobile"]) ) ? $ad[0]["mobile"] : $AdUser[0]["phone"];
	$area = selectDBNew("areas",[$ad[0]['areaId']],"`id` = ?","");
	updateDB("products",["views" => $ad[0]['views'] + 1],"`id` = {$_GET["id"]}");
	$ad[0]["views"] = $ad[0]['views'] + 1;
}else{
	?>
	<script>
		alert("Could not process your request, Please try again.");
		window.location = "index.php?v=Home";
	</script>
	<?php
}
?>
<h4 class="mb-md-5 mb-3 text-center ad-title"><?php echo direction($ad[0]['enTitle'], $ad[0]['arTitle']); ?></h4>
	        
<div class="ad-top-details p-3 mb-4">
	<div class="row">
        <div class="col-sm-4">
        	<div class="ad-top-details-items">
                <div class=""> <span class="sp1"><i class="bi bi-geo-alt"></i></span>        <span class="sp2"><?php echo direction($area[0]['enTitle'], $area[0]['arTitle']); ?></span></div>
                <div class=""> <span class="sp1"><?php echo direction("Price","السعر"); ?></span>  <span class="sp2"><?php echo $ad[0]['price'] . "-/KD"; ?></span></div>
            </div>
        </div>
        <div class="col-sm-1">
        </div>
        <div class="col-sm-7">  
        	<div class="ad-top-details-items">
                <div class="favo" id="<?php echo $ad[0]['id']; ?>"><span class="sp1"><i class="bi bi-heart"></i> </span> <span class="sp2"><?php echo direction("Favourite","المفضلة"); ?></span></div>
                <div class=""><span class="sp1"><i class="bi bi-clock"></i> </span>
					<span class="sp2">
						<?php
						$adDate = new DateTime($ad[0]['date']);
						$now = new DateTime();
						$diff = $now->diff($adDate);
						$hours = $diff->h + ($diff->days * 24);
						echo substr($ad[0]['date'], 0, 10) . " " . direction("Hours","ساعات");
						?>
					</span>
				</div>
                <div class=""><span class="sp1"><i class="bi bi-eye"></i>   </span> <span class="sp2"><?php echo $ad[0]['views'] ?></span></div>
                <div class="share" id="<?php echo "{$_SERVER['REQUEST_URI']}?v=AdView&id={$ad[0]['id']}" ?>"><span class="sp1"><i class="bi bi-share"></i> </span> <span class="sp2"><?php echo direction("Share","مشاركة"); ?></span></div>
            </div> 
        </div>
	</div>
</div>
	         
<div class="ad-details"> 
	<div class="row">
        <div class="col-sm-6"> 
        	<h5 class="fw-bold"><?php echo direction("Description","الوصف"); ?></h5>
        	<p><?php echo direction($ad[0]['enDetails'], $ad[0]['arDetails']); ?></p>
            <div class="contact">
            	<a href="https://wa.me/<?php 
$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$msg = urlencode("أريد أن أسأل عن هذا الإعلان\n$url");	echo "{$mobile}?text={$msg}"; ?>" class="btn btn-default btn-border-radius-1 py-2 btn-wts"><i class="bi bi-whatsapp"></i></a>
            	<a href="tel:<?php echo $mobile; ?>" class="btn btn-default btn-border-radius-1 py-2 btn-call"><i class="bi bi-telephone"></i> <?php echo direction("Call","اتصل"); ?></a>   
            </div>
        </div>
        <div class="col-sm-6">
        	<div id="carouselExampleCaptions" class="ad-in-view-carousel carousel slide" data-bs-ride="carousel">
			  <div class="carousel-inner">
			  	<?php
			  	if( $images = selectDB("images","`productId` = '".$ad[0]['id']."'") ){
					for( $j = 0; $j < sizeof($images); $j++ ){
						if( $j == 0 ){
							$active = "active";
						}else{
							$active = "";
						}
						?>
						<div class="carousel-item <?php echo $active ?>">      
					       <a href="logos/<?php echo $images[$j]["imageurl"] ?>" data-toggle="lightbox" data-gallery="mixedgallery">
					            <img src="logos/<?php echo $images[$j]["imageurl"] ?>" class="d-block w-100 h-100" alt="...">
					       </a>
					    </div>
						<?php
					}
				}
				?>
			  </div>
			  
			  <!-- Slider Buttons-->
			  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
			    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
			    <span class="visually-hidden">Previous</span>
			  </button>
			  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
			    <span class="carousel-control-next-icon" aria-hidden="true"></span>
			    <span class="visually-hidden">Next</span>
			  </button>
			  <!--Slider Thumbnails-->
			  <div class="carousel-indicators">
				<?php
				if( $images = selectDB("images","`productId` = '".$ad[0]['id']."'") ){
					for( $j = 0; $j < sizeof($images); $j++ ){
						if( $j == 0 ){
							$active = "active";
						}else{
							$active = "";
						}
						?>
						<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?php echo $j ?>" class="<?php echo $active ?>" aria-current="true" aria-label="Slide <?php echo $j ?>"><img class="d-block w-100" src="logos/<?php echo $images[$j]["imageurl"] ?>" class="img-fluid"></button>
						<?php
					}
				}
			    ?>
			  </div> 
			</div>
        </div>
    </div>
 </div>
	 
<hr>

<div class="listings-section"> 
  <h4 class="text-start mt-2 mb-3"><?php echo direction("From the same region","من نفس المنطقة"); ?></h4>
  <?php
  if( $ads = selectDB("products","`status` = '0' AND `hidden` = '1' AND `areaId` = {$ad[0]["areaId"]} AND `id` != {$ad[0]["id"]} ORDER BY `packageId` DESC,`id` DESC LIMIT 3") ){
  	include 'template/adsMainList.php';
  }
  ?>
  <div class="d-block text-end mt-3">
  	 <a href="?v=Search&type=<?php echo $ad[0]["categoryId"] ?>" class="btn btn-primary"><?php echo direction("More","المزيد"); ?> <i class="bi bi-three-dots"></i></a>
  </div> 
</div>