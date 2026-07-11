
<?php 
if(!$_SESSION['valid']){
	echo "<script>window.location.href = '/login';</script>";
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
				
				// Verify if it's a free package and if user already has it
				if( $package[0]["price"] == 0 ){
					if( selectDB("orders2","`userId` = '{$user[0]["id"]}' AND `packageId` = '{$packageId}' AND `status` = '1'") ){
						header("LOCATION: /my-ads-error/1");die();
					}
				}

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
					$data = array(
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
					//$link = doPaymant($data, $package[0]["price"]);

					$bookeeyPipe = new bookeey;
					$bookeeyPipe->setSuccessUrl('https://souqeldeira.com/index.php');
					$bookeeyPipe->setFailureUrl('https://souqeldeira.com/index.php');
					$bookeeyPipe->setMerchantID('mer23000173');    // Set the Merchant ID
					$bookeeyPipe->setSecretKey('4653344');    // Set the Secret Key
					$bookeeyPipe->setIsTestModeEnable(0);  // FORCE LIVE MODE
					$bookeeyPipe->setOrderId(time());  // Set Order ID - This should be unique for each transaction.
					$bookeeyPipe->setAmount($package[0]["price"]);  // Set amount in KWD 
					$bookeeyPipe->setPayerName($user[0]["name"]);  // Set Payer Name
					$bookeeyPipe->setPayerPhone($user[0]["phone"]);  // Set Payer Phone Numner
					
					if (isset($_REQUEST['selectedPaymentOption'])) {
						$selectedPaymentOption = $_REQUEST['selectedPaymentOption'];
						$bookeeyPipe->setSelectedPaymentOption("knet");
					}else {
						$selectedPaymentOption = $bookeeyPipe->getDefaultPaymentOption();
						$bookeeyPipe->setSelectedPaymentOption("knet");
					}

					//if (isset($_REQUEST['initPayment'])) {
						// Pass sub merchant id(s) and amount(s) in the below format.
					$transactionDetails = array(
						array(
							"SubMerchUID" => "mer23000173",
							"Txn_AMT" => $package[0]["price"]
						)
					);
					if ( $package[0]["price"] == 0 ){
						header("LOCATION: index.php?v=Payment&finalstatus=".base64_encode("success")."&merchantTxnId={$orderId}");die();
					}
					$bookeeyPipe->initiatePayment($transactionDetails);
					exit;
				}else{
					header("LOCATION: /payment-error");die();
				}

			}
		} elseif(isset($_POST["process"]) && $_POST["process"] == "2"){
			$adType = $_POST["adType"];
			$quantity = (int)$_POST["quantity"];

			if($quantity > 0){
				$pricePerAd = ($adType == "special") ? 2 : 1;
				$totalPrice = $quantity * $pricePerAd;
				
				$infoData = array(
					"name" => $user[0]["name"], 
					"email" => $user[0]["email"], 
					"phone" => $user[0]["phone"],
					"adType" => $adType,
					"quantity" => $quantity
				);

				$orderData = array(
					"userId" => $user[0]["id"],
					"orderId" => $orderId,
					"packageId" => 0, // Using 0 for custom individual ad purchases
					"price" => $totalPrice,
					"date" => date("Y-m-d H:i:s"),
					'info' => json_encode($infoData),
					"status" => "0",
				);

				if(insertDB("orders2", $orderData)){
					$bookeeyPipe = new bookeey;
					$bookeeyPipe->setSuccessUrl('https://souqeldeira.com/index.php');
					$bookeeyPipe->setFailureUrl('https://souqeldeira.com/index.php');
					$bookeeyPipe->setMerchantID('mer23000173');    
					$bookeeyPipe->setSecretKey('4653344');    
					$bookeeyPipe->setIsTestModeEnable(0);  
					$bookeeyPipe->setOrderId(time());  
					$bookeeyPipe->setAmount($totalPrice);  
					$bookeeyPipe->setPayerName($user[0]["name"]);  
					$bookeeyPipe->setPayerPhone($user[0]["phone"]);  
					
					if (isset($_REQUEST['selectedPaymentOption'])) {
						$selectedPaymentOption = $_REQUEST['selectedPaymentOption'];
						$bookeeyPipe->setSelectedPaymentOption("knet");
					}else {
						$selectedPaymentOption = $bookeeyPipe->getDefaultPaymentOption();
						$bookeeyPipe->setSelectedPaymentOption("knet");
					}

					$transactionDetails = array(
						array(
							"SubMerchUID" => "mer23000173",
							"Txn_AMT" => $totalPrice
						)
					);
					
					$bookeeyPipe->initiatePayment($transactionDetails);
					exit;
				} else {
					header("LOCATION: /payment-error");die();
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
						<h4><?php echo direction("Bill","الفاتورة"); ?></h4>
					</div> 
					<div class="form-outline mb-4">
						<?php 
						if(isset($_GET["finalstatus"]) && strtolower(base64_decode($_GET["finalstatus"])) == "success"){
							if( isset($_GET["merchantTxnId"]) && !empty($_GET["merchantTxnId"]) ){
								$gatewayId  = $_GET["merchantTxnId"];
								$order = selectDBNew("orders2",[$gatewayId],"`orderId` = ?","`id` DESC LIMIT 1");
								if($order && $order[0]["status"] == "0"){
									$user = selectDBNew("users",[$order[0]["userId"]],"`id` = ?","`id` DESC LIMIT 1");

									if ($order[0]["packageId"] == 0) {
										// Dynamic Ad Purchase handling
										$infoText = json_decode($order[0]["info"], true);
										$normalAds = $user[0]["normalAd"]; 
										$specialAds = $user[0]["specialAd"]; 
										
										if (isset($infoText["adType"])) {
											if ($infoText["adType"] == "normal") {
												$normalAds += $infoText["quantity"];
											} elseif ($infoText["adType"] == "special") {
												$specialAds += $infoText["quantity"];
											}
										}
										
										$data = array(
											"normalAd" => "{$normalAds}",
											"specialAd" => "{$specialAds}",
										);
										updateDB("users",$data,"`id` = '{$user[0]["id"]}'");
									} else {
										// Package handling
										$package = selectDBNew("packages",[$order[0]["packageId"]],"`id` = ?","`id` DESC LIMIT 1");
										if($package){
											$normalAds = $user[0]["normalAd"] + $package[0]["quantity"]; 
											$specialAds = $user[0]["specialAd"] + $package[0]["quantitySP"]; 
											$data = array(
												"normalAd" => "{$normalAds}",
												"specialAd" => "{$specialAds}",
											);
											updateDB("users",$data,"`id` = '{$user[0]["id"]}'");
										}
									}

									$orderData = array(
										"gatewayId" => $_GET["merchantTxnId"],
										"status" => "1",
									);
									updateDB("orders2",$orderData,"`id` = '{$order[0]["id"]}'");
									echo "<div class='alert alert-success'>".direction("Payment completed successfully","تم إتمام الدفع بنجاح")."</div>";	
									echo "<div class='text-default'>".direction("Your ads have been activated","تم تفعيل إعلاناتك")."</div>"; 
									echo "<div class='text-default'>".direction("Order ID:". $order[0]["id"],"رقم الطلب:". $order[0]["id"])."</div>"; 
									echo "<div class='text-default'>".direction("Payment ID:". $gatewayId,"معرف الدفع:". $gatewayId)."</div>";
									echo "<a href='/my-ads' class='btn btn-primary'>".direction("MyAds","إعلاناتي")."</a>";
								}else{
									echo "<div class='alert alert-success'>".direction("Payment completed successfully","تم إتمام الدفع بنجاح")."</div>";
									echo "<div class='text-default'>".direction("Your ads have been activated","تم تفعيل إعلاناتك")."</div>"; 
									echo "<div class='text-default'>".direction("Order ID:". $order[0]["id"],"رقم الطلب:". $order[0]["id"])."</div>"; 
									echo "<div class='text-default'>".direction("Payment ID:". $gatewayId,"معرف الدفع:". $gatewayId)."</div>"; 
									echo "<a href='/my-ads' class='btn btn-primary'>".direction("MyAds","إعلاناتي")."</a>";
								}
							}else{
								echo "<div class='alert alert-warning'>".direction("Missing Invoice Reference","مرجع الفاتورة مفقود")."</div>";
								echo "<a href='/my-ads' class='btn btn-primary'>".direction("Try again","حاول مرة أخرى")."</a>";
							}
			
						} else{
							if($_GET["finalstatus"] && strtolower(base64_decode($_GET["finalstatus"])) == "failure"){
								$gatewayId  = str_replace('?', '', $_GET["merchantTxnId"]);
								echo "<div class='alert alert-danger'>".direction("Payment failed","فشل الدفع")."</div>";
								echo "<div class='text-default'>".direction("Order ID:". $order[0]["id"],"رقم الطلب:". $order[0]["id"])."</div>"; 
								echo "<div class='text-default'>".direction("Payment ID:". $gatewayId,"معرف الدفع:". $gatewayId)."</div>"; 
								echo "<a href='/my-ads' class='btn btn-primary'>".direction("Try again","حاول مرة أخرى")."</a>";
							}
							
						} ?>
				
					</div>
				</div>
			</div>
		</div>
	</div>
		