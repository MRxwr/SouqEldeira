<h4 class="mb-md-5 mb-3 text-center ad-title" id="ad-title"><?php echo Trans('app','A house for rent in Abu Fetera'); ?></h4>
	        
<div class="ad-top-details p-3 mb-4" id="ad-top-details">
	<div class="row">
        <div class="col-sm-4">
        	<div class="ad-top-details-items">
                <div class=""> <span class="sp1"><i class="bi bi-geo-alt"></i></span><span id="adsLocation" class="sp2"></span></div>
                <div class=""> <span class="sp1"><?php echo Trans('app','Price'); ?></span>  <span class="sp2"></span></div>
            </div>
        </div>
        <div class="col-sm-1">
        </div>
        <div class="col-sm-7">  
        	<div class="ad-top-details-items">
                <div class=""><span class="sp1"><i class="bi bi-heart"></i> </span> <span class="sp2"><?php echo Trans('app','Favourite'); ?></span></div>
                <div class=""><span class="sp1"><i class="bi bi-clock"></i> </span> <span class="sp2">2 <?php echo Trans('app','Hours'); ?></span></div>
                <div class=""><span class="sp1"><i class="bi bi-eye"></i>   </span> <span class="sp2">54</span></div>
                <div class=""><span class="sp1"><i class="bi bi-share"></i> </span> <span class="sp2"><?php echo Trans('app','Share'); ?></span></div>
            </div>
        </div>
	</div>
</div>
	         
<div class="ad-details" id="ad-bot-details"> 
	<div class="row">
        <div class="col-sm-6"> 
        	<h5 class="fw-bold"><?php echo Trans('app','Description'); ?></h5>
        	<p><?php echo Trans('app','ad-desc-full'); ?> <?php echo Trans('app','ad-desc-full'); ?></p>
            <div class="contact">
            	<a href="" class="btn btn-default btn-border-radius-1 py-2 btn-wts"><i class="bi bi-whatsapp"></i></a>
            	<a href="" class="btn btn-default btn-border-radius-1 py-2 btn-call"><i class="bi bi-telephone"></i> <?php echo Trans('app','Call'); ?></a>   
            </div>
        </div>
        <div class="col-sm-6">
        	
        	<div id="carouselExampleCaptions" class="ad-in-view-carousel carousel slide" data-bs-ride="carousel">
  
			  <div class="carousel-inner">
			  	
			    <div class="carousel-item active bg-1"> 
			       <a href="assets/img/items/item.png" data-toggle="lightbox" data-gallery="mixedgallery">
				      	<img src="assets/img/items/item.png" class="d-block w-100 h-100" alt="...">
			       </a>      
			    </div>
			    
			    <div class="carousel-item bg-2">      
			       <a href="assets/img/items/item-2.png" data-toggle="lightbox" data-gallery="mixedgallery">
			       		<img src="assets/img/items/item-2.png" class="d-block w-100 h-100" alt="...">
			       </a> 
			    </div>
			    
			    <div class="carousel-item bg-3">      
			       <a href="assets/img/items/item-3.png" data-toggle="lightbox" data-gallery="mixedgallery">
				      	<img src="assets/img/items/item-3.png" class="d-block w-100 h-100" alt="...">
			       </a>
			    </div>
			    
			    <div class="carousel-item bg-4">      
			      <a href="assets/img/items/item.png" data-toggle="lightbox" data-gallery="mixedgallery">
				      	<img src="assets/img/items/item.png" class="d-block w-100 h-100" alt="..."> 
			      </a>  
			    </div>
			    
			  </div>
			  
			  <!-- Slider Buttons-->
			  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
			    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
			    <span class="visually-hidden">Previous</span>
			  </button>
			  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
			    <span class="carousel-control-next-icon" aria-hidden="true"></span>
			    <span class="visually-hidden">Next</span>
			  </button>
			  
			  
			  <!--Slider Thumbnails-->
			  <div class="carousel-indicators">
			    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"><img class="d-block w-100" src="assets/img/items/item.png" class="img-fluid"></button>
			    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"><img class="d-block w-100" src="assets/img/items/item-2.png" class="img-fluid"></button>
			    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"><img class="d-block w-100" src="assets/img/items/item-3.png" class="img-fluid"></button>
			    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"><img class="d-block w-100" src="assets/img/items/item.png" class="img-fluid"></button>
			  </div> 
			  
			</div>
        	 
        </div>
    </div>
 </div>
	 
<hr>

<div class="ads-section"> 
	
  <h4 class="text-start mt-2 mb-3"><?php echo Trans('app','From the same region'); ?></h4>
  
  <?php include 'ads-same-region-list.php'; ?>
  <div class="d-block text-end mt-3">
  	<!-- <a href="" class="btn btn-primary"><?php echo Trans('app','More'); ?> <i class="bi bi-three-dots"></i></a> -->
  </div> 
  
</div>