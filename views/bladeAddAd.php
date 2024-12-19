
			
			
			
		<div class="row"> 
		<div class="col-md-11 mx-auto">
		<div class="guest-form-action">
		     
		     

			
			    <div class="form-container form-container-add">
			    	
		    	<div class="start-page-title text-center mb-4">
					<h4><?php echo Trans('app','Add Ad'); ?></h4>
			 	</div>
			 	
			    <form id="add-ad-form" class="mt-4">
			
				  
				  <div class="form-outline mb-4">
				  	
				  	<div class="main-radio-btn">
				  		
				  		<div class="radio-btn">
					  		<input type="radio" name="ad-property-type" checked />
					  		<label for="aSale"><?php echo Trans('app','Sale'); ?></label>
					  	</div>
					  	
					  	<div class="radio-btn">
					  		<input type="radio" name="ad-property-type" />
					  		<label for="aAllowance"><?php echo Trans('app','Allowance'); ?></label>
					  	</div>
					  	
				  		<div class="radio-btn">
					  		<input type="radio" name="ad-property-type" />
					  		<label for="aRent"><?php echo Trans('app','Rent'); ?></label>
					  	</div>
					  	
					  	<div class="radio-btn">
					  		<input type="radio" name="ad-property-type" />
					  		<label for="aRequest"><?php echo Trans('app','Request'); ?></label>
					  	</div>
				  	
				 	</div>
				 	
				 </div> 
				 
				 
				  <div class="form-outline mb-4">
				  	<div class="main-radio-btn">			  		
				  		<div class="radio-btn">
					  		<input type="radio" name="ad-type" />
					  		<label for="aRegular"><?php echo Trans('app','Regular Ad'); ?> (1)</label> 
					  	</div>
					  	<div class="radio-btn">
					  		<input type="radio" name="ad-type" checked />
					  		<label for="aSpecial"><?php echo Trans('app','Special Ad'); ?> (9)</label>  
					  	</div>
				 	</div>
				 </div> 
				  
				  <!-- State input -->
			      <div class="form-outline mb-4">
			      	<select class="form-select form-control mb-3" name="ad-state">
					  <option selected><?php echo Trans('app','State'); ?></option>
					  <option value="1"><?php echo Trans('app','State'); ?>-1</option>
					  <option value="2"><?php echo Trans('app','State'); ?>-2</option>
					  <option value="3"><?php echo Trans('app','State'); ?>-3</option>
					</select>
			      </div>
			      
			       <!-- Property type input -->
			      <div class="form-outline mb-4">
			      	<select class="form-select form-control mb-3" name="ad-property-type">
					  <option selected><?php echo Trans('app','Property type'); ?></option>
					  <option value="1"><?php echo Trans('app','Sale'); ?></option>
					  <option value="2"><?php echo Trans('app','Allowance'); ?></option>
					  <option value="3"><?php echo Trans('app','Rent'); ?></option>
					  <option value="4"><?php echo Trans('app','Request'); ?></option>
					</select>
			      </div>
				  
			      <!-- Price input -->
			      <div class="form-outline mb-4">
			        <input type="number"  class="form-control" name="ad-price" placeholder="<?php echo Trans('app','Price'); ?>" />
			      </div>
			
				  <!-- Phone input -->
			      <div class="form-outline mb-4">
			        <input type="text"  class="form-control" name="ad-phone" placeholder="<?php echo Trans('app','Phone Number'); ?>" />
			      </div>
			     
				  <!-- Description input --> 
			      <div class="form-outline mb-3">
			         <textarea class="form-control" style="min-height:100px;"  rows="9" name="ad-description" placeholder="<?php echo Trans('app','Description'); ?>"></textarea>
			      </div>
			      
			      <!-- Description input -->
			      <div class="form-outline mb-4">
			      	 <label class="mb-3"><?php echo Trans('app','Images'); ?></label>
			      	 <div class="add-ad-images">
			      	 	<span>+</span>
			      	 	<span>+</span>
			      	 	<span>+</span>
			      	 	<span>+</span>
			      	 </div>
			      	 <span class="form-hint d-block mt-3"><?php echo Trans('app','Picture size is 1:1 square'); ?></span>
			      </div>
			     
			
			      <!-- Submit button -->
			      <button type="submit" class="btn btn-primary btn-block w-100 mb-3 py-2"><?php echo Trans('app','Add Ad'); ?></button>
			
			      
			      <div class="text-center">  
			      	<p class="add-ad-form-text fw-bold"><?php echo Trans('app','Send us message by'); ?> <a href=""><?php echo Trans('app','WhatsApp'); ?></a> <?php echo Trans('app','or'); ?> <a href="contact.php"><?php echo Trans('app','call us'); ?></a> <?php echo Trans('app','for help'); ?></p>
			      </div> 
				  
			    </form>
				</div>
			 
  
 
		</div>
		</div>
		</div>