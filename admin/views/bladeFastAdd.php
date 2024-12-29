<?php 
if( isset($_POST["enTitle"]) ){
	$dataArray = array(
		"categoryId" => "{$_POST["categoryId"]}",
		"packageId" => "{$_POST["packageId"]}",
		"governateId" => "{$_POST["governateId"]}",
		"shopId" => "{$_POST["shopId"]}",
		"userId" => "{$_POST["userId"]}",
		"propertyType" => "{$_POST["propertyType"]}",
		"areaId" => "{$_POST["areaId"]}",
		"arTitle" => "{$_POST["arTitle"]}",
		"enTitle" => "{$_POST["enTitle"]}",
		"arDetails" => "{$_POST["arDetails"]}",
		"enDetails" => "{$_POST["enDetails"]}",
		"price" => "{$_POST["price"]}",
	);
	if( isset($_POST["id"]) && !empty($_POST["id"])){
		$product = selectDB("products","`id` = '{$_POST["id"]}'");
		updateDB("products",$dataArray,"`id` LIKE '{$_POST["id"]}'");
		for( $i = 0; $i < sizeof($_FILES['logo']['tmp_name']); $i++ ){
			if( is_uploaded_file($_FILES['logo']['tmp_name'][$i]) ){
				$filenewname = uploadImageBanner($_FILES["logo"]["tmp_name"][$i]);
				insertDB("images",array("productId" => $_POST["id"],"imageurl" => $filenewname));
			}
		}
		header("LOCATION: index.php?v=FastAdd");die();
	}else{
		if( insertDB("products",$dataArray) ){
			for( $i = 0; $i < sizeof($_FILES['logo']['tmp_name']); $i++ ){
				if( is_uploaded_file($_FILES['logo']['tmp_name'][$i]) ){
					$filenewname = uploadImageBanner($_FILES["logo"]["tmp_name"][$i]);
					$product = selectDB("products","`id` != '0' ORDER BY `id` DESC LIMIT 1");
					insertDB("images",array("productId" => $product[0]["id"],"imageurl" => $filenewname));
				}
			}
			header("LOCATION: index.php?v=FastAdd");die();
		}else{
			?>
			<script>
				alert("Could not process your request, Please try again.");
			</script>
			<?php
			header("LOCATION: index.php?v=FastAdd");die();
		}
		
	}
}

if( isset($_GET["deleteImage"]) && !empty($_GET["deleteImage"]) ){
	$image = selectDB("images","`id` = '{$_GET["deleteImage"]}'");
	if( $image[0]["imageurl"] != "noimage.png" ){
		unlink("../logos/{$image[0]["imageurl"]}");
	}
	if( deleteDB("images","`id` = '{$_GET["deleteImage"]}'") ){
		header("LOCATION: index.php?v=FastAdd");die();
	}
}

if( isset($_GET["show"]) && !empty($_GET["show"]) ){
	updateDB("products",array("hidden" => 0),"`id` = '{$_GET["show"]}'");
	header("LOCATION: index.php?v=FastAdd");die();
}

if( isset($_GET["hide"]) && !empty($_GET["hide"]) ){
	updateDB("products",array("hidden" => 2),"`id` = '{$_GET["hide"]}'");
	header("LOCATION: index.php?v=FastAdd");die();
}

if( isset($_GET["forceDelete"]) && !empty($_GET["forceDelete"]) ){
	updateDB("products",array("status" => 1),"`id` = '{$_GET["forceDelete"]}'");
	header("LOCATION: index.php?v=FastAdd");die();
}
?>
<style>
	.delete-btn {
		position: absolute;
		top: 50%;
		left: 20%;
		transform: translate(-50%, -50%);
		font-size: 24px;
		font-weight: bold;
		color: #c46666;
		cursor: pointer;
		display: none;
	}
</style>

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

			<div class="col-md-4">
			<label><?php echo direction("Offices","المكاتب") ?></label>
				<select name="shopId" class="selectpicker" data-style="form-control btn-default btn-outline" required>
					<option value="0" selected default><?php echo direction("None","لا يوجد") ?></option>
					<?php
                    if( $shops = selectDB("shops","`status` = '0' AND `hidden` = '1'") ){
                        for( $i = 0; $i < sizeof($shops); $i++ ){
                            $title = direction($shops[$i]["enTitle"],$shops[$i]["arTitle"]);
                            echo "<option value='{$shops[$i]["id"]}'>{$title}</option>";
                        }
                    }
                    ?>
				</select>
			</div>

			<div class="col-md-4">
			<label><?php echo direction("Users","المستخدمين") ?></label>
				<select name="userId" class="selectpicker" data-style="form-control btn-default btn-outline" required>
					<option value="0" selected default><?php echo direction("None","لا يوجد") ?></option>
					<?php
                    if( $users = selectDB("users","`status` = '0' AND `hidden` = '0'") ){
                        for( $i = 0; $i < sizeof($users); $i++ ){
                            $title = $users[$i]["name"];
                            echo "<option value='{$users[$i]["id"]}'>{$title}</option>";
                        }
                    }
                    ?>
				</select>
			</div>

            <div class="col-md-4">
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
			<label><?php echo direction("Property Type","نوع العقار") ?></label>
				<select name="propertyType" class="selectpicker" data-style="form-control btn-default btn-outline" required>
					<?php
                    if( $propertyType = selectDB("propertyType","`status` = '0' AND `hidden` = '1'") ){
                        for( $i = 0; $i < sizeof($propertyType); $i++ ){
                            $title = direction($propertyType[$i]["enTitle"],$propertyType[$i]["arTitle"]);
                            echo "<option value='{$propertyType[$i]["id"]}'>{$propertyType}</option>";
                        }
                    }
                    ?>
				</select>
			</div>

			<div class="col-md-3">
			<label><?php echo direction("Package","الباقة") ?></label>
			<select name="packageId" class="selectpicker" data-style="form-control btn-default btn-outline" required>
				<?php
				if( $packages = selectDB("packages","`status` = '0' ORDER BY `rank` ASC") ){
					for( $i = 0; $i < sizeof($packages); $i++ ){
						$title = direction($packages[$i]["enTitle"],$packages[$i]["arTitle"]);
						echo "<option value='{$packages[$i]["id"]}'>{$title}</option>";
					}
				}
				?>
			</select>
			</div>

			<div class="col-md-3">
			<label><?php echo direction("Governate","المحافظة") ?></label>
			<select name="governateId" class="selectpicker" data-style="form-control btn-default btn-outline" required>
				<?php
				if( $governates = selectDB("governates","`status` = '0' ORDER BY `rank` ASC") ){
					for( $i = 0; $i < sizeof($governates); $i++ ){
						$title = direction($governates[$i]["enTitle"],$governates[$i]["arTitle"]);
						echo "<option value='{$governates[$i]["id"]}'>{$title}</option>";
					}
				}
				?>
			</select>
			</div>

			<div class="col-md-3">
			<label><?php echo direction("Area","المنطقة") ?></label>
			<select name="areaId" class="selectpicker" data-style="form-control btn-default btn-outline" required>
				<?php
				$governateId = 0;
				$directionOfArea = direction("enTitle","arTitle");
				if( $governates = selectDB("governates","`status` = '0' ORDER BY `rank` ASC") ){
					for( $i = 0; $i < sizeof($governates); $i++ ){
						$governate = selectDB("governates","`id` = '{$governates[$i]["id"]}'");
						$governateTitle = direction($governate[0]["enTitle"],$governate[0]["arTitle"]);
						echo "<optgroup label='{$governateTitle}'>";
						if( $areas = selectDB("areas","`status` = '0' AND `governateId` = '{$governates[$i]["id"]}' ORDER BY `{$directionOfArea}` ASC") ){
							for( $j = 0; $j < sizeof($areas); $j++ ){
								$title = direction($areas[$j]["enTitle"],$areas[$j]["arTitle"]);
								echo "<option value='{$areas[$j]["id"]}'>{$title}</option>";
							}
						}
					}
					echo "</optgroup>";
				}
				?>
			</select>
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("Arabic Title","العنوان بالعربي") ?></label>
			<input type="text" name="arTitle" class="form-control" value="" required>
			</div>

			<div class="col-md-4">
			<label><?php echo direction("English Title","العنوان بالإنجليزي") ?></label>
			<input type="text" name="enTitle" class="form-control" value=""required>
			</div>

			<div class="col-md-4">
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
			<th><?php echo direction("Governate","المحافظة") ?></th>
			<th><?php echo direction("Area","المنطقة") ?></th>
			<th><?php echo direction("English Title","العنوان بالإنجليزي") ?></th>
			<th><?php echo direction("Arabic Title","العنوان بالعربي") ?></th>
			<th><?php echo direction("Action","الخيارات") ?></th>
			</tr>
		</thead>
		<tbody>
		<?php 
		if( $products = selectDB("products","`status` = '0' AND `hidden` != '2' ORDER BY `id` DESC") ){
			for( $i = 0; $i < sizeof($products); $i++ ){
				if($image = selectDB("images","`productId` = '{$products[$i]["id"]}' ORDER BY `id` ASC")){
				}else{
					$image[0]["imageurl"] = "noimage.png";
				}
				$area = selectDB("areas","`id` = '{$products[$i]["areaId"]}'");
				$governate = selectDB("governates","`id` = '{$products[$i]["governateId"]}'");
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
				<td><?php echo direction($governate[0]["enTitle"],$governate[0]["arTitle"]) ?></td>
				<td><?php echo direction($area[0]["enTitle"],$area[0]["arTitle"]) ?></td>
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
						  echo '<li><a href="'.$link.'"><i class="'.$icon.'"></i></a></li>';
						  echo "<li><a href='?v={$_GET["v"]}&forceDelete={$products[$i]["id"]}'><i class='fa fa-times'></i></a></li>";
						?>
					  </ul>
					</div>
					<div style="display: none;">
						<label id="enDetails<?php echo $products[$i]["id"]?>"><?php echo $products[$i]["enDetails"] ?></label>
						<label id="arDetails<?php echo $products[$i]["id"]?>"><?php echo $products[$i]["arDetails"] ?></label>
						<label id="price<?php echo $products[$i]["id"]?>"><?php echo $products[$i]["price"] ?></label>
						<label id="image<?php echo $products[$i]["id"]?>"><?php echo json_encode($image)?></label>
						<label id="categoryId<?php echo $products[$i]["id"]?>"><?php echo $products[$i]["categoryId"] ?></label>
						<label id="packageId<?php echo $products[$i]["id"]?>"><?php echo $products[$i]["packageId"] ?></label>
						<label id="area<?php echo $products[$i]["id"]?>"><?php echo $products[$i]["areaId"] ?></label>
						<label id="governate<?php echo $products[$i]["id"]?>"><?php echo $products[$i]["governateId"] ?></label>
						<label id="shopId<?php echo $products[$i]["id"]?>"><?php echo $products[$i]["shopId"] ?></label>
						<label id="userId<?php echo $products[$i]["id"]?>"><?php echo $products[$i]["userId"] ?></label>
						<label id="propertyType<?php echo $products[$i]["id"]?>"><?php echo $products[$i]["propertyType"] ?></label>
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
		$("select[name=governateId] option").prop("selected", false);
		$("select[name=governateId]").val($("#governateId"+id).html()).selectpicker('refresh');
		$("select[name=areaId] option").prop("selected", false);
		$("select[name=areaId]").val($("#areaId"+id).html()).selectpicker('refresh');
		$("select[name=categoryId] option").prop("selected", false);
		$("select[name=categoryId]").val($("#categoryId"+id).html()).selectpicker('refresh');
		$("select[name=packageId] option").prop("selected", false);
		$("select[name=packageId]").val($("#packageId"+id).html()).selectpicker('refresh');
		$("select[name=propertyType] option").prop("selected", false);
		$("select[name=propertyType]").val($("#propertyType"+id).html()).selectpicker('refresh');
		$("select[name=shopId] option").prop("selected", false);
		$("select[name=shopId]").val($("#shopId"+id).html()).selectpicker('refresh');
		$("select[name=userId] option").prop("selected", false);
		$("select[name=userId]").val($("#userId"+id).html()).selectpicker('refresh');
		$("#images").empty().attr("style","margin-top:10px;display:block"); // Clear the div
		$.each(JSON.parse($("#image"+id).html()), function(index, value){
		var container = $("<div>").css("position", "relative");
		var img = $("<img>").attr({
			src: "../logos/" + value["imageurl"],
			width: 100,
			height: 100,
		});
		// Wrap the image in an <a> tag
		var a = $("<a>").attr("href", "javascript:void(0)");
		a.append(img);
		container.append(a);
		// Add a delete button
		var deleteBtn = $("<span>").addClass("delete-btn").html("X");
		container.append(deleteBtn);
		// Add a hover effect to show the delete button
		container.hover(function() {
			$(this).find("img").css("opacity", 0.5); // Make the image slightly transparent
			$(this).find(".delete-btn").show();
		}, function() {
			$(this).find("img").css("opacity", 1); // Reset the image opacity
			$(this).find(".delete-btn").hide();
		});
		// Add a click event to the delete button
		deleteBtn.click(function(e) {
			e.stopPropagation(); // Prevent the click event from bubbling up
			if (confirm("Are you sure you want to delete this image?")) {
			var imageId = value["id"]; // Assuming the imageId is stored in the value object
			window.location.href = "?v=FastAdd&deleteImage=" + imageId;
			}
		});
		$("#images").append(container);
		});
	})
</script>
