
<?php include 'layouts/start.php'; ?> 

        <?php include 'layouts/header.php'; ?> 
        
		<!-- Start page-content -->
		<div class="page-content my-5">
	
		<div class="container container-project">
		<div class="row"> 
		  <?php include 'layouts/alert.php'; ?>
		<div class="col-md-11 mx-auto">
			
			<div class="form-container form-container-faq">
		
				<div class="mb-4 text-center">
					<img src="assets/img/logo-1.png" class="img-fluid" alt="...">
				</div>
		        
				<div class="mb-4 text-center">
					<h5 class="faq-title" ><?php echo Trans('app','Frequently asked questions about properties for rent or sale in Kuwait'); ?></h5> 
			    </div>
		
		        <div class="accordion accordion-flush" id="accordionFlushExample">
				  <div class="accordion-item">
				    <h2 class="accordion-header" id="flush-headingOne">
				      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
				        <?php echo Trans('app','How many real estate ads are currently for rent or for saleIn Kuwait on the website'); ?>
				      </button>
				    </h2>
				    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
				      <div class="accordion-body"><?php echo Trans('app','The number of real estate ads offered for rent or for sale in Kuwait is 4883 new ads'); ?></div>
				    </div>
				  </div>
				  <div class="accordion-item">
				    <h2 class="accordion-header" id="flush-headingTwo">
				      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
				         <?php echo Trans('app','How many real estate ads are currently for rent or for saleIn Kuwait on the website'); ?>
				      </button>
				    </h2>
				    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
				      <div class="accordion-body"><?php echo Trans('app','The number of real estate ads offered for rent or for sale in Kuwait is 4883 new ads'); ?></div>
				    </div>
				  </div>
				  <div class="accordion-item">
				    <h2 class="accordion-header" id="flush-headingThree">
				      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
				         <?php echo Trans('app','How many real estate ads are currently for rent or for saleIn Kuwait on the website'); ?>
				      </button>
				    </h2>
				    <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
				      <div class="accordion-body"><?php echo Trans('app','The number of real estate ads offered for rent or for sale in Kuwait is 4883 new ads'); ?></div>
				    </div>
				  </div>
				</div>
				
				  
			     <div class="text-center mt-4"> 
			      	<p class="add-ad-form-text fw-bold"><?php echo Trans('app','Send us message by'); ?> <a href=""><?php echo Trans('app','WhatsApp'); ?></a> <?php echo Trans('app','or'); ?> <a href="contact.php"><?php echo Trans('app','call us'); ?></a> <?php echo Trans('app','for help'); ?></p>
			     </div>

			</div>
			
			
		</div>
		</div>
		</div>   
      
	    </div>
		<!-- End page-content -->
		
<?php include 'layouts/footer.php'; ?> 
<?php include 'layouts/end.php'; ?> 