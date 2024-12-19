	
			
			<div class="row"> 
				
				<div class="col-md-12"> 
					<div class="start-page-title with-white-bg text-center mb-4 py-3">
						<h4 class="mb-0"><?php echo Trans('app','Profile'); ?></h4>
			 		</div>
				</div>
				
				<div class="col-md-6"> 
					<div class="with-white-bg py-1 px-4">
						
						<form id="profile-form" class="mt-4">
							   
							  <div class="mb-4 text-center">
								<img src="assets/img/profile.png" class="img-fluid" alt="...">
							  </div>
							  
							  <!-- Price input -->
						      <div class="form-outline mb-4">
						        <input type="text" class="form-control" name="username" value="Badr Mahmoud" placeholder="<?php echo Trans('app','Username'); ?>" />
						      </div>
						      
						      <!-- Price input -->
						      <div class="form-outline mb-4">
						        <input type="text" class="form-control" name="phone" value="65680566" placeholder="<?php echo Trans('app','Phone Number'); ?>" />
						      </div>
						      
						      <!-- Price input -->
						      <div class="form-outline mb-4">
						        <input type="text" class="form-control" name="email" value="badertov7@gmail.com" placeholder="<?php echo Trans('app','Email'); ?>" />
						      </div>
						      
						      <div class="form-outline mb-4">
						      	<h5 class="fw-bold mb-3"><?php echo Trans('app','Update Profile Image'); ?></h5>
						      	<div class="change-profile-image">
						      		<span><?php echo Trans('app','Click or drag an account image'); ?></span>
						      		<span><i class="bi bi-image"></i></span>
						      	</div>
						      </div>
						       
						      <div class="form-outline mb-4">
						      	 <h5 class="fw-bold mb-3"><?php echo Trans('app','Social Media Accounts'); ?></h5>
						      	 <div class="row align-items-center g-3">
						      	 	
						      	 	<div class="col-md-6"> 
						      	 		<div class="input-group mb-1">
										  <span class="input-group-text"><i class="bi bi-facebook"></i></span>
										  <input type="text" name="facebook" class="form-control">
										</div>
						        	</div>
						        	
						        	<div class="col-md-6"> 
						      	 		<div class="input-group mb-1">
										  <span class="input-group-text"><i class="bi bi-twitter-x"></i></span>
										  <input type="text" name="twitter" class="form-control">
										</div>
						        	</div>
						        	
						        	<div class="col-md-6"> 
						      	 		<div class="input-group mb-1">
										  <span class="input-group-text"><i class="bi bi-instagram"></i></span>
										  <input type="text" name="instagram" class="form-control">
										</div>
						        	</div>
						        	
						        	<div class="col-md-6"> 
						      	 		<div class="input-group mb-1">
										  <span class="input-group-text"><i class="bi bi-envelope"></i></span>
										  <input type="text" name="email" class="form-control">
										</div>
						        	</div>
						        	
						        	<div class="col-md-12"> 
						      	 		<div class="input-group mb-1">
										  <span class="input-group-text"><i class="bi bi-link"></i></span>
										  <input type="text" name="website" class="form-control">
										</div>
						        	</div>
						        	
						          </div>
						      </div>
						      
						       <!-- Submit button -->
		      				   <button type="submit" class="btn btn-primary btn-block w-100 mb-3 py-2"><?php echo Trans('app','Update Profile'); ?></button>
		    
						      
						</form>
					</div>
				</div>
				
				<div class="col-md-6"> 
					
					<div class="with-white-bg px-4 py-5 mt-4 mt-md-0">    
						
						<h4 class="mb-0"><?php echo Trans('app','Change Password'); ?></h4>
			 				 		
				 		<form id="change-password-form" class="mt-4">
								   
						   
						  <!-- Price input -->
					      <div class="form-outline mb-4">
					        <input type="text" class="form-control" name="password" placeholder="<?php echo Trans('app','Current Password'); ?>" /> 
					      </div>
					      
					       <!-- Price input -->
					      <div class="form-outline mb-4">
					        <input type="text" class="form-control" name="new-password" placeholder="<?php echo Trans('app','New Password'); ?>" />
					      </div>
					      
					       <!-- Price input -->
					      <div class="form-outline mb-4">
					      	<span class="form-hint form-hint-confirm-new-password d-block mt-0"><?php echo Trans('app','The password is at least four letters, symbols or Numbers'); ?></span>
					        <input type="text" class="form-control" name="confirm-new-password" placeholder="<?php echo Trans('app','Confirm New Password'); ?>" />
					      </div>
					      
					      <!-- Submit button -->
			      		  <button type="submit" class="btn btn-primary btn-block w-100 mb-3 py-2"><?php echo Trans('app','Add Ad'); ?></button>
			
					      <a href="" class="btn btn-danger btn-block w-100 mt-3 py-2"> 
					      	<?php echo Trans('app','Delete Account'); ?>
					      </a>
					      
					      
					      
					    </form>
			 		
			 		</div>
			 		
				</div>
			
			</div>