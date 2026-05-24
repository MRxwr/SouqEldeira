<?php 
if( isset($_GET["delId"]) && !empty($_GET["delId"]) ){
	if( updateDB('packages',array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		header("LOCATION: ?v=Packages");
	}
}

if( isset($_GET["hide"]) && !empty($_GET["hide"]) ){
	if( updateDB("products",array('hidden'=> '2'),"`id` = '{$_GET["hide"]}'") ){
		header("LOCATION: ?v=Ads");
	}
}

if( isset($_GET["show"]) && !empty($_GET["show"]) ){
	if( updateDB("products",array('hidden'=> '1'),"`id` = '{$_GET["show"]}'") ){
		header("LOCATION: ?v=Ads");
	}
}

if( isset($_POST["enTitle"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);
	if( is_uploaded_file($_FILES['logo']['tmp_name']) ){
		$filenewname = uploadImageBanner($_FILES["logo"]["tmp_name"]);
		$_POST["logo"] = $filenewname;
	}
	if ( $id == 0 ){
		if( insertDB("packages", $_POST) ){
			header("LOCATION: ?v=Packages");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}else{
		if( updateDB("packages", $_POST, "`id` = '{$id}'") ){
			header("LOCATION: ?v=Packages");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}
}

if( isset($_POST["updateRank"]) ){
	for( $i = 0; $i < sizeof($_POST["rank"]); $i++){
		updateDB("packages",array("rank"=>$_POST["rank"][$i]),"`id` = '{$_POST["id"][$i]}'");
	}
	header("LOCATION: ?v=Packages");
}
?>
<div class="row">			
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Package Details","تفاصيل الباقة") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">

            <div class="col-md-12">
			<label><?php echo direction("Type","النوع") ?></label>
			<select name="type" class="selectpicker" data-style="form-control btn-default btn-outline">
                <option value="1"><?php echo direction("Normal","عادي") ?></option>
                <option value="2"><?php echo direction("Gold","الذهبيه") ?></option>
                <option value="2"><?php echo direction("Diamond","الماسية") ?></option>
            </select>
			</div>

            <div class="col-md-4">
			<label><?php echo direction("Color","اللون") ?></label>
			<input type="color" name="color" class="form-control" >
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("English Title","الإسم الإنجليزي") ?></label>
			<input type="text" name="enTitle" class="form-control" required>
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("Arabic Title","الإسم العربي") ?></label>
			<input type="text" name="arTitle" class="form-control" required>
			</div>

			<div class="col-md-3">
			<label><?php echo direction("Price","السعر") ?></label>
			<input type="number" step="any" name="price" class="form-control" >
			</div>

			<div class="col-md-3">
			<label><?php echo direction("Quantity","الكمية") ?></label>
			<input type="number" step="any" name="quantity" class="form-control" >
			</div>

            <div class="col-md-3">
			<label><?php echo direction("Quantity Special","الكمية الخاصة") ?></label>
			<input type="number" step="any" name="quantitySP" class="form-control" >
			</div>

            <div class="col-md-3">
			<label><?php echo direction("Expirey","المدة") ?></label>
			<input type="number" step="any" name="expirey" class="form-control" >
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
			<label><?php echo direction("Logo","الشعار") ?></label>
			<input type="file" name="logo" class="form-control" multiple>
			</div>

			<div id="images" class="col-md-12" style="display:none"></div>
			
			<div class="col-md-6" style="margin-top:10px">
			<input type="submit" class="btn btn-primary" value="<?php echo direction("Submit","أرسل") ?>">
			<input type="hidden" name="update" value="0">
			</div>
		</div>
	</form>
</div>
</div>
</div>
</div>
				
<!-- Bordered Table -->
<form method="post" action="">
<input name="updateRank" type="hidden" value="1">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of Packages","قائمة الباقات") ?></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
<button class="btn btn-primary"><?php echo direction("Submit rank","أرسل الترتيب") ?></button> 
<div class="table-wrap mt-40">
<div class="table-responsive">
	<table class="table display responsive product-overview mb-30" id="myTable">
		<thead>
		<tr>
		<th class="text-nowrap">#</th>
		<th><?php echo direction("English Title","الإسم الإنجليزي") ?></th>
		<th><?php echo direction("Arabic Title","الإسم العربي") ?></th>
		<th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $packages = selectDB("packages","`status` = '0' ORDER BY `rank` ASC") ){
			for( $i = 0; $i < sizeof($packages); $i++ ){
				$hidden = array(
					"text" => ($packages[$i]["hidden"] == 1) ? direction("Hide","أخفي") : direction("Show","أظهر"),
					"icon" => ($packages[$i]["hidden"] == 1) ? "fa fa-eye text-success" : "fa fa-eye-slash text-danger",
					"link" => "?v={$_GET["v"]}&" . (($packages[$i]["hidden"] == 1) ? "hide" : "show") . "={$packages[$i]["id"]}"
				)
				?>
				<tr>
				<td>
                    <input name="rank[]" class="form-control" type="number" value="<?php echo $packages[$i]["rank"] ?>">
                    <input name="id[]" class="form-control" type="hidden" value="<?php echo $packages[$i]["id"] ?>">
                </td>
				<td id="enTitle<?php echo $packages[$i]["id"]?>" ><?php echo $packages[$i]["enTitle"] ?></td>
				<td id="arTitle<?php echo $packages[$i]["id"]?>" ><?php echo $packages[$i]["arTitle"] ?></td>
				<td class="text-nowrap">
				
				<a id="<?php echo $packages[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i>
				</a>

				<a href="<?php echo $hidden["link"] ?>"  class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hidden["text"] ?>"><i class="<?php echo $hidden["icon"] ?>"></i>
				</a>

				<a href="<?php echo "?v={$_GET["v"]}&delId={$packages[$i]["id"]}" ?>" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-close text-danger"></i>
				</a>
				<div style="display:none">
					<label id="enDetails<?php echo $packages[$i]["id"]?>"><?php echo $packages[$i]["enDetails"] ?></label>
					<label id="arDetails<?php echo $packages[$i]["id"]?>"><?php echo $packages[$i]["arDetails"] ?></label>
					<label id="logo<?php echo $packages[$i]["id"]?>"><?php echo $packages[$i]["logo"] ?></label>
					<label id="price<?php echo $packages[$i]["id"]?>"><?php echo $packages[$i]["price"] ?></label>
					<label id="quantity<?php echo $packages[$i]["id"]?>"><?php echo $packages[$i]["quantity"] ?></label>
					<label id="color<?php echo $packages[$i]["id"]?>"><?php echo $packages[$i]["color"] ?></label>
					<label id="type<?php echo $packages[$i]["id"]?>"><?php echo $packages[$i]["type"] ?></label>
					<label id="expirey<?php echo $packages[$i]["id"]?>"><?php echo $packages[$i]["expirey"] ?></label>
					<label id="quantitySP<?php echo $packages[$i]["id"]?>"><?php echo $packages[$i]["quantitySP"] ?></label>
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
</form>
</div>
	<script>
		$(document).on("click",".edit", function(){
			var id = $(this).attr("id");
			$("input[name=update]").val(id);
			$("input[name=enTitle]").val($("#enTitle"+id).html()).focus();
			$("input[name=arTitle]").val($("#arTitle"+id).html());
			$("select[name=type]").val($("#type"+id).html());
			tinymce.get('enDetails').setContent($("#enDetails"+id).html());
			tinymce.get('arDetails').setContent($("#arDetails"+id).html());
			$("input[name=price]").val($("#price"+id).html());
			$("input[name=quantity]").val($("#quantity"+id).html());
			$("input[name=color]").val($("#color"+id).html());
			$("input[name=quantitySP]").val($("#quantitySP"+id).html());
			$("input[name=expirey]").val($("#expirey"+id).html());
			$("#images").empty().attr("style","margin-top:10px;display:block");
			$("#images").html("<img src='../logos/"+$("#logo"+id).html()+"' width='100' height='100'>");
		})
	</script>