<?php include 'layouts/start.php'; ?> 

        <?php include 'layouts/header.php'; ?> 
        
		<!-- Start page-content -->
		<div class="page-content my-5">
		
		<div class="container container-project">
			
		<?php include 'layouts/alert.php'; ?>
			
		<div class="row"> 
		
		<div class="col-md-11 mx-auto">
		<div class="guest-form-action">
		     
		     

			
			    <div class="form-container form-container-add">
			    	
		    	<div class="start-page-title text-center mb-4">
					<h4><?php echo Trans('app','Add Ad'); ?></h4>
			 	</div>
			 	
			    <form id="add-ad-form" class="mt-4" >
			
				  
				  <div class="form-outline mb-4">
				  	<div class="main-radio-btn" id="saleType">
				 	</div>
				 </div> 
				  <div class="form-outline mb-4">
				  	<div class="main-radio-btn">			  		
				  		<div class="radio-btn">
					  		<input id="aRegular" type="radio" name="is_featured" value="0" />
					  		<label for="aRegular"><?php echo Trans('app','Regular Ad'); ?> (1)</label> 
					  	</div>
					  	<div class="radio-btn">
					  		<input id="aSpecial" type="radio" name="is_featured" value="1" checked />
					  		<label for="aSpecial"><?php echo Trans('app','Special Ad'); ?> (9)</label>  
					  	</div>
				 	</div>
				 </div> 
				  <!-- State input -->
			      <div class="form-outline mb-4">
					  <select class="form-select form-control mb-3" name="propertyRegion" aria-label="Property Region" id="governoratesRegion">
						<option selected><i class="bi bi-geo-alt"></i> <?php echo Trans('app','Area or Region'); ?></option>
					</select>
			      </div>
			      
			       <!-- Property type input -->
			      <div class="form-outline mb-4">
			      	
					  <select class="form-select form-control mb-3" name="propertyType" aria-label="Properity Type" id="buildingType">
						<option selected><i class="bi bi-building"></i> <?php echo Trans('app','Properity Type'); ?></option>
					</select>
			      </div>

				  <!-- Phone input -->
			      <!-- <div class="form-outline mb-4">
			        <input type="text"  class="form-control" id="name" name="name" placeholder="<?php echo Trans('app','Name'); ?>" />
			      </div> -->
				  
			      <!-- Price input -->
			      <div class="form-outline mb-4">
			        <input type="number"  class="form-control" id="price" name="price" placeholder="<?php echo Trans('app','Price'); ?>" />
			      </div>
			
				  <!-- Phone input -->
			      <div class="form-outline mb-4">
			        <input type="text"  class="form-control" id="phone" name="phone" placeholder="<?php echo Trans('app','Phone Number'); ?>" />
			      </div>
			     
				  <!-- Description input --> 
			      <div class="form-outline mb-3">
			         <textarea class="form-control" style="min-height:100px;"  id="description" rows="9" name="description" placeholder="<?php echo Trans('app','Description'); ?>"></textarea>
			      </div>
			      
			      <!-- Description input -->
			      <div class="form-outline mb-4">
			      	 <label class="mb-3"><?php echo Trans('app','Images'); ?></label>
			      	 <div class="add-ad-images" for="fileInput" id="fileInputLabel">
			      	 	<label for="fileI1nputFld" class="images" id="file1Input">+</label>
			      	 	<label for="fileI2nputFld" class="images" id="file2Input">+</label>
			      	 	<label for="fileI3nputFld" class="images" id="file3Input">+</label>
			      	 	<label for="fileI4nputFld" class="images" id="file4Input">+</label>
			      	 </div>
					 <div style="display:none">
					   <input type="file" id="fileI1nputFld">
					   <input type="file" id="fileI2nputFld">
					   <input type="file" id="fileI3nputFld">
					   <input type="file" id="fileI4nputFld">
					</div>
					 
			      	 <span class="form-hint d-block mt-3"><?php echo Trans('app','Picture size is 1:1 square'); ?></span>
			      </div>
			     
			
			      <!-- Submit button -->
			      <button type="submit" class="btn btn-primary btn-block w-100 mb-3 py-2"><?php echo Trans('app','Add Ad'); ?></button>
			
			      
			      <div class="text-center">  
			      	<p class="add-ad-form-text fw-bold"><?php echo Trans('app','Send us message by'); ?> <a href=""><?php echo Trans('app','WhatsApp'); ?></a> <?php echo Trans('app','or'); ?> <a href="contact"><?php echo Trans('app','call us'); ?></a> <?php echo Trans('app','for help'); ?></p>
			      </div> 
				  
			    </form>
				</div>
			 
  
 
		</div>
		</div>
		</div>
		</div>
		</div>   
		<!-- End page-content -->
		
<?php include 'layouts/footer.php'; ?> 
<?php include 'layouts/end.php'; ?> 