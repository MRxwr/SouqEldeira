<?php include 'config/config.php'; ?>
<?php include 'config/language.php'; ?>

<?php include 'themes/'.$config['theme'].'/layouts/start.php'; ?> 

        <?php include 'themes/'.$config['theme'].'/layouts/header.php'; ?> 
        
        <!-- Start page-content -->
		<div class="page-content my-5">
			
	        <div class="container container-project">
	        	 <?php include 'themes/'.$config['theme'].'/sections/ad-view.php'; ?> 
	        </div> 
 
        </div> 
      
<?php include 'themes/'.$config['theme'].'/layouts/footer.php'; ?> 
<?php include 'themes/'.$config['theme'].'/layouts/end.php'; ?> 