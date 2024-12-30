<?php if(!$_SESSION['valid']){
	echo "<script>window.location.href = '/index.php?v=Login';</script>";
 } else {
	$settings = selectDB("settings","`id` = '1'");
	$myExpiredAds=getMyAds($user[0]["id"], 'expired');
	$myActiveAds=getMyAds($user[0]["id"], 'active');
	$normalAds = 0;
	$specialAds = 0;
	$normalAds = $user[0]["normalAd"];
	$specialAds = $user[0]["specialAd"];

	if( isset($_GET["hide"]) && !empty($_GET["hide"]) ){
		updateDB("products",array("hidden" => 2),"`id` = '{$_GET["hide"]}'");
		header("LOCATION: index.php?v=MyAds");die();
	}
	
	if( isset($_GET["forceDelete"]) && !empty($_GET["forceDelete"]) ){
		updateDB("products",array("status" => 1),"`id` = '{$_GET["forceDelete"]}'");
		header("LOCATION: index.php?v=MyAds");die();
	}
}

?>	
			
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
								<span class="count"><?php echo $normalAds; ?></span>
							</div> 
							<div>
								<span class="title"><?php echo Trans('app','Special Advertising'); ?></span>
								<span class="count"><?php echo $specialAds; ?></span>
							</div>
							<div class="recharge-balance"> 
								<a href="#" class="btn btn-primary py-0 px-5" id="recharge-balance-btn"><?php echo Trans('app','Recharge Your Balance'); ?></a>
							</div> 
						</div>
						
						<div class="add-ads-balance-big">
						<div class="row d-felx align-items-center add-ads-balance mt-4">
							
							<div class="col-md-4 col-lg-4 col-form">   
								 
								<div class="buy-ad">
									<span><?php echo Trans('app','Buy Regular Ad'); ?></span>
									<form class="buy-ad-form buy-ad-regular"> 
								        <div class="form-outline">
								        	<input type="number"  class="form-control" name="quantity" placeholder="<?php echo Trans('app','Qt'); ?>" />
								        </div> 
								        <div class="text-center">(x 1 <?php echo Trans('app','Dinar'); ?>)</div> 
			      						<button type="submit" class="btn btn-primary py-0 btn-sm"><?php echo Trans('app','Pay'); ?></button> 
									</form>
								</div>
								
								<div class="buy-ad mt-2">
									<span><?php echo Trans('app','Buy Special Ad'); ?></span>
									<form class="buy-ad-form special-ad-regular">
								        <div class="form-outline">
								        	<input type="number"  class="form-control" name="quantity" placeholder="<?php echo Trans('app','Qt'); ?>" />
								        </div> 
								        <div class="text-center">(x 1 <?php echo Trans('app','Dinar'); ?>)</div> 
			      						<button type="submit" class="btn btn-primary py-0 btn-sm"><?php echo Trans('app','Pay'); ?></button>
									</form>
								</div>
								
							</div>
							
							<div class="col-md-4"> 
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
							<div class="col-md-4"> 
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
						
						<div class="my-ad-list cuurrent-ads">

							<?php foreach( $myActiveAds as $ad ){ 
								if( $ad["packageId"] == 2 ){
									$feature = "card-feature";
								}else{
									$feature = "";
								}?>
								<?php
									//echo '<li><a id="'.$products[$i]["id"].'" class="edit" href="javascript:void(0)"><i class="zmdi zmdi-edit"></i></a></li>';
									//echo '<li><a href="'.$link.'"><i class="'.$icon.'"></i></a></li>';
									//echo "<li><a href='?v={$_GET["v"]}&forceDelete={$products[$i]["id"]}'><i class='fa fa-times'></i></a></li>";
								?>
								<div class="my-ad-list-item my-2">  
								<div class="row g-1"> 
									<div class="col-md-8 my-ad-list-item-side1">  
										<img src="assets/img/items/item-2.png" class="img-fluid" alt="...">
										<div class="data">
											<h4><?php echo direction($ad['enTitle'],$ad['arTitle']); ?></h4>
											<h5><?php echo substr(direction($ad['enDetails'],$ad['arDetails']),0,100) ?></h5>
											<h6><?php echo Trans('app','Created Date'); ?> &nbsp;&nbsp; 23/8/2023</h6>
										</div> 
									</div>
									<div class="col-md-4 my-ad-list-item-side2">    
										<div class="viewers"><i class="bi bi-eye"></i>54</div>
										<div class="status"><span class="published ad-status-type"><i class="bi bi-check"></i></span></div>
										<div class="actions">
										<a href="#" 
											class="update" 
											onclick="return confirmUpdate('?v=<?php echo $_GET['v']; ?>&id=<?php echo $products[$i]['id']; ?>');">
											<i class="bi bi-pencil-square"></i>
											</a>
											<a href="#" 
												class="delete" 
												onclick="return confirmDelete('?v=<?php echo $_GET['v']; ?>&forceDelete=<?php echo $products[$i]['id']; ?>');">
												<i class="bi bi-trash3"></i>
											</a>
										</div> 
									</div>
								</div>
							</div> 

							<?php } ?>
							
							
							
							
						</div> 
						
						<div class="d-block text-center text-xl-end mt-3"> 
						  	<a href="" class="view-all" style="text-decoration: underline"><?php echo Trans('app','View All'); ?></a>
					    </div>
						
					</div>
				</div>
				
				<div class="col-md-12 col-lg-6 col-xl-6"> 
					<div class="with-white-bg mb-4 p-4 px-2 px-md-4">  
						
						<div class="my-ended-ad-head">
							<h4 class="mb-4 fw-bold"><?php echo Trans('app','My Ended Ads'); ?><span></span></h4>
						</div> 
						
						<div class="my-ad-list ended-ads">
						<?php foreach( $myExpiredAds as $ad ){ 
								if( $ad["packageId"] == 2 ){
									$feature = "card-feature";
								}else{
									$feature = "";
								}?>
								<div class="my-ad-list-item my-2"> 
								<div class="row g-1"> 
									<div class="col-md-8 my-ad-list-item-side1">  
										<img src="assets/img/items/item-2.png" class="img-fluid" alt="...">
										<div class="data">
											<h4><?php echo direction($ad['enTitle'],$ad['arTitle']); ?></h4>
											<h5><?php echo Trans('app','Mubarak Al-Kabeer'); ?> - <?php echo Trans('app','Al-funaitis'); ?></h5>
											<h6><?php echo Trans('app','Created Date'); ?> &nbsp;&nbsp; 23/8/2023</h6>
										</div> 
									</div>
									<div class="col-md-4 my-ad-list-item-side2">    
										<div class="viewers"><i class="bi bi-eye"></i>54</div>
										<div class="actions"> 
											<a href="#!" class="republish"><i class="bi bi-arrow-repeat"></i> <?php echo Trans('app','Republish'); ?></a>
										</div> 
									</div>
								</div>
							</div> 

							<?php } ?>
							
							
							
						</div> 
						
						<div class="d-block text-center text-xl-end mt-3"> 
						  	<a href="" class="view-all" style="text-decoration: underline"><?php echo Trans('app','View All'); ?></a>
					    </div>
						
						
						
						
					</div>
				</div>
				
			</div>
			
			<div class="row row-fields d-flex align-items-stretch"> 
				
				<div class="col-md-12 col-lg-6 col-xl-6"> 
					<div class="with-white-bg  p-4 px-2 px-md-4"> 
						<div class="favourite-list ads-section">
						  <h4 class="mb-4"><?php echo Trans('app','Favourite'); ?></h4>	  	  
						  <?php include 'themes/'.$config['theme'].'/sections/ads-main-list.php'; ?>
						  <div class="d-block text-center text-xl-end mt-3"> 
						  	<a href="" class="view-all"><?php echo Trans('app','View All'); ?></a>
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

			<script>
				function confirmDelete(url) {
					if (confirm('Are you sure you want to delete this item?')) {
						window.location.href = url;
					}
					return false; // Prevent the default link behavior
				}
				function confirmUpdate(url) {
					if (confirm('Are you sure you want to update this item?')) {
						window.location.href = url;
					}
					return false; // Prevent the default link behavior
				}
			</script>