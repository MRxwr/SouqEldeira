<?php include 'config/config.php'; ?>
<?php include 'config/language.php'; ?>

<?php include 'themes/'.$config['theme'].'/layouts/start.php'; ?> 

        <?php include 'themes/'.$config['theme'].'/layouts/header.php'; ?> 
        
		<!-- Start page-content -->
		<div class="page-content my-5">
		
		<div class="container container-project">		
			
			<div class="row"> 
				
				<div class="col-md-12"> 
					<div class="start-page-title with-white-bg text-center mb-0 py-3">
						<h4 class="mt-3"><?php echo Trans('app','Terms & Conditions'); ?></h4>  
						
						<div class="px-3 pt-3">   
							<p><?php echo Trans('app','about-txt-1'); ?></p>
						</div> 
			 		</div>
				</div>
				
			</div>
			
		</div>    
		
		</div>
		<!-- End page-content -->
		
<?php include 'themes/'.$config['theme'].'/layouts/footer.php'; ?> 
<?php include 'themes/'.$config['theme'].'/layouts/end.php'; ?> 