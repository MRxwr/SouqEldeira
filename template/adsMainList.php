<div class="ads-main-list">
	<div class="row gy-3"> 
	<?php
		foreach( $ads as $ad ){
			if( $ad["packageId"] == 2 ){
				$feature = "card-feature";
			}else{
				$feature = "";
			}
	?>
			<div class="col-lg-12">
				<a style="cursor: pointer" class="card card-ad <?php echo $feature; ?>" <?php /*data-bs-toggle="modal" data-bs-target="#ad_modal" */?> href="?v=AdView&id=<?php echo $ad['id']; ?>">
					<div class="row g-0"> 
						<div class="col-4 col-sm-3 position-relative">
							<?php if( $ad["packageId"] == 2 ){ ?><span class="feature-label"><?php echo Trans('app','Feature'); ?></span> <?php } ?>
							<div id="carouselAdMainImages" class="carousel slide" data-bs-ride="carousel">
							<div class="carousel-indicators">
								<?php 
								if( $images = selectDB("images","`productId` = '".$ad['id']."'") ){
									for( $j = 0; $j < sizeof($images); $j++ ){
										if( $j == 0 ){
											$active = "active";
										}else{
											$active = "";
										}
										?>
										<button type="button" data-bs-target="#carouselAdMainImages" data-bs-slide-to="<?php echo $j ?>" class="<?php echo $active ?>" aria-current="true" aria-label="Slide <?php echo $j ?>"></button>
										<?php
									}
								}
								?>
							</div>
							<div class="carousel-inner">
								<?php
								if( $images = selectDB("images","`productId` = '".$ad['id']."'") ){
									for( $z = 0; $z < sizeof($images); $z++ ){
										if( $z == 0 ){
											$active = "active";
										}else{
											$active = "";
										}
										?>
										<div class="carousel-item <?php echo $active ?>">
										<object>
											<a href="?v=AdView&id=<?php echo $ad["id"] ?>" data-toggle="lightbox" data-gallery="mixedgallery">
												<img src="logos/<?php echo $images[$z]["imageurl"] ?>" class="d-block w-100 h-100" alt="...">
											</a> 
										</object> 
										</div>
										<?php
									}
								}
								?>
							</div>
							<button class="carousel-control-prev" type="button" data-bs-target="#carouselAdMainImages" data-bs-slide="prev">
								<span class="carousel-control-prev-icon" aria-hidden="true"></span>
								<span class="visually-hidden">Previous</span>
							</button>
							<button class="carousel-control-next" type="button" data-bs-target="#carouselAdMainImages" data-bs-slide="next">
								<span class="carousel-control-next-icon" aria-hidden="true"></span>
								<span class="visually-hidden">Next</span>
							</button>
							</div>	
						</div>
						
						<div class="col-8 col-sm-9">
							<div class="card-body">
								<h5 class="card-title fw-bold"><?php echo direction($ad['enTitle'],$ad['arTitle']); ?></h5>
								<p class="card-text"><?php echo substr(direction($ad['enDetails'],$ad['arDetails']),0,100) ?></p>
								<p class="card-price"><?php echo $ad['price'] . "-/KD"; ?></p>
								<hr>
								</a>
								<div class="card-body-btn">
									<span class="favo" id="<?php echo $ad['id']; ?>"><i class="bi bi-heart favo<?php echo $ad['id']; ?>" ></i> <?php echo Trans('app','Favourite'); ?></span>
									<span class="">
										<i class="bi bi-clock"></i>
										<?php
											$adDate = new DateTime($ad['date']);
											$now = new DateTime();
											$diff = $now->diff($adDate);
											$hours = $diff->h + ($diff->days * 24);
									 		echo substr($ad['date'], 0, 10); ?>
									 </span>
									<span class=""><i class="bi bi-eye"></i> <?php echo $ad['views'] ?></span>
								</div>
							</div>
						</div>
					</div>
				
			</div>
			<?php
		}
	?>
</div>
</div>


<div class="modal modal-bottom fade" id="ad_modal" tabindex="-1" aria-labelledby="ad_modal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header"> 
          <h5 class="modal-title text-center d-block w-100" id="exampleModalLabel"><?php echo Trans('app','A house for rent in Abu Fetera'); ?></h5>
          <a class="btn-close-modal" data-bs-dismiss="modal" aria-label="Close"> <i class="bi bi-chevron-left"></i> </a>  
      </div>
      <div class="modal-body">
      	<div class="container container-project">
        <?php /*require_once 'views/bladeAdView.php'; */ ?>   
        </div>  
      </div>
    </div> 
  </div>
</div>