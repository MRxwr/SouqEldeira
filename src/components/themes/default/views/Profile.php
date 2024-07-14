<?php include 'layouts/start.php'; ?> 

        <?php include 'layouts/header.php'; ?> 
        
		<!-- Start page-content -->
		<div class="page-content my-5">
		
		<div class="container container-project">		
		<?php include 'layouts/alert.php'; ?>
			<div class="row"> 
				
				<div class="col-md-12"> 
					<div class="start-page-title with-white-bg text-center mb-4 py-3">
						<h4 class="mb-0"><?php echo Trans('app','Profile'); ?></h4>
			 		</div>
				</div>
				
				<div class="col-md-6"> 
					<div class="with-white-bg py-1 px-4">
						
						<form id="profile-form" id="profile-form" class="mt-4">
							   
							  <div class="mb-4 text-center" id="profileImg">
								<img src="assets/img/profile.png" class="img-fluid" alt="...">
							  </div>
							  
							  <!-- Price input -->
						      <div class="form-outline mb-4">
						        <input type="text" class="form-control" id="name" name="name" value="Badr Mahmoud" placeholder="<?php echo Trans('app','Username'); ?>" required/>
						      </div>
						      
						      <!-- Price input -->
						      <div class="form-outline mb-4">
						        <input type="text" class="form-control" id="phone" name="phone" value="65680566" placeholder="<?php echo Trans('app','Phone Number'); ?>"  required/>
						      </div>
						      
						      <!-- Price input -->
						      <div class="form-outline mb-4">
						        <input type="text" class="form-control" id="email" name="email" value="badertov7@gmail.com" placeholder="<?php echo Trans('app','Email'); ?>"  required/>
						      </div>

							  <div class="form-outline mb-4">
								<textarea class="form-control" id="description" style="height: 100px;" name="description" placeholder="<?php echo Trans('app','Description'); ?>" ></textarea>
						      </div>
						      
						      <div class="form-outline mb-4">
						      	<h5 class="fw-bold mb-3"><?php echo Trans('app','Update Profile Image'); ?></h5>
						      	<div class="change-profile-image" id="changeProfileImage">
						      		<span><?php echo Trans('app','Click or drag an account image'); ?></span>
						      		<span><i class="bi bi-image"></i></span>
									
						      	</div>
								  <input type="file" name="image" id="fileInput" style="display:none">
						      </div>
						       
						      <div class="form-outline mb-4">
						      	 <h5 class="fw-bold mb-3"><?php echo Trans('app','Social Media Accounts'); ?></h5>
						      	 <div class="row align-items-center g-3">
						      	 	
						      	 	<div class="col-md-6"> 
						      	 		<div class="input-group mb-1">
										  <span class="input-group-text"><i class="bi bi-facebook"></i></span>
										  <input type="text" id="facebook" name="facebook" class="form-control">
										</div>
						        	</div>
						        	
						        	<div class="col-md-6"> 
						      	 		<div class="input-group mb-1">
										  <span class="input-group-text"><i class="bi bi-twitter-x"></i></span>
										  <input type="text" id="twitter" name="twitter" class="form-control">
										</div>
						        	</div>
						        	
						        	<div class="col-md-6"> 
						      	 		<div class="input-group mb-1">
										  <span class="input-group-text"><i class="bi bi-instagram"></i></span>
										  <input type="text" id="instagram" name="instagram" class="form-control">
										</div>
						        	</div>
						        	
						        	<div class="col-md-6"> 
						      	 		<div class="input-group mb-1">
										  <span class="input-group-text"><i class="bi bi-telegram"></i></span>
										  <input type="text" id="telegram" name="telegram" class="form-control">
										</div>
						        	</div>
						        	
						        	<div class="col-md-12"> 
						      	 		<div class="input-group mb-1">
										  <span class="input-group-text"><i class="bi bi-link"></i></span>
										  <input type="text" id="website" name="website" class="form-control">
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
			 				 		
				 		<form id="change-password-form"  class="mt-4">
								   
						   
						  <!-- Price input -->
					      <div class="form-outline mb-4">
					        <input type="text" class="form-control" name="password" placeholder="<?php echo Trans('app','Current Password'); ?>" required/> 
					      </div>
					      
					       <!-- Price input -->
					      <div class="form-outline mb-4">
					        <input type="text" class="form-control" name="new-password" placeholder="<?php echo Trans('app','New Password'); ?>" required/>
					      </div>
					      
					       <!-- Price input -->
					      <div class="form-outline mb-4">
					      	<span class="form-hint form-hint-confirm-new-password d-block mt-0"><?php echo Trans('app','The password is at least four letters, symbols or Numbers'); ?></span>
					        <input type="text" class="form-control" name="confirm-new-password" placeholder="<?php echo Trans('app','Confirm New Password'); ?>" required/>
					      </div>
					      
					      <!-- Submit button -->
			      		  <button type="submit" class="btn btn-primary btn-block w-100 mb-3 py-2"><?php echo Trans('app','Update'); ?></button>

					    </form>
						<button  id="DeleteAccount" class="btn btn-danger btn-block w-100 mt-3 py-2"> 
					      	<?php echo Trans('app','Delete Account'); ?>
					      </button>

						  <button id="DowngradeToUser"  class="btn btn-info btn-block w-100 mt-3 py-2 hide"> 
					      	<?php echo Trans('app','Downgrade to User'); ?>
					      </button> 

						  <button id="UpgradeToOffice" class="btn btn-success btn-block w-100 mt-3 py-2"> 
					      	<?php echo Trans('app','Upgrade to office'); ?>
					      </button> 
			 		
			 		</div>
			 		
				</div>
			
			</div>
			
		</div>   
		
		</div>
		<!-- End page-content -->
		
<?php include 'layouts/footer.php'; ?> 
<?php include 'layouts/end.php'; ?> 