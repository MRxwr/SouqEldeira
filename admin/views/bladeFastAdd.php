<?php 
if( isset($_POST["enTitle"]) ){
	if( isset($_POST["id"]) && !empty($_POST["id"])){
		$product = selectDB("products","`id` = '{$_POST["id"]}'");
		$updateArray = array(
			"categoryId" => "{$_POST["categoryId"]}",
			"arTitle" => ($_POST["arTitle"]),
			"enTitle" => ($_POST["enTitle"]),
			"arDetails" => ($_POST["arDetails"]),
			"enDetails" => ($_POST["enDetails"]),
			"price" => "{$_POST["price"]}",
			"cost" => "{$_POST["cost"]}",
		);
		updateDB("products",$updateArray,"`id` LIKE '{$_POST["id"]}'");
		for( $i = 0; $i < sizeof($_FILES['logo']['tmp_name']); $i++ ){
			if( is_uploaded_file($_FILES['logo']['tmp_name'][$i]) ){
				$filenewname = uploadImageBanner($_FILES["logo"]["tmp_name"][$i]);
				insertDB("images",array("productId" => $_POST["id"],"imageurl" => $filenewname));
			}
		}
		header("LOCATION: index.php?v=FastAdd");
	}else{
		$files = array();
		foreach ($_FILES["logo"]["tmp_name"] as $key => $tmp_name) {
			$files[] = new CURLFile($tmp_name, $_FILES["logo"]["type"][$key], $_FILES["logo"]["name"][$key]);
		}
		$data = array(
			'categoryId' => $_POST["categoryId"],
			'enTitle' => $_POST["enTitle"],
			'arTitle' => $_POST["arTitle"],
			'enDetails' => $_POST["enDetails"],
			'arDetails' => $_POST["arDetails"],
			'price' => $_POST["price"],
			'cost' => $_POST["cost"],
		);
		foreach ($files as $key => $file) {
			$data["logo[$key]"] = $file;
		}
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "{$baseURL}requests/dashboard/index.php?a=Product&action=add",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => $data,
		));
		$response = curl_exec($curl);
		$response = json_decode($response, true);
		curl_close($curl);
		echo $response["data"]["msg"];
	}
}
?>
<div class="row">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Ads Details","تفاصيل الاعلان") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
            <div class="col-md-3">
			<label><?php echo direction("Category","القسم") ?></label>
				<select name="categoryId" class="selectpicker" data-style="form-control btn-default btn-outline" required>
					<?php
                    if( $categories = selectDB("categories","`status` = '0' AND `hidden` = '1'") ){
                        for( $i = 0; $i < sizeof($categories); $i++ ){
                            $title = direction($categories[$i]["enTitle"],$categories[$i]["arTitle"]);
                            echo "<option value='{$categories[$i]["id"]}'>{$title}</option>";
                        }
                    }
                    ?>
				</select>
			</div>

			<div class="col-md-3">
			<label><?php echo direction("English Title","العنوان بالإنجليزي") ?></label>
			<input type="text" name="enTitle" class="form-control" value=""required>
			</div>
			
			<div class="col-md-3">
			<label><?php echo direction("Arabic Title","العنوان بالعربي") ?></label>
			<input type="text" name="arTitle" class="form-control" value="" required>
			</div>

			<div class="col-md-3">
			<label><?php echo direction("Price","القيمة") ?></label>
			<input type="float" step="any" min="0" name="price" class="form-control" value="0" >
			</div>

			<div class="col-md-6">
			<label><?php echo direction("English Details","التفاصيل بالإنجليزي") ?></label>
			<textarea name="enDetails" class="tinymce"></textarea>
			</div>

			<div class="col-md-6">
			<label><?php echo direction("Arabic Details","التفاصيل بالعربي") ?></label>
			<textarea name="arDetails" class="tinymce"></textarea>
			</div>

			<div class="col-md-12">
			<label><?php echo direction("Image","صورة") ?></label>
			<input type="file" name="logo[]" class="form-control" multiple>
			</div>

			<div id="images" class="col-md-12" style="display:none">
			
			</div>
			
			<div class="col-md-12" style="margin-top:10px">
			<input type="submit" class="btn btn-primary" value="<?php echo direction("Submit","أرسل") ?>" onclick="showLoading()">
			<input type="hidden" name="id" value="0">
			</div>
		</div>
	</form>
</div>
</div>
</div>
</div>

<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left" style="width: 100%;">
	<h6 class="panel-title txt-dark"><?php echo direction("Ads List","قائمة الاعلانات") ?></h6>
	</div>
		<div class="clearfix"></div>
	</div>
	<div class="panel-wrapper collapse in">
	<div class="panel-body row">
	<div class="table-wrap">
	<div class="table-responsive">
	<table class="table display responsive product-overview mb-30" id="myTable">
		<thead>
			<tr>
			<th>#</th>
			<th><?php echo direction("Image","صورة") ?></th>
			<th><?php echo direction("English Title","العنوان بالإنجليزي") ?></th>
			<th><?php echo direction("Arabic Title","العنوان بالعربي") ?></th>
			<th><?php echo direction("Action","الخيارات") ?></th>
			</tr>
		</thead>
		<tbody>
		<?php 
		if( $products = selectDB("products","`status` = '0' AND `hidden` != '2' AND `enDetails` LIKE '' ORDER BY `id` DESC") ){
			for( $i = 0; $i < sizeof($products); $i++ ){
				if($image = selectDB("images","`productId` = '{$products[$i]["id"]}' ORDER BY `id` ASC")){
				}else{
					$image[0]["imageurl"] = "noimage.png";
				}
			if ( $products[$i]["hidden"] == 2 ){
				$icon = "fa fa-eye";
				$link = "?v={$_GET["v"]}&show={$products[$i]["id"]}";
				$hide = direction("Show","إظهار");
			}else{
				$icon = "fa fa-eye-slash";
				$link = "?v={$_GET["v"]}&hide={$products[$i]["id"]}";
				$hide = direction("Hide","إخفاء");
			}
			?>
			<tr>
				<td><?php echo str_pad($products[$i]["id"], 4, "0", STR_PAD_LEFT) ?></td>
				<td><img src="../logos/<?php echo $image[0]["imageurl"] ?>" style="width: 75px; height: 75px;"></td>
				<td id="enTitle<?php echo $products[$i]["id"] ?>"><?php echo $products[$i]["enTitle"] ?></td>
				<td id="arTitle<?php echo $products[$i]["id"] ?>"><?php echo $products[$i]["arTitle"] ?></td>
				<td class="text-nowrap">
					<div class="btn-group">
					  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Actions <span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu">
						<?php
						  echo '<li><a id="'.$products[$i]["id"].'" class="edit" href="javascript:void(0)"><i class="zmdi zmdi-edit"></i></a></li>';
						  if ( $products[$i]["hidden"] == 0 ){
							echo '<li><a href="includes/products/delete.php?id='.$products[$i]["id"].'"><i class="fa fa-eye-slash"></i></a></li>';
						  }else{
							echo '<li><a href="includes/products/delete.php?id='.$products[$i]["id"].'&show=1"><i class="fa fa-eye"></i></a></li>';
						  }
						  echo '<li><a href="includes/products/delete.php?id='.$products[$i]["id"].'&forceDelete=1"><i class="fa fa-times"></i></a></li>';
						  echo '<li role="separator" class="divider"></li>';
						  if( $products[$i]["bestSeller"] == 1 ){
							$color = "btn-success";
						  }else{
							$color = "btn-default";
						  }
						  echo '<li><a href="?v=Product&bestId='.$products[$i]["id"].'" class="'.$color.'"><i class="fa fa-usd"></i></a></li>';
						  if( $products[$i]["recent"] == 1 ){
							$color = "btn-success";
						  }else{
							$color = "btn-default";
						  }
						  echo '<li><a href="?v=Product&newId='.$products[$i]["id"].'" class="'.$color.'"><i class="fa fa-plus-square"></i></a></li>';
						?>
					  </ul>
					</div>
					<div style="display: none;">
						<label id="enDetails<?php echo $products[$i]["id"]?>"><?php echo $products[$i]["enDetails"] ?></label>
						<label id="arDetails<?php echo $products[$i]["id"]?>"><?php echo $products[$i]["arDetails"] ?></label>
						<label id="price<?php echo $products[$i]["id"]?>"><?php echo $products[$i]["price"] ?></label>
						<label id="image<?php echo $products[$i]["id"]?>"><?php echo json_encode($image)?></label>
						<label id="category<?php echo $products[$i]["id"]?>"><?php echo $categories ?></label>
					</div>
				</td>
			</tr>
			<?php
			}
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

<script>
	$(document).on("click",".edit", function(){
		var id = $(this).attr("id");
		$("input[name=id]").val(id);
		$("input[type=submit").val("<?php echo direction("Update","تحديث") ?>");
		$("input[name=enTitle]").val($("#enTitle"+id).html()).focus();;
		$("input[name=arTitle]").val($("#arTitle"+id).html());
		tinymce.get('enDetails').setContent($("#enDetails"+id).html());
		tinymce.get('arDetails').setContent($("#arDetails"+id).html());
		$("input[name=price]").val($("#price"+id).html());
		$("select[name=brandId] option").prop("selected", false);
		$("select[name=brandId]").val($("#brandId"+id).html()).selectpicker('refresh');
		$("select[name=categoryId] option").prop("selected", false);
		$("select[name=categoryId]").val($("#categoryId"+id).html()).selectpicker('refresh');
		$("#images").empty().attr("style","margin-top:10px;display:block"); // Clear the div
		$.each(JSON.parse($("#image"+id).html()), function(index, value){
			var img = $("<img>").attr({
				src: "../logos/" + value["imageurl"],
				width: 100,
				height: 100,
			});
			$("#images").append(img);
		});
	})
</script>
