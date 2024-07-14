
<?php include 'layouts/start.php'; ?> 

        <?php include 'layouts/header.php'; ?> 
        
        <div class="page-content my-5">
        
        <div class="container container-project">
		   <?php include 'layouts/alert.php'; ?>
		   <div class="offices-list"> 
				<div class="row d-flex align-items-stretch gy-3 gx-2">
					<div class="col-md-12"> 
							<div class="start-page-title text-center mb-md-4 py-md-3 mt-1 mt-md-0">
								<h4 class="mb-0"><?php echo Trans('app','Offices List'); ?></h4>
							</div>
					</div>
				</div>
			</div>
			<div class="offices-list"> 

			  <div class="row d-flex align-items-stretch gy-3 gx-2 load-ajax-call" id="LatestAdsForOffices" data-type="SALE" data-endpoint="offices">
			  	<div class="col-6 col-lg-4">
			  		<div class="card card-office text-center">
					  <a class="card-img" href="office-view.php">
					  	<img src="assets/img/offices/office-1-2.png" class="img-fluid">
					  </a>
					  <div class="card-body">
					    <h5 class="card-title fw-bold"><a href="office-view.php"><?php echo Trans('app','Saleh al-Attal real estate company'); ?></a></h5>
					    <div class="card-social">
					    	<ul>
					    		<li><a href=""><i class="bi bi-facebook"></i></a></li>
					    		<li><a href=""><i class="bi bi-twitter-x"></i></a></li>
					    		<li><a href=""><i class="bi bi-instagram"></i></a></li>
					    		<li><a href=""><i class="bi bi-envelope"></i></a></li>
					    	</ul>
					    </div>
					    <div class="mx-0"> 
					    	<a href="#" class="btn btn-primary w-100"><i class="bi bi-telephone-fill mx-2"></i><?php echo Trans('app','Call'); ?></a>
					    </div>
					  </div>
					</div>
				</div>
				
			   <div class="col-6 col-lg-4">
			  		<div class="card card-office text-center">
					  <a class="card-img" href="office-view.php">
					  	<img src="assets/img/offices/office-1-1.png" class="img-fluid">
					  </a>
					  <div class="card-body">
					    <h5 class="card-title fw-bold"><a href="office-view.php"><?php echo Trans('app','Saleh al-Attal real estate company'); ?></a></h5>
					    <div class="mx-0">
					    	<a href="#" class="btn btn-primary w-100"><i class="bi bi-telephone-fill mx-2"></i><?php echo Trans('app','Call'); ?></a>
					    </div>
					  </div>
					</div>
				</div>
				
				<div class="col-6 col-lg-4">
			  		<div class="card card-office text-center">
					  <a class="card-img" href="office-view.php">
					  	<img src="assets/img/offices/office-1-2.png" class="img-fluid">
					  </a>
					  <div class="card-body">
					    <h5 class="card-title fw-bold"><a href="office-view.php"><?php echo Trans('app','Saleh al-Attal real estate company'); ?></a></h5>
					    <div class="card-social">
					    	<ul>
					    		<li><a href=""><i class="bi bi-facebook"></i></a></li>
					    		<li><a href=""><i class="bi bi-twitter-x"></i></a></li>
					    		<li><a href=""><i class="bi bi-instagram"></i></a></li>
					    		<li><a href=""><i class="bi bi-envelope"></i></a></li>
					    	</ul>
					    </div>
					    <div class="mx-0"> 
					    	<a href="#" class="btn btn-primary w-100"><i class="bi bi-telephone-fill mx-2"></i><?php echo Trans('app','Call'); ?></a>
					    </div>
					  </div>
					</div>
				</div>

			   <div class="col-6 col-lg-4">
			  		<div class="card card-office text-center">
					  <a class="card-img" href="office-view.php">
					  	<img src="assets/img/offices/office-1-1.png" class="img-fluid">
					  </a>
					  <div class="card-body">
					    <h5 class="card-title fw-bold"><a href="office-view.php"><?php echo Trans('app','Saleh al-Attal real estate company'); ?></a></h5>
					    <div class="mx-0">
					    	<a href="#" class="btn btn-primary w-100"><i class="bi bi-telephone-fill mx-2"></i><?php echo Trans('app','Call'); ?></a>
					    </div>
					  </div> 
					</div>
				</div>
			  </div>
			</div>
		</div>
		 
        </div> 
      
<?php include 'layouts/footer.php'; ?> 
<?php include 'layouts/end.php'; ?> 