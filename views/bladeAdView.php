<?php
if( isset($_GET['id']) && $ad = selectDBNew("products",[$_GET['id']],"`id` = ?","") ){
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
                <div class=""> <span class="sp1"><i class="bi bi-geo-alt"></i></span>        <span class="sp2"><?php echo Trans('app','El-Gabrya'); ?></span></div>
                <div class=""> <span class="sp1"><?php echo Trans('app','Price'); ?></span>  <span class="sp2"><?php echo $ad[0]['price'] . "-/KD"; ?></span></div>
            </div>
        </div>
        <div class="col-sm-1">
        </div>
        <div class="col-sm-7">  
        	<div class="ad-top-details-items">
                <div class=""><span class="sp1"><i class="bi bi-heart"></i> </span> <span class="sp2"><?php echo Trans('app','Favourite'); ?></span></div>
                <div class=""><span class="sp1"><i class="bi bi-clock"></i> </span> <span class="sp2"><?php echo $ad[0]['date'] ?> <?php echo Trans('app','Hours'); ?></span></div>
                <div class=""><span class="sp1"><i class="bi bi-eye"></i>   </span> <span class="sp2"><?php echo $ad[0]['views'] ?></span></div>
                <div class=""><span class="sp1"><i class="bi bi-share"></i> </span> <span class="sp2"><?php echo Trans('app','Share'); ?></span></div>
            </div>
        </div>
	</div>
</div>
	         
<div class="ad-details"> 
	<div class="row">
        <div class="col-sm-6"> 
        	<h5 class="fw-bold"><?php echo Trans('app','Description'); ?></h5>
        	<p><?php echo direction($ad[0]['enDetails'], $ad[0]['arDetails']); ?></p>
            <div class="contact">
            	<a href="https://wa.me/<?php echo $userDetails['phone']; ?>" class="btn btn-default btn-border-radius-1 py-2 btn-wts"><i class="bi bi-whatsapp"></i></a>
            	<a href="<?php echo $userDetails['phone']; ?>" class="btn btn-default btn-border-radius-1 py-2 btn-call"><i class="bi bi-telephone"></i> <?php echo Trans('app','Call'); ?></a>   
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

<div class="ads-section"> 
  <h4 class="text-start mt-2 mb-3"><?php echo Trans('app','From the same region'); ?></h4>
  <?php include 'template/adsMainList.php'; ?>
  <div class="d-block text-end mt-3">
  	<a href="" class="btn btn-primary"><?php echo Trans('app','More'); ?> <i class="bi bi-three-dots"></i></a>
  </div> 
</div>