
        	
	        <div class="search-ads-options mb-3">
	        	<div class="div">
	        		<span class="title"><?php echo Trans('app','Search Options'); ?></span>
	        	</div> 
	        	<div class="div">
	        		<span class="title"><?php echo Trans('app','Type'); ?></span>
	        		<span class="data">
	        			<span><?php echo Trans('app','Sale'); ?><span> 
	        		</span>
	        	</div>
	        	<div class="div">
	        		<span class="title"><?php echo Trans('app','Region'); ?></span>
	        		<span class="data">
	        			<span><?php echo Trans('app','Khiran'); ?></span>
	        			<span><?php echo Trans('app','Khiran'); ?></span>
	        			<span><?php echo Trans('app','Khiran'); ?></span>
	        		</span>
	        	</div>
	        </div>
			
			<div class="search-title mb-3 mt-2">  
				<h4><i class="bi bi-search"></i><?php echo Trans('app','Search Result'); ?><span>(115 <?php echo Trans('app','Ad'); ?>)</span></h4>
			</div>
			
			<div class="ads-section">
			  <?php include 'themes/'.$config['theme'].'/sections/ads-main-list.php'; ?>
			  <div class="d-block text-end mt-3">
			  	<a href="" class="btn btn-primary"><?php echo Trans('app','More'); ?> ...</a>
			  </div>
			</div>