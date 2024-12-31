
<?php if(!$_SESSION['valid']){
	echo "<script>window.location.href = '/index.php?v=Login';</script>";
 } else {
	$normalAds = 0;
	$specialAds = 0;
	if($user[0]["id"] >0){
		$orderId = date("Ymd").rand(0000,9999).time();
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
					"price" => $package[0]["amount"],
					"date" => date("Y-m-d H:i:s"),
					'info' => json_encode(array("name" => $user[0]["name"], "email" => $user[0]["email"], "phone" => $user[0]["phone"])),
					"status" => "0",
				);
				var_dump($package);
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
					if($link=doPaymant($data)){
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
						<?php if(isset($_GET["success"]) && $_GET["success"] == "1"){
							
							
						} ?>
						<?php if(isset($_GET["error"]) && $_GET["error"] == "1"){
							
							
						} ?>
				
					</div>
				</div>
			</div>
		</div>
	</div>
		