<div class="ads-main-list">
	<div class="row gy-3"> 
		<div class="col-lg-12">
			<a style="cursor: pointer" class="card card-ad card-feature" data-bs-toggle="modal" data-bs-target="#ad_modal">
				<div class="row g-0"> 
					<div class="col-4 col-sm-3 position-relative">
						<span class="feature-label"><?php echo Trans('app','Feature'); ?></span> 
						<div id="carouselAdMainImages" class="carousel slide" data-bs-ride="carousel">
						<div class="carousel-indicators">
							<button type="button" data-bs-target="#carouselAdMainImages" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
							<button type="button" data-bs-target="#carouselAdMainImages" data-bs-slide-to="1" aria-label="Slide 2"></button>
							<button type="button" data-bs-target="#carouselAdMainImages" data-bs-slide-to="2" aria-label="Slide 3"></button>
						</div>
						<div class="carousel-inner">
							<div class="carousel-item active">
							<object>
								<a href="assets/img/items/item.png" data-toggle="lightbox" data-gallery="mixedgallery">
									<img src="assets/img/items/item.png" class="d-block w-100 h-100" alt="...">
								</a> 
							</object> 
							</div>
							<div class="carousel-item">
							<object>
								<a href="assets/img/items/item-2.png" data-toggle="lightbox" data-gallery="mixedgallery">
									<img src="assets/img/items/item-2.png" class="d-block w-100 h-100" alt="...">
								</a> 
							</object> 
							</div>
							<div class="carousel-item">
							<object>
								<a href="assets/img/items/item-3.png" data-toggle="lightbox" data-gallery="mixedgallery"> 
									<img src="assets/img/items/item-3.png" class="d-block w-100 h-100" alt="...">
								</a> 
							</object> 
							</div>
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
							<h5 class="card-title fw-bold"><?php echo Trans('app','A house for rent in Abu Fetera'); ?></h5>
							<p class="card-text"><?php echo Trans('app','ad-desc'); ?></p>
							<p class="card-price">1500 <?php echo Trans('app','DK'); ?></p>
							<hr>
							<div class="card-body-btn">
								<span class=""><i class="bi bi-heart"></i> <?php echo Trans('app','Favourite'); ?></span>
								<span class=""><i class="bi bi-clock"></i> 2 <?php echo Trans('app','Hours'); ?></span>
								<span class=""><i class="bi bi-eye"></i>54</span>
							</div>
						</div>
					</div>
				</div>
			</a>
		</div>
		<div class="col-lg-12">
			<a href="?v=AdView" class="card card-ad">
			<div class="row g-0">
				<div class="col-4 col-sm-3 position-relative">
					<img src="assets/img/items/item.png" class="card-img h-100" alt="...">
				</div>
				<div class="col-8 col-sm-9">
					<div class="card-body">
						<h5 class="card-title fw-bold"><?php echo Trans('app','A house for rent in Abu Fetera'); ?></h5>
						<p class="card-text"><?php echo Trans('app','ad-desc'); ?></p>
						<p class="card-price">1500 <?php echo Trans('app','DK'); ?></p>
						<hr>
						<div class="card-body-btn">
							<span class=""><i class="bi bi-heart"></i> <?php echo Trans('app','Favourite'); ?></span>
							<span class=""><i class="bi bi-clock"></i> 2 <?php echo Trans('app','Hours'); ?></span>
							<span class=""><i class="bi bi-eye"></i>54</span>
						</div>
					</div>
				</div>
			</div>
			</a>
		</div>
		<div class="col-lg-12">
			<a href="?v=AdView" class="card card-ad">
			<div class="row g-0"> 
				<div class="col-4 col-sm-3 position-relative">
					<img src="assets/img/items/item.png" class="card-img h-100" alt="...">
				</div>
				<div class="col-8 col-sm-9">
					<div class="card-body">
						<h5 class="card-title fw-bold"><?php echo Trans('app','A house for rent in Abu Fetera'); ?></h5>
						<p class="card-text"><?php echo Trans('app','ad-desc'); ?></p>
						<p class="card-price">1500 <?php echo Trans('app','DK'); ?></p>
						<hr>
						<div class="card-body-btn">
							<span class=""><i class="bi bi-heart"></i> <?php echo Trans('app','Favourite'); ?></span>
							<span class=""><i class="bi bi-clock"></i> 2 <?php echo Trans('app','Hours'); ?></span>
							<span class=""><i class="bi bi-eye"></i>54</span>
						</div>
					</div>
				</div>
			</div>
			</a>
		</div>
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
        <?php require_once 'views/bladeAdView.php';  ?>   
        </div>  
      </div>
    </div> 
  </div>
</div>