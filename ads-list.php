<?php include 'config/config.php'; ?>
<?php include 'config/language.php'; ?>

<?php include 'themes/'.$config['theme'].'/layouts/start.php'; ?> 

        <?php include 'themes/'.$config['theme'].'/layouts/header.php'; ?> 
        
        <!-- Start page-content -->
		<div class="page-content my-5">
        	
      
	        <div class="container container-project">
	        	
		       
				<div class="ads-section">
					
				  <h4 class="mb-md-5 mb-3 text-center"><?php echo Trans('app','Ads List'); ?></h4>
				  <?php include 'themes/'.$config['theme'].'/sections/ads-main-list.php'; ?>
				  <div class="d-block text-end mt-3">
				  	<a href="" class="btn btn-primary"><?php echo Trans('app','More'); ?> <i class="bi bi-three-dots"></i></a>
				  </div>
				  
				</div>
				
				
				
			</div> 
		
		
		
		
		
        
        </div>
      
<?php include 'themes/'.$config['theme'].'/layouts/footer.php'; ?> 
<?php include 'themes/'.$config['theme'].'/layouts/end.php'; ?> 