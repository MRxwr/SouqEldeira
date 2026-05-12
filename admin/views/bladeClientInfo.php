<?php 
if( $user = selectDB("users","`id` = '{$_GET["id"]}'")){
	if( $settings = selectDB("settings","`id` = '1'") ){
		$defaultCurr = $settings[0]["currency"];
	}
}else{
	header("LOCATION: ?v=ListOfusers");die();
}

if (isset($_POST["assignPackage"]) && !empty($_POST["packageId"])) {
    $pkgId = $_POST["packageId"];
    if ($package = selectDB("packages", "`id` = '{$pkgId}'")) {
        $normalAds = $user[0]["normalAd"] + $package[0]["quantity"];
        $specialAds = $user[0]["specialAd"] + $package[0]["quantitySP"];
        $data = array(
            "normalAd" => $normalAds,
            "specialAd" => $specialAds
        );
        if (updateDB("users", $data, "`id` = '{$user[0]["id"]}'")) {
            echo "<script>alert('Package added successfullly. Normal Ads: {$normalAds}, Special Ads: {$specialAds}'); window.location.href='?v=ClientInfo&id={$user[0]["id"]}';</script>";
        }
    }
}
?>
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default card-view">
		<div class="panel-wrapper collapse in">
		<div class="panel-body">
		<div class="form-wrap">
			<form action="#">
				<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-info-outline mr-10"></i><?php echo direction("User Details","معلومات العضو") ?></h6>
				<hr class="light-grey-hr"/>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						<label class="control-label mb-10">Name</label>
						<input type="text" id="enname" class="form-control" value="<?php echo $user[0]["fName"] . " " . $user[0]["lName"];?>" disabled>
						</div>
					</div>
					<!--/span-->
					<div class="col-md-6">
						<div class="form-group">
						<label class="control-label mb-10">E-mail</label>
						<input type="text" id="arname" class="form-control" value="<?php echo $user[0]["email"];?>" disabled>
						</div>
					</div>
					<!--/span-->
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						<label class="control-label mb-10">Phone</label>
						<input type="text" id="enname" class="form-control" value="<?php echo $user[0]["phone"];?>" disabled>
						</div>
					</div>
					<!--/span-->
					<div class="col-md-6">
						<div class="form-group">
						<label class="control-label mb-10">Joinging Date</label>
						<input type="text" id="arname" class="form-control" value="<?php $date = explode(" ",$user[0]["date"]); echo $date[0];?>" disabled>
						</div>
					</div>
					<!--/span-->
				</div>
                
                <h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-Mall mr-10"></i><?php echo direction("Ad Balance & Packages","رصيد الإعلانات والباقات") ?></h6>
				<hr class="light-grey-hr"/>
                <div class="row">
					<div class="col-md-4">
						<div class="form-group">
						<label class="control-label mb-10"><?php echo direction("Normal Ads Balance","رصيد الإعلانات العادية") ?></label>
						<input type="text" class="form-control" value="<?php echo $user[0]["normalAd"];?>" disabled>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
						<label class="control-label mb-10"><?php echo direction("Special Ads Balance","رصيد الإعلانات المميزة") ?></label>
						<input type="text" class="form-control" value="<?php echo $user[0]["specialAd"];?>" disabled>
						</div>
					</div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <label class="control-label mb-10"><?php echo direction("Add Package","إضافة باقة") ?></label>
                        <div class="input-group">
                            <select name="packageId" class="form-control" id="packageSelect">
                                <option value=""><?php echo direction("Select Package","اختر الباقة") ?></option>
                                <?php 
                                if($packages = selectDB("packages","`status` = '0'")){
                                    foreach($packages as $pkg){
                                        $title = direction($pkg["enTitle"],$pkg["arTitle"]);
                                        echo "<option value='{$pkg["id"]}' data-normal='{$pkg["quantity"]}' data-special='{$pkg["quantitySP"]}'>{$title} (N:{$pkg["quantity"]}, S:{$pkg["quantitySP"]})</option>";
                                    }
                                }
                                ?>
                            </select>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary" onclick="confirmPackage()"><?php echo direction("Add","إضافة") ?></button>
                            </span>
                        </div>
                        </div>
                    </div>
				</div>
			</form>
		</div>
		</div>
		</div>
		</div>
	</div>

    <form id="packageForm" method="POST" action="">
        <input type="hidden" name="assignPackage" value="1">
        <input type="hidden" name="packageId" id="hiddenPackageId">
    </form>

    <script>
    function confirmPackage() {
        var select = document.getElementById('packageSelect');
        var pkgId = select.value;
        if (!pkgId) {
            alert('Please select a package');
            return;
        }
        var option = select.options[select.selectedIndex];
        var normal = option.getAttribute('data-normal');
        var special = option.getAttribute('data-special');
        var title = option.text;

        if (confirm('Are you sure you want to add this package?\n' + title + '\nNormal Ads: ' + normal + '\nSpecial Ads: ' + special)) {
            document.getElementById('hiddenPackageId').value = pkgId;
            document.getElementById('packageForm').submit();
        }
    }
    </script>

<?php

$sql = "SELECT *
		FROM `orders2`
		WHERE
		JSON_UNQUOTE(JSON_EXTRACT(info,'$.name')) LIKE '%{$user[0]["fName"]}%'
		AND
		JSON_UNQUOTE(JSON_EXTRACT(info,'$.name')) LIKE '%{$user[0]["lName"]}%'
		AND
		JSON_UNQUOTE(JSON_EXTRACT(info,'$.email')) LIKE '%{$user[0]["email"]}%'
		AND
		JSON_UNQUOTE(JSON_EXTRACT(info,'$.phone')) LIKE '%{$user[0]["phone"]}%'
		";
$result = $dbconnect->query($sql);
?>
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-wrapper collapse in">
<div class="panel-body row">
<div class="table-wrap">
<div class="table-responsive">
<table class="table display responsive product-overview mb-30" id="myTable">
<thead>
<tr>
<th><?php echo direction("Date","التاريخ") ?></th>
<th><?php echo "#" ?></th>
<th><?php echo direction("Voucher","كود الخصم") ?></th>
<th><?php echo direction("Total","المجموع") ?></th>
<th><?php echo direction("Payment Method","طريقة الدفع") ?></th>
<th><?php echo direction("Status","الحاله") ?></th>
<th><?php echo direction("Actions","الخيارات") ?></th>
</tr>
</thead>
<tbody>
<?php 
while ( $row = $result->fetch_assoc() ){
	$info = json_decode($row["info"],true);
	$voucher = json_decode($row["voucher"],true);
	$address = json_decode($row["address"],true);
	$items = json_decode($row["items"],true);
	$orederID = $row["orderId"];
	?>
	<tr>
		<td><?php echo $row["date"] ?></td>
		<td class="txt-dark"><?php echo $row["orderId"] ?></td>
		<td><?php echo $voucher[0]["voucher"] ?></td>
		<td><?php echo numTo3Float($row["price"]+$address["shipping"]) . $defaultCurr ?></td>
		<td>
			<?php 
			if( $row["paymentMethod"] == 1 ){
				echo "<b style='color:darkblue'>Online Payment</b>";
			}else{
				echo "<b style='color:darkgreen'>CASH</b>";
			}
			?>
		</td>
		<td>
			<?php 
			if( $row["status"] == 5 ){
				echo "<span class='label label-warning font-weight-100'>".direction("On Delivery","جاري التوصيل")."</span>";
			}elseif( $row["status"] == 4 ){
				echo "<span class='label label-success font-weight-100'>".direction("Delivered","تم التوصيل")."</span>";
			}elseif( $row["status"] == 3 ){
				//echo "<span class='label label-danger font-weight-100'>$Returned</span>";
			}elseif( $row["status"] == 2 ){
				echo "<span class='label label-default font-weight-100'>".direction("Failed","فشل")."</span>";
			}elseif( $row["status"] == 1 ){
				echo "<span class='label label-primary font-weight-100'>".direction("Paid","تم الدفع")."</span>";
			}elseif( $row["status"] == 0 ){
				echo "<span class='label label-default font-weight-100'>".direction("Pending","قيد الانتظار")."</span>";
			}
			?>
		</td>
		<td>
			<a target="_blank" href="?v=Order&orderId=<?php echo $orederID ?>">
			<button class="btn btn-info btn-rounded"><?php echo direction("View","عرض") ?>
			</button>
		</td>
	</tr>
	<?php
}
?>
</tbody>
</table>
</div>
</div>	
</div>	
</div>
</div>
</div>
</div>