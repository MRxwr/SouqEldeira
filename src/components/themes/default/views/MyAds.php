
<?php include 'layouts/start.php'; ?> 
        <?php include 'layouts/header.php'; ?> 
		<!-- Start page-content -->
		<div class="page-content my-5">
		<div class="container container-projectx">		
		<?php include 'layouts/alert.php'; ?>
			<div class="row"> 
				<div class="col-md-12"> 
					<div class="start-page-title with-white-bg text-center mb-4 py-3">
						<h4 class="mb-0 fw-bold"><?php echo Trans('app','My Ads'); ?></h4>
			 		</div>
				</div>
				<div class="col-md-12"> 
					<div class="with-white-bg mb-4 p-4 px-2 px-md-4">
						
						<h4 class="mb-3 fw-bold"><?php echo Trans('app','My balance of ads'); ?></h4>
						
						
						<div class="ads-balance">
							<div>
								<span class="title"><?php echo Trans('app','Regular Advertising'); ?></span>
								<span class="count" id="normal">0</span>
							</div> 
							<div>
								<span class="title"><?php echo Trans('app','Special Advertising'); ?></span>
								<span class="count" id="premium">0</span>
							</div>
							<div class="recharge-balance"> 
								<a href="#" class="btn btn-primary py-0 px-5" id="recharge-balance-btn"><?php echo Trans('app','Recharge Your Balance'); ?></a>
							</div> 
						</div>
						
						<div class="add-ads-balance-big">
						<div class="row d-felx align-items-center add-ads-balance mt-4">
							
							<div class="col-md-4 col-lg-4 col-form"> 
								<div id="progressContainer" style="display:none;">
									<div id="progressBar" style="width: 0%; height: 20px; background-color: #4caf50;"></div>
								</div>  
								<div class="buy-ad">
									<span><?php echo Trans('app','Buy Regular Ad'); ?></span>
									<form class="buy-ad-form buy-ad-regular" id="BuyRegular"> 
								        <div class="form-outline">
								        	<input type="number" min="1" class="form-control count" name="quantity" placeholder="<?php echo Trans('app','Qt'); ?>" value="1" required />
								        </div> 
								        <div class="text-center">(x <span id="pp_normal">1</span> <?php echo Trans('app','Dinar'); ?>)</div> 
			      						<button type="submit" class="btn btn-primary py-0 btn-sm"><?php echo Trans('app','Pay'); ?></button> 
									</form>
								</div>
								
								<div class="buy-ad mt-2">
									<span><?php echo Trans('app','Buy Special Ad'); ?></span>
									<form class="buy-ad-form special-ad-regular" id="BuySpecial">
								        <div class="form-outline">
								        	<input type="number" min="1"  class="form-control count" name="quantity" placeholder="<?php echo Trans('app','Qt'); ?>" value="1"  required/>
								        </div> 
								        <div class="text-center">(x <span id="pp_premium">1</span> <?php echo Trans('app','Dinar'); ?>)</div> 
			      						<button type="submit" class="btn btn-primary py-0 btn-sm"><?php echo Trans('app','Pay'); ?></button>
									</form>
								</div>
								
							</div>
							<div class="col-md-8">
								<div class="row" id="PackageDataDiv">
								<div class="col-md-6"> 
									<div class="package-data">
										<div class="img">
											<img src="assets/img/packages/package-1.png" class="img-fluid" alt="..."> 
										</div>
										<div class="data">
											<span class="title"><?php echo Trans('app','Golden Package'); ?> - 1</span>  
											<span class="content"><?php echo Trans('app','Price'); ?> : 1000 <?php echo Trans('app','Dinar'); ?></span>
											<span class="content"><?php echo Trans('app','Regular Ad'); ?> : 300 </span>
											<span class="content"><?php echo Trans('app','Special Ad'); ?> : 200 </span> 
											<span class="content"><?php echo Trans('app','Expire Data'); ?> : 60 <?php echo Trans('app','Day'); ?></span>
										</div>
										<div class="buy">
											<a href="#!" class="btn btn-primary py-0 btn-sm"><?php echo Trans('app','Pay'); ?></a>  
										</div>
									</div>
								</div>

							<div class="col-md-6"> 
								<div class="package-data">
									<div class="img">
										<img src="assets/img/packages/package-2.png" class="img-fluid" alt="...">
									</div>
									<div class="data">
										<span class="title"><?php echo Trans('app','Golden Package'); ?> - 2</span>  
										<span class="content"><?php echo Trans('app','Price'); ?> : 1000 <?php echo Trans('app','Dinar'); ?></span>
										<span class="content"><?php echo Trans('app','Regular Ad'); ?> : 300 </span>
										<span class="content"><?php echo Trans('app','Special Ad'); ?> : 200 </span> 
										<span class="content"><?php echo Trans('app','Expire Data'); ?> : 60 <?php echo Trans('app','Day'); ?></span>
									</div>
									<div class="buy">
										<a href="#!" class="btn btn-primary py-0 btn-sm"><?php echo Trans('app','Pay'); ?></a> 
									</div>
								</div>
							</div> 
								</div>
							</div>
							
						</div>
						</div>
						
			 		</div>
			 		
				</div>
			
			</div>
			
			
			<div class="row"> 
				
				<div class="col-md-12 col-lg-6 col-xl-6">  
					<div class="with-white-bg mb-4 p-4 px-2 px-md-4">
						
						<div class="my-current-ad-head">
							<h4 class="mb-4 fw-bold"><?php echo Trans('app','My Ads'); ?></h4>	
							<div class="ad-status">
								<div>
									<span class="published ad-status-type"><i class="bi bi-check"></i></span>
									<span class="txt"><?php echo Trans('app','Published'); ?></span>
								</div>
								<div>
									<span class="waiting ad-status-type"><i class="bi bi-exclamation"></i></span>
									<span class="txt"><?php echo Trans('app','Waiting'); ?></span>
								</div>
								<div>
									<span class="refused ad-status-type"><i class="bi bi-x"></i></span> 
									<span class="txt"><?php echo Trans('app','Refused'); ?></span> 
								</div>
							</div>
						</div>
						
						<div class="my-ad-list cuurrent-ads load-ajax-call" id="cuurrent-ads" data-type="All" data-endpoint="my-ads/list">

						</div> 
						
						<div class="d-block text-center text-xl-end mt-3"> 
						  	<a href="#" id="view-more-ads" class="view-all" style="text-decoration: underline"><?php echo Trans('app','View More'); ?></a>
					    </div>
						
					</div>
				</div>
				
				<div class="col-md-12 col-lg-6 col-xl-6"> 
					<div class="with-white-bg mb-4 p-4 px-2 px-md-4">  
						
						<div class="my-ended-ad-head">
							<h4 class="mb-4 fw-bold"><?php echo Trans('app','My Ended Ads'); ?><span></span></h4>
						</div> 
						
						<div class="my-ad-list ended-ads load-ajax-call" id="ended-ads" data-endpoint="my-ads/expired">

						</div> 
						
						<div class="d-block text-center text-xl-end mt-3"> 
						  	<a href="#" id="My-Ended-view-more"  class="view-all" style="text-decoration: underline"><?php echo Trans('app','View More'); ?></a>
					    </div>

					</div>
				</div>
				
			</div>
			
			<div class="row row-fields d-flex align-items-stretch" > 
				
				<div class="col-md-12 col-lg-6 col-xl-6"> 
					<div class="with-white-bg  p-4 px-2 px-md-4"> 
						<div class="favourite-list ads-section">
						  <h4 class="mb-4"><?php echo Trans('app','Favourite'); ?></h4>	  	  
						  <?php include 'sections/Ads-Favourite-list.php'; ?>
						  <div class="d-block text-center text-xl-end mt-3"> 
						  	<a href="" id="Favourite-view-more" class="view-all"><?php echo Trans('app','View More'); ?></a>
						  </div>
						</div>
					</div> 
				</div>
				 
				<div class="col-md-6 col-myad-logo">   
					<div class="with-white-bg  p-4 text-center h-100 d-flex align-items-center justify-content-center">
						<img src="assets/img/logo-big.png" class="img-fluid" alt="...">		 	
					</div>
				</div>
				
			</div>
			
		</div>   
		
		</div>
		<!-- End page-content -->
		
<?php include 'layouts/footer.php'; ?> 
<?php include 'layouts/end.php'; ?> 