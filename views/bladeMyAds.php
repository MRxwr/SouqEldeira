<?php if(!$_SESSION['valid']){
	echo "<script>window.location.href = '/index.php?v=Login';</script>";
 } else {

	$settings = selectDB("settings","`id` = '1'");
	$myExpiredAds=getMyAds($user[0]["id"], 'expired', 1);
	$myActiveAds=getMyAds($user[0]["id"], 'active', 1);
	$myFevoriteAds=getMyAds($user[0]["id"], 'favourite',1);
	$normalAds = 0;
	$specialAds = 0;
	$normalAds = $user[0]["normalAd"];
	$specialAds = $user[0]["specialAd"];
	$order = selectDB("orders2","`userId` = '{$user[0]["id"]}' ORDER BY `id` DESC LIMIT 1","");
	$package = selectDB("packages","`id` = '{$order[0]["packageId"]}' ORDER BY `id` DESC LIMIT 1","");
	
	if( isset($_GET["republish"]) && !empty($_GET["republish"]) ){
		$product = selectDB("products","`id` = '{$_GET["republish"]}'")[0];
		if( ($product["adType"] == 1 && $user[0]["normalAd"] > 1 ) || ($product["adType"] == 2 && $user[0]["specialAd"] > 0 )){	
			 $days = $days = intval($package[0]["expirey"]); // Default to 0 if invalid
		
			if ($days > 0) {
				$expiryDate = date("Y-m-d H:i:s", strtotime("+$days days"));
			} else {
				// Handle default case, e.g., set expiryDate to current datetime
				$expiryDate = date("Y-m-d H:i:s");
			}
			$data = array(
				"userId" => "{$user[0]["id"]}",
				"categoryId"	=>	$product["categoryId"],
				"packageId" => "{$product["packageId"]}",
				"propertyType"	=>$product["propertyType"],
				"areaId"	=>	$product["areaId"],
				"adType"	=>	$product["adType"],
				"enTitle"		=>$product["enTitle"],
				"arTitle"		=>$product["arTitle"],
				"price"		=>	$product["price"],
				"enDetails"	=>	$product["enDetails"],
				"arDetails"	=>	$product["arDetails"],
				"expiryDate" =>	$expiryDate
			);
		
		if( insertDB("products", $data) ){
			// Get last inserted id
			   $lastId = selectDB("products","`id` != '0' ORDER BY `id` DESC LIMIT 1")[0]["id"];
				if($product["adType"] == 1){
					$normalAds = $normalAds - 1;
					$data = array(
						"normalAd" => "{$normalAds}",
					);
					updateDB("users",$data,"`id` = '{$user[0]["id"]}'");
				}else if($product["adType"] == 2){
					$specialAds = $specialAds - 1;
					$data = array(
						"specialAd" => "{$specialAds}",
					);
					updateDB("users",$data,"`id` = '{$user[0]["id"]}'");
				}
				// Upload images
				if( $images = selectDB("images","`productId` = '".$product['id']."'") ){
					foreach( $images as $k=>$image ){
						insertDB("images",array("productId" => $lastId,"imageurl" => $image["imageurl"]));
					}
				}
			header("LOCATION: index.php?v=MyAds&success=republish");die();	
		}
		}else{
			header("LOCATION: index.php?v=MyAds&error=republish");die();
		}

	 }
	

	if( isset($_GET["hide"]) && !empty($_GET["hide"]) ){
		updateDB("products",array("hidden" => 2),"`id` = '{$_GET["hide"]}'");
		header("LOCATION: index.php?v=MyAds&success=hide");die();
	}
	
	if( isset($_GET["forceDelete"]) && !empty($_GET["forceDelete"]) ){
		updateDB("products",array("status" => 1),"`id` = '{$_GET["forceDelete"]}'");
		header("LOCATION: index.php?v=MyAds&success=forceDelete");die();
	}
	if(isset($_GET['remove']) && !empty($_GET['remove'])){
		if(updateDB("products"," listOfUsers = JSON_REMOVE(
            listOfUsers, 
            JSON_UNQUOTE(JSON_SEARCH(listOfUsers, 'one', :{$user[0]['id']}))
        )
		","`id` = '{$_GET['remove']}'")){
			header("LOCATION: index.php?v=MyAds&success=remove");die();
		}
	}
		//selectDB("products"," `status` = '0' AND `hidden` != '2'  AND `listOfUsers` LIKE '%{$id}%'");
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
							<?php if( $packages = selectDB("packages","`status` = '0' ORDER BY `rank` ASC") ){ 
								foreach( $packages as $package ){ ?>
									<div class="col-md-4"> 
										<div class="package-data">
											<div class="img">
												<img src="assets/img/packages/package-1.png" class="img-fluid" alt="..."> 
											</div>
											<div class="data">
												<span class="title"><?php echo direction($package['enTitle'],$package['arTitle']); ?> - 1</span>  
												<span class="content"><?php echo Trans('app','Price'); ?> : <?php echo $package['price']; ?> <?php echo Trans('app','Dinar'); ?></span>
												<span class="content"><?php echo Trans('app','Regular Ad'); ?> : <?php echo $package['quantity']; ?> </span>
												<span class="content"><?php echo Trans('app','Special Ad'); ?> : <?php echo $package['quantitySP']; ?> </span> 
												<span class="content"><?php echo Trans('app','Expire Data'); ?> : <?php echo $package['expirey']; ?> <?php echo Trans('app','Days'); ?></span>
											</div>
											<div class="buy">
												<form action="index.php?v=Payment" method="post">
													<input type="hidden" name="process" value="1">
													<input type="hidden" name="packageId" value="<?php echo $package['id']; ?>">
													<button type="submit" class="btn btn-primary py-0 btn-sm"><?php echo Trans('app','Buy'); ?></button>
												</form>
												  
											</div>
										</div>
									</div>
							<?php }
							} ?>
							<!-- <div class="col-md-4"> 
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
							</div>  -->
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
								}
								$area = selectDB("areas","`id` = '".$ad['areaId']."'")[0];
								$gov = selectDB("governates","`id` = '".$area['governateId']."'")[0];
								//var_dump($gov);
								?>
								
								<?php
									//echo '<li><a id="'.$products[$i]["id"].'" class="edit" href="javascript:void(0)"><i class="zmdi zmdi-edit"></i></a></li>';
									//echo '<li><a href="'.$link.'"><i class="'.$icon.'"></i></a></li>';
									//echo "<li><a href='?v={$_GET["v"]}&forceDelete={$products[$i]["id"]}'><i class='fa fa-times'></i></a></li>";
								?>
								
								<div class="my-ad-list-item my-2">  
								<div class="row g-1"> 
									<div class="col-md-8 my-ad-list-item-side1"> 
									<?php
										if( $images = selectDB("images","`productId` = '".$ad['id']."'") ){
											for( $z = 0; $z < 1; $z++ ){
												if( $z == 0 ){
													$active = "active";
												}else{
													$active = "";
												}
												?>
												
												<img src="logos/<?php echo $images[$z]["imageurl"] ?>" class="img-fluid" style="width: 60px; height: 60px;" alt="...">
												<?php
											}
										}else{ ?>
									      <img src="assets/img/logo-big.png" class="img-fluid" style="width: 60px; height: 60px;" alt="...">
								       <?php } ?> 
										
										<div class="data">
											<h4><?php echo direction($ad['enTitle'],$ad['arTitle']); ?></h4>
											<h5><?php echo direction($gov['enTitle'],$gov['arTitle']); ?> - <?php echo direction($area['enTitle'],$area['arTitle']); ?></h5>
											<h6><?php echo Trans('app','Created Date'); ?> &nbsp;&nbsp; 
											<?php
											$adDate = new DateTime($ad['date']);
											$now = new DateTime();
											$diff = $now->diff($adDate);
											$hours = $diff->h + ($diff->days * 24);
									 		echo substr($ad['date'], 0, 10); ?></h6>
										</div> 
									</div>
									<div class="col-md-4 my-ad-list-item-side2">    
										<div class="viewers"><i class="bi bi-eye"></i><?php echo $ad['views']; ?></div>
										<div class="status"><span class="published ad-status-type"><i class="bi bi-check"></i></span></div>
										<div class="actions">
										<a href="#" 
											class="update" 
											onclick="return confirmUpdate('?v=EditAd&id=<?php echo $ad['id']; ?>');">
											<i class="bi bi-pencil-square"></i>
											</a>
											<a href="#" 
												class="delete" 
												onclick="return confirmDelete('?v=<?php echo $_GET['v']; ?>&forceDelete=<?php echo $ad['id']; ?>');">
												<i class="bi bi-trash3"></i>
											</a>
										</div> 
									</div>
								</div>
							</div> 

							<?php } ?>
						</div> 
						
						<div class="d-block text-center text-xl-end mt-3"> 
						  	<a href="?v=MyAdsList&type=active_ads&page=1" class="view-all" style="text-decoration: underline"><?php echo Trans('app','View All'); ?></a>
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
								}
								$area = selectDB("areas","`id` = '".$ad['areaId']."'")[0];
								$gov = selectDB("governates","`id` = '".$area['governateId']."'")[0];
								?>
								<div class="my-ad-list-item my-2"> 
								<div class="row g-1"> 
									<div class="col-md-8 my-ad-list-item-side1">  
									<?php
										if( $images = selectDB("images","`productId` = '".$ad['id']."'") ){
											for( $z = 0; $z < 1; $z++ ){
												if( $z == 0 ){
													$active = "active";
												}else{
													$active = "";
												}
												?>
												
												<img src="logos/<?php echo $images[$z]["imageurl"] ?>" class="img-fluid" style="width: 60px; height: 60px;" alt="...">
												<?php
											}
										}else{ ?>
									      <img src="assets/img/logo-big.png" class="img-fluid" style="width: 60px; height: 60px;" alt="...">
								       <?php } ?> 
										<div class="data">
											<h4><?php echo direction($ad['enTitle'],$ad['arTitle']); ?></h4>
											<h5><?php echo direction($gov['enTitle'],$gov['arTitle']); ?> - <?php echo direction($area['enTitle'],$area['arTitle']); ?></h5>
											<h6><?php echo Trans('app','Created Date'); ?> &nbsp;&nbsp; 
											<?php
											$adDate = new DateTime($ad['date']);
											$now = new DateTime();
											$diff = $now->diff($adDate);
											$hours = $diff->h + ($diff->days * 24);
									 		echo substr($ad['date'], 0, 10); ?>
											</h6>
										</div> 
									</div>
									<div class="col-md-4 my-ad-list-item-side2">    
										<div class="viewers"><i class="bi bi-eye"></i><?php echo $ad['views']; ?> </div>
										<div class="actions"> 
										<a href="#" 
											class="republish" 
											onclick="return confirmRepublish('?v=<?php echo $_GET['v']; ?>&republish=<?php echo $ad['id']; ?>');">
											<i class="bi bi-arrow-repeat"></i> <?php //echo Trans('app', 'Republish'); ?>
										</a>
										</div> 
									</div>
								   </div>
							     </div> 

							<?php } ?>
						</div> 
						<div class="d-block text-center text-xl-end mt-3"> 
						  	<a href="?v=MyAdsList&type=ended_ads&page=1" class="view-all" style="text-decoration: underline"><?php echo Trans('app','View All'); ?></a>
					    </div>
						
						
						
						
					</div>
				</div>
				
			</div>
			
			<div class="row row-fields d-flex align-items-stretch"> 
				
				<div class="col-md-12 col-lg-6 col-xl-6"> 
					<div class="with-white-bg  p-4 px-2 px-md-4"> 
						<div class="favourite-list ads-section">
						  <h4 class="mb-4"><?php echo Trans('app','Favourite'); ?></h4>	  	  
						  <?php foreach( $myFevoriteAds as $ad ){ 
								if( $ad["packageId"] == 2 ){
									$feature = "card-feature";
								}else{
									$feature = "";
								}
								$area = selectDB("areas","`id` = '".$ad['areaId']."'")[0];
								$gov = selectDB("governates","`id` = '".$area['governateId']."'")[0];
								?>
								<div class="my-ad-list-item my-2"> 
								<div class="row g-1"> 
									<div class="col-md-8 my-ad-list-item-side1">  
									<?php
										if( $images = selectDB("images","`productId` = '".$ad['id']."'") ){
											for( $z = 0; $z < 1; $z++ ){
												if( $z == 0 ){
													$active = "active";
												}else{
													$active = "";
												}
												?>
												
												<img src="logos/<?php echo $images[$z]["imageurl"] ?>" class="img-fluid" style="width: 60px; height: 60px;" alt="...">
												<?php
											}
										}else{ ?>
									      <img src="assets/img/logo-big.png" class="img-fluid" style="width: 60px; height: 60px;" alt="...">
								       <?php } ?> 
										<div class="data">
											<h4><a href="?v=AdView&id=<?php echo $ad['id']; ?>"><?php echo direction($ad['enTitle'],$ad['arTitle']); ?></a></h4>
											<h5><?php echo direction($gov['enTitle'],$gov['arTitle']); ?> - <?php echo direction($area['enTitle'],$area['arTitle']); ?></h5>
											<h6><?php echo Trans('app','Created Date'); ?> &nbsp;&nbsp; 
											<?php
											$adDate = new DateTime($ad['date']);
											$now = new DateTime();
											$diff = $now->diff($adDate);
											$hours = $diff->h + ($diff->days * 24);
									 		echo substr($ad['date'], 0, 10); ?>
											</h6>
										</div> 
									</div>
									<div class="col-md-4 my-ad-list-item-side2">    
										<div class="viewers"><i class="bi bi-eye"></i><?php echo $ad['views']; ?> </div>
										<div class="actions"> 
										<a href="#" 
											class="remove" 
											onclick="return confirmRemove('?v=<?php echo $_GET['v']; ?>&remove=<?php echo $ad['id']; ?>');">
											<i class="bi bi-trash3"></i> <?php //echo Trans('app', 'Republish'); ?>
										</a>
										</div> 
									</div>
								   </div>
							     </div> 

							<?php } ?>
						  <div class="d-block text-center text-xl-end mt-3"> 
						  	<a href="?v=MyAdsList&type=active_ads&page=1" class="view-all"><?php echo Trans('app','View All'); ?></a>
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
				function confirmRepublish(url) {
					if (confirm('Are you sure you want to republish this ad?')) {
						window.location.href = url;
					}
					return false; // Prevent the default link behavior
				}
				function confirmRemove(url) {
					if (confirm('Are you sure you want to remove this ad?')) {
						window.location.href = url;
					}
					return false; // Prevent the default link behavior
				}
			</script>