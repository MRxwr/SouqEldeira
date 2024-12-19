
    		 
    		 
    	
	        <div class="alert alert-primary welcome-message responsive" role="alert">
			   <i class="bi bi-exclamation-circle"></i> <?php echo Trans('app','A message from the manager to manage the website'); ?>
			</div>  
    		 
    		<form class="" action="search-view.php">
    		<div class="search-area-row"> 
    			 
    			<div class="row">
    				
    				<div class="main-radio-btn">
			  		    
				  		<div class="radio-btn">
					  		<input type="radio" id="aSale" name="propertyType" checked />
					  		<label for="aSale"><?php echo Trans('app','Sale'); ?></label>
					  	</div>
					  	
					  	<div class="radio-btn">
					  		<input type="radio" id="aRent" name="propertyType" />
					  		<label for="aRent"><?php echo Trans('app','Rent'); ?></label>
					  	</div>
					  	
					  	<div class="radio-btn">
					  		<input type="radio" id="aAllowance" name="propertyType" />
					  		<label for="aAllowance"><?php echo Trans('app','Allowance'); ?></label>
					  	</div>
					  	
					  	<div class="radio-btn"> 
					  		<input type="radio" id="aRequest" name="propertyType" />
					  		<label for="aRequest"><?php echo Trans('app','Request'); ?></label>
					  	</div>
				  	
				 	</div>
			 	
			
    			</div>
    			
    			<div class="row">
    				
    				<div class="col-md-4">
    				  
    				  <div class="form-outline mt-4"> 
	    				  <div class="input-group input-group-select-with-icon">  
							  <label class="input-group-text labelIcon" for=""><i class="bi bi-geo-alt"></i></label>
							  <select class="form-select" name="propertyRegion" aria-label="Property Region">
							    <option selected><i class="bi bi-geo-alt"></i> <?php echo Trans('app','Area or Region'); ?></option>
							    <option value="1"><?php echo Trans('app','Area 1'); ?></option>
						  		<option value="2"><?php echo Trans('app','Area 2'); ?></option> 
						  		<option value="3"><?php echo Trans('app','Area 3'); ?></option>
						  		<option value="4"><?php echo Trans('app','Area 4'); ?></option>
							  </select>
						  </div>
					  </div>	
    					 
			        
			        </div>
			         
			        <div class="col-md-4">
			          <div class="form-outline mt-4">
				        <div class="input-group input-group-select-with-icon">  
							  <label class="input-group-text labelIcon" for=""><i class="bi bi-building"></i></label>
							  <select class="form-select" name="propertyType" aria-label="Properity Type">
							    <option selected><i class="bi bi-building"></i> <?php echo Trans('app','Properity Type'); ?></option>
							    <option value="1"><?php echo Trans('app','Sale'); ?></option>
						  		<option value="2"><?php echo Trans('app','Allowance'); ?></option> 
						  		<option value="3"><?php echo Trans('app','Rent'); ?></option>
						  		<option value="4"><?php echo Trans('app','Request'); ?></option>
							  </select>
						</div> 
				      </div>
			        </div>
			        
			         <div class="col-6 col-md-4">
			          <div class="form-outline mt-4">
				        <button type="submit" class="btn btn-primary btn-block w-100"> <?php echo Trans('app','Search Now'); ?> &nbsp; &nbsp; <i class="bi bi-search"></i></button>
				      </div>
			        </div>
			        
			        <div class="col-6 col-md-12">
			        	<div class="form-outline mt-3 advanced-search">  
			        	<a href="#!" class="advanced-search-a"><i class="bi bi-sliders"></i><span class="fw-bold"><?php echo Trans('app','Advanced Search'); ?></span></a>
			        	</div>
			        </div>
			       
    			</div>
    			
    			<div class="advanced-search-view">
        			<div class="row mt-3">   
				         <div class="col-6 col-md-6">
					         <div class="form-outline"> 
						        <input type="text" class="form-control" name="propertyPriceFrom" placeholder="<?php echo Trans('app','Price From'); ?>">
						     </div>
					     </div>
					      <div class="col-6 col-md-6">
					         <div class="form-outline">
						        <input type="text" class="form-control" name="propertyPriceTo" placeholder="<?php echo Trans('app','Price To'); ?>">
						     </div> 
					     </div>
			        </div> 
		        </div>
    			
    		</div>
    		</form>
    		
    	</div> 
        
        <div class="homePageSecondContent my-3">
        	<div class="container container-project">
		        <div class="alert alert-primary welcome-message" role="alert">
				   <i class="bi bi-exclamation-circle"></i> <?php echo Trans('app','A message from the manager to manage the website'); ?>
				</div>
			</div>
        </div>	
        	
        <div class="container container-project">
        	
	        
			
			<div class="ads-section">
			  <h4 class="mb-3"><?php echo Trans('app','Latest ads for sale'); ?></h4>		  
			  <?php require_once('template/adsMainList.php?type=1'); ?>
			  <div class="d-block text-end mt-3">
			  	<a href="" class="btn btn-primary"><?php echo Trans('app','More'); ?> ...</a>
			  </div>
			</div>
			
			<div class="ads-section">
			  <h4 class="mb-3"><?php echo Trans('app','For rent the latest ads'); ?></h4>		  
			  <?php require_once('template/adsMainList.php?type=1'); ?> 
			  <div class="d-block text-end mt-3">
			  	<a href="" class="btn btn-primary"><?php echo Trans('app','More'); ?> <i class="bi bi-three-dots"></i> </a>
			  </div>
			</div>
			
			<div class="ads-section">
			  <h4 class="mb-3"><?php echo Trans('app','For the latest ads allowance'); ?></h4>		  
			  <?php require_once('template/adsMainList.php?type=1'); ?> 
			  <div class="d-block text-end mt-3">
			  	<a href="" class="btn btn-primary"><?php echo Trans('app','More'); ?> <i class="bi bi-three-dots"></i> </a>
			  </div>
			</div>
			
			<div class="ads-section">
			  <h4 class="mb-3"><?php echo Trans('app','To request the latest announcements'); ?></h4>		  
			  <?php require_once('template/adsMainList.php?type=1'); ?> 
			  <div class="d-block text-end mt-3">
			  	<a href="" class="btn btn-primary"><?php echo Trans('app','More'); ?> <i class="bi bi-three-dots"></i> </a>
			  </div>
			</div>
			
		</div> 
		
		
		<div class="home-about">
			<div class="left-bg"></div>
			<div class="right-bg"></div>
			<div class="container container-project">
				<div class="row">
					<div class="col-md-12 text-center">
						<img src="assets/img/logo-white.png" class="img-fluid logo">
						<br>
						<p><?php echo Trans('app','about-txt-1'); ?></p>
					</div>
				</div>
			</div> 
		</div> 
		
		<!--  Demos -->
	    <div class="demos">
	    	<div class="container container-projectX"> 
	    		
	    		<div class="mt-5">
	    			
		    	<h3 class="fw-bold text-center mb-5"><?php echo Trans('app','Real estate offices in Kuwait'); ?></h3> 
		        	
		        <div class="owl-carousel owl-carousel-offices owl-theme">
				    <div class="item"><a href="office-view.php"><img src="assets/img/offices/office-1.png"></a></div>
				    <div class="item"><a href="office-view.php"><img src="assets/img/offices/office-2.png"></a></div>
				    <div class="item"><a href="office-view.php"><img src="assets/img/offices/office-3.png"></a></div>
				    <div class="item"><a href="office-view.php"><img src="assets/img/offices/office-1.png"></a></div>
				    <div class="item"><a href="office-view.php"><img src="assets/img/offices/office-2.png"></a></div>
				    <div class="item"><a href="office-view.php"><img src="assets/img/offices/office-3.png"></a></div>
				    <div class="item"><a href="office-view.php"><img src="assets/img/offices/office-1.png"></a></div>
				    <div class="item"><a href="office-view.php"><img src="assets/img/offices/office-2.png"></a></div>
				    <div class="item"><a href="office-view.php"><img src="assets/img/offices/office-3.png"></a></div>
				</div>
				</div>
				
		    </div>
		</div>

