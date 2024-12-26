<div class="ads-main-list">
	<div class="row gy-3"> 
	<?php
	if( $ads = selectDB("products","`status` = '0' AND `hidden` != '2' ORDER BY `id` DESC LIMIT 3") ){
		for( $i = 0; $i < sizeof($ads); $i++ ){
		
		}
	}
	?>

<div class="modal modal-bottom fade" id="ad_modal" tabindex="-1" aria-labelledby="ad_modal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header"> 
          <h5 class="modal-title text-center d-block w-100" id="exampleModalLabel"><?php echo Trans('app','A house for rent in Abu Fetera'); ?></h5>
          <a class="btn-close-modal" data-bs-dismiss="modal" aria-label="Close"> <i class="bi bi-chevron-left"></i> </a>  
      </div>
      <div class="modal-body">
      	<div class="container container-project">
        <?php /*require_once 'views/bladeAdView.php'; */ ?>   
        </div>  
      </div>
    </div> 
  </div>
</div>