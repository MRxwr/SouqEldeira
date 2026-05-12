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
					<div class="row g-0 align-items-center"> 
						<div class="col-4 col-sm-3 position-relative">
							<?php if( $ad["packageId"] == 2 ){ ?><span class="feature-label"><?php echo Trans('app','Feature'); ?></span> <?php } ?>
							<div id="carouselAdMainImages<?php echo $ad['id']; ?>" class="carousel slide h-100" data-bs-ride="carousel" style="height: 120px; overflow: hidden;">
							<div class="carousel-indicators" style="position: absolute; bottom: 5px; left: 0; right: 0; margin: 0; padding: 0; z-index: 15; justify-content: center; display: flex;">
								<?php 
								if( $images = selectDB("images","`productId` = '".$ad['id']."'") ){
									for( $j = 0; $j < sizeof($images); $j++ ){
										if( $j == 0 ){
											$active = "active";
										}else{
											$active = "";
										}
										?>
										<button type="button" data-bs-target="#carouselAdMainImages<?php echo $ad['id']; ?>" data-bs-slide-to="<?php echo $j ?>" class="<?php echo $active ?>" aria-current="true" aria-label="Slide <?php echo $j ?>" style="width: 6px; height: 6px; border-radius: 50%; margin: 0 3px; border: none; opacity: 0.5; background-color: #fff;"></button>
										<?php
									}
								}
								?>
							</div>
							<div class="carousel-inner h-100">
								<?php
								if( $images = selectDB("images","`productId` = '".$ad['id']."'") ){
									for( $z = 0; $z < sizeof($images); $z++ ){
										if( $z == 0 ){
											$active = "active";
										}else{
											$active = "";
										}
										?>
										<div class="carousel-item <?php echo $active ?> h-100">
											<a href="?v=AdView&id=<?php echo $ad["id"] ?>" data-toggle="lightbox" data-gallery="mixedgallery">
												<img src="logos/<?php echo $images[$z]["imageurl"] ?>" class="d-block w-100 h-100" style="object-fit: cover; height: 120px;" alt="...">
											</a> 
										</div>
										<?php
									}
								}
								?>
							</div>
							</div>	
						</div>
						<div class="col-8 col-sm-9">
							<div class="card-body px-3">
								<h5 class="card-title fw-bold"><?php echo direction($ad['enTitle'],$ad['arTitle']); ?></h5>
								<p class="card-text"><?php echo substr(direction($ad['enDetails'],$ad['arDetails']),0,100) ?></p>
								<p class="card-price"><?php echo $ad['price'] . "-/KD"; ?></p>
								<hr>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="col-lg-12 m-0 text-center">
				<div class="card card-ad card-body-btn">
					<div class="row">
						<div class="col-4">
							<?php
							if( is_null($ad['listOfUsers']) ){
								$color = "";
							}else{
								$listOfUsers = json_decode($ad['listOfUsers'],true);
								if( in_array($userDetails["id"],$listOfUsers) ){
									$color = "color:red";
								}else{
									$color = "";
								}
							}
							?>
							<span class="favo" id="<?php echo $ad['id']; ?>">
								<i class="bi bi-heart favo<?php echo $ad['id']; ?>" style="<?php echo $color; ?>" ></i> 
								<?php echo Trans('app','Favourite'); ?>
							</span>
						</div>
						<div class="col-4">
							<span class="">
								<i class="bi bi-clock"></i>
								<?php
									$adDate = new DateTime($ad['date']);
									$now = new DateTime();
									$diff = $now->diff($adDate);
									$hours = $diff->h + ($diff->days * 24);
									echo substr($ad['date'], 0, 10);
								?>
							</span>
						</div>
						<div class="col-4">
							<span class=""><i class="bi bi-eye"></i> <?php echo $ad['views'] ?></span>
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