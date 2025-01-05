
<?php if(!$_SESSION['valid']){
	echo "<script>window.location.href = '/index.php?v=Login';</script>";
 } else {
	$normalAds = 0;
	$specialAds = 0;
	if($user[0]["id"] >0){
		$orderId = rand(0000,9999).time();
		$normalAds = $user[0]["normalAd"];
		$specialAds = $user[0]["specialAd"];
		$order = selectDB("orders2","`userId` = '{$user[0]["id"]}' ORDER BY `id` DESC LIMIT 1","");
		$package = selectDB("packages","`id` = '{$order[0]["packageId"]}' ORDER BY `id` DESC LIMIT 1","");
		if(isset($_POST["process"]) && $_POST["process"] == "1"){
		   $packageId = $_POST["packageId"];
		   
			if($package = selectDB("packages","`id` = '{$packageId}' ORDER BY `id` DESC LIMIT 1","")){
				$orderData = array(
					"userId" => $user[0]["id"],
					"orderId" => $orderId,
					"packageId" => $packageId,
					"price" => $package[0]["price"],
					"date" => date("Y-m-d H:i:s"),
					'info' => json_encode(array("name" => $user[0]["name"], "email" => $user[0]["email"], "phone" => $user[0]["phone"])),
					"status" => "0",
				);
				 
				if(insertDB("orders2", $orderData)){
					$data=array(
						"userId" => $user[0]["id"],
						"name" => $user[0]["name"],
						"email" => $user[0]["email"],
						"phone" => $user[0]["phone"],
						'orderId' => $orderId,
						"packageId" => $packageId,
						"price" => $package[0]["price"],
						"details" => $package[0]["details"],
						"totalAmount" => $package[0]["price"],
						"date" => date("Y-m-d H:i:s"),
					);
					$link=doPaymant($data);
					if($link){
						header("LOCATION: $link");die();
					}else{
						header("LOCATION: index.php?v=Payment&error=1");die();
					}	
				}else{
					header("LOCATION: index.php?v=Payment&error=1");die();
				}

			}
		}
 	}
}
?>
	<div class="row"> 
		<div class="col-md-11 mx-auto">
			<div class="guest-form-action">
				<div class="form-container form-container-add">
					<div class="start-page-title text-center mb-4">
						<h4><?php echo Trans('app','Payment'); ?></h4>
					</div> 
					<div class="form-outline mb-4">
						<?php if(isset($_GET["result"]) && $_GET["result"] == "CAPTURED"){
							if($_GET["requested_order_id"]){
								$orderId  = $_GET["requested_order_id"];
								$order = selectDB("orders2"," `orderId` = '{$orderId}' ORDER BY `id` DESC LIMIT 1","");
								//var_dump($order);
								if($order && $order[0]["status"] == "0"){
									$package = selectDB("packages","`id` = '{$order[0]["packageId"]}' ORDER BY `id` DESC LIMIT 1","");
									//var_dump($package);
									if($package){
										$user = selectDB("users","`id` = '{$order[0]["userId"]}' ORDER BY `id` DESC LIMIT 1","");
										$normalAds = $user[0]["normalAd"] + $package[0]["quantity"]; //normalAds
										$specialAds = $user[0]["specialAd"] + $package[0]["quantitySP"]; //specialAds
										$data = array(
											"normalAd" => "{$normalAds}",
											"specialAd" => "{$specialAds}",
										);
										updateDB("users",$data,"`id` = '{$user[0]["id"]}'");
									}
									$orderData = array(
										"gatewayId" => $_GET["payment_id"],
										"status" => "1",
									);
									updateDB("orders2",$orderData,"`id` = '{$order[0]["id"]}'");
									echo "<div class='alert alert-success'>".Trans('app','Payment completed successfully')."</div>";	
									echo "<a href='index.php?v=MyAds' class='btn btn-primary'>".Trans('app','MyAds')."</a>";
								}else{
									echo "<div class='alert alert-success'>".Trans('app','Payment completed successfully')."</div>";
									echo "<div class='text-default'>".Trans('app','Your ads have been activated')."</div>"; 
									echo "<div class='text-default'>".Trans('app','Order ID:'. $orderId)."</div>"; 
									echo "<div class='text-default'>".Trans('app','Payment ID:'.$_GET["payment_id"])."</div>"; 
									echo "<a href='index.php?v=MyAds' class='btn btn-primary'>".Trans('app','MyAds')."</a>";
								}
								
							}else{
								$order = selectDB("orders2","`userId` = '{$user[0]["id"]}' ORDER BY `id` DESC LIMIT 1","");
							}
			
						} else{
							if($_GET["requested_order_id"]){
								$orderId  = str_replace('?', '', $_GET["requested_order_id"]);
								echo "<div class='alert alert-danger'>".Trans('app','Payment failed')."</div>";
								echo "<div class='text-default'>".Trans('app','Order ID:'. $orderId)."</div>"; 
								echo "<a href='index.php?v=MyAds' class='btn btn-primary'>".Trans('app','Try again')."</a>";
							}
							
						} ?>
				
					</div>
				</div>
			</div>
		</div>
	</div>
		