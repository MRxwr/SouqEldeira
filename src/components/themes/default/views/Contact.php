
<?php include 'layouts/start.php'; ?> 

        <?php include 'layouts/header.php'; ?> 
        
		<!-- Start page-content -->
		<div class="page-content my-5">
		
		<div class="container container-projectX">		
			<div class="row"> 
			    <?php include 'layouts/alert.php'; ?>
				<div class="main-contact with-white-bg p-4 pt-4 d-flex align-items-center">
				<div class="col-lg-6 col-md-12">  
					
					<h4 class="mb-3"><?php echo Trans('app','Contact Us'); ?></h4>
					
					
					<form class="contact-us-form">
						
					 	<div class="row row-fields d-flex align-items-stretch g-3">
						      	 	
				      	 	<div class="col-md-6">
				      	 		
				      	 		  <!-- Name input -->
							      <div class="form-outline mb-4">
							        <input type="text" class="form-control" name="name" placeholder="<?php echo Trans('app','Name'); ?>" />
							      </div>
							      
							      <!-- Phone input -->
							      <div class="form-outline mb-4">
							        <input type="text" class="form-control" name="phone" placeholder="<?php echo Trans('app','Phone Number'); ?>" />
							      </div>
							      
							      <!-- Email input -->
							      <div class="form-outline mb-4">
							        <input type="text" class="form-control" name="email" placeholder="<?php echo Trans('app','Email'); ?>" />
							      </div>
							      
				        	</div>
					        	
				        	<div class="col-md-6">
				      	 		  <!-- Description input -->
							      <div class="form-outline h-100 pb-4"> 
							         <textarea class="form-control h-100" name="message"  rows="3" placeholder="<?php echo Trans('app','Message'); ?>"></textarea>
							      </div>
				        	</div>
				        </div>
				        	
				        <div class="row">	
				        	<div class="col-md-12">
				        		<!-- Submit button --> 
		      		  			<button type="submit" class="btn btn-primary btn-block w-100 mb-3 py-2"><i class="bi bi-send"></i> <?php echo Trans('app','Send'); ?></button>
							</div>
						</div>
					      
					</form>
				
			 		<div class="contact-details">
				 		<div class="row align-items-center g-1 mt-2"> 
				 			<div class="col-md-12">
				 				 
				 				<h3><?php echo Trans('app','Contact details'); ?></h3>
				 				<h5 class="mb-3"><?php echo Trans('app','To communicate and inquire with customer service'); ?></h5>
			 				
				 				<div class="data">
				 					<a href="tel:66004080"><i class="bi bi-telephone-fill"></i>66004080</a> 
				 					<a href="tel:222272077"><i class="bi bi-newspaper"></i>222272077</a>
				 					<a href="mailto:info@souqeldeira.com"><i class="bi bi-envelope"></i>info@souqeldeira.com</a>
				 				</div> 
				 				
				 			</div>
				 		</div>
			 		</div>
			 		
				</div>
				
				<div class="col-lg-6 col-md-12 text-center"> 
					<img src="assets/img/logo-big.png" class="img-fluid p-5 img-fluid-logo" alt="...">		  		
				</div> 
				
				</div>
				
			</div>
			
		</div>   
		
		</div>
		<!-- End page-content -->
		
<?php include 'layouts/footer.php'; ?> 
<?php include 'layouts/end.php'; ?> 