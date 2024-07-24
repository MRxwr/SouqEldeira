
<?php include 'layouts/start.php'; ?> 

        <?php include 'layouts/header.php'; ?> 
        
        <div class="page-content my-5">
        
        <div class="container container-project">
		<?php include 'layouts/alert.php'; ?>
	        <div class="search-ads-options mb-3">
	        	<div class="div">
	        		<span class="title"><?php echo Trans('app','Search Options'); ?></span>
	        	</div> 
	        	<div class="div">
	        		<span class="title"><?php echo Trans('app','Type'); ?></span>
	        		<span class="data" id="dataTitle"></span>
	        	</div>
	        	<div class="div">
	        		<span class="title"><?php echo Trans('app','Region'); ?></span>
	        		<span class="data" id="dataRegion"></span>
	        	</div>
	        </div>
			
			<div class="search-title mb-3 mt-2">  
				<h4><i class="bi bi-search"></i><?php echo Trans('app','Search Result'); ?><span id="total_ads">(0 <?php echo Trans('app','Ad'); ?>)</span></h4>
			</div>
			
			<div class="ads-section">
			  <?php include 'sections/ads-main-list-search.php'; ?>
			  <div class="d-block text-end mt-3">
			  	<a href="javascript:void(0)" id="searchLoad" class="btn btn-primary"><?php echo Trans('app','More'); ?> ...</a>
			  </div>
			</div> 
		  </div>
        </div> 
      
<?php include 'layouts/footer.php'; ?> 
<?php include 'layouts/end.php'; ?> 