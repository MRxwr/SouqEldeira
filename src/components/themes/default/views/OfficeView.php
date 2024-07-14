<?php include 'layouts/start.php'; ?> 
    <?php include 'layouts/header.php'; ?> 
        <div class="page-content my-5">
        <div class="container container-projectx">
		 <?php include 'layouts/alert.php'; ?>
	        <div class="row">
	        	
	        	<div class="col-lg-4">
	        		<div class="office-profile-side with-white-bg px-md-4 py-md-4" id="OfficeView">
	        			
	        			<!-- <div class="card card-office text-center">
						  <a class="card-img" href="office-view">
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
						    	<a href="#" class="webURL w-100">
						    		<i class="bi bi-link-45deg mx-2"></i> 
						    		<span>www.example.com</span>
				    			</a>
						    </div>
						    
						    <div class="office-side-desc">  
							    <div class="office-description my-3"> 
							    	<h3 class="mb-2"><?php echo Trans('app','Description'); ?></h3>
							    	<p><?php echo Trans('app','office-description'); ?></p> 
							    </div>
							    <div class="mx-0"> 
							    	<a href="#" class="btn btn-primary px-4"><i class="bi bi-telephone-fill mx-2"></i><?php echo Trans('app','Call'); ?></a>
							    </div>
						    </div>
						    
						  </div>
						</div>  -->
						
	        		</div>
	        	</div>
	        	
	        	<div class="col-lg-8">
	        		
	        		<div class="with-white-bg px-md-4 px-2 py-4 mt-md-0 mt-4"> 
		        		<div class="list-title mb-3"> 
							<h4><?php echo Trans('app','Office Ads'); ?></h4> 
						</div>
						
						<div class="ads-section">
								<?php include 'sections/ads-main-list.php'; ?>
								<div class="d-block text-end mt-3">
								<a id="OfficeAdsLoad" href="" class="btn btn-primary"><?php echo Trans('app','More'); ?> <i class="bi bi-three-dots"></i></a>
								</div>
							</div>
						</div> 
					</div>
				</div>
			</div>
		</div> 
      
	<?php include 'layouts/footer.php'; ?> 
<?php include 'layouts/end.php'; ?> 