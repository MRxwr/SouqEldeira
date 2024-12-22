<?php 
if( isset($_GET["delId"]) && !empty($_GET["delId"]) ){
	if( updateDB('shops',array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		header("LOCATION: ?v=Shops");
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
		if( insertDB("shops", $_POST) ){
			header("LOCATION: ?v=Shops");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}else{
		if( updateDB("shops", $_POST, "`id` = '{$id}'") ){
			header("LOCATION: ?v=Shops");
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
		updateDB("shops",array("rank"=>$_POST["rank"][$i]),"`id` = '{$_POST["id"][$i]}'");
	}
	header("LOCATION: ?v=Shops");
}
?>
<div class="row">			
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Office Details","تفاصيل المكتب") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			
			<div class="col-md-6">
			<label><?php echo direction("English Title","الإسم الإنجليزي") ?></label>
			<input type="text" name="enTitle" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Arabic Title","الإسم العربي") ?></label>
			<input type="text" name="arTitle" class="form-control" required>
			</div>

			<div class="col-md-6">
			<label><?php echo direction("Mobile","الهاتف") ?></label>
			<input type="number" step="any" maxlength="8" minlength="8" name="mobile" class="form-control" >
			</div>

			<div class="col-md-6">
			<label><?php echo direction("Link","الرابط") ?></label>
			<input type="text" name="url" class="form-control" >
			</div>

			<div class="col-md-3">
			<label><?php echo direction("Facebook","فيسبوك") ?></label>
			<input type="text" name="facebook" class="form-control" >
			</div>

			<div class="col-md-3">
			<label><?php echo direction("Instagram","انستقرام") ?></label>
			<input type="text" name="instagram" class="form-control" >
			</div>

			<div class="col-md-3">
			<label><?php echo direction("Twitter","تويتر") ?></label>
			<input type="text" name="twitter" class="form-control" >
			</div>

			<div class="col-md-3">
			<label><?php echo direction("E-mail","البريد الإلكتروني") ?></label>
			<input type="text" name="email" class="form-control" >
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
<h6 class="panel-title txt-dark"><?php echo direction("List of Offices","قائمة المكاتب") ?></h6>
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
		if( $shops = selectDB("shops","`status` = '0' order by `rank` ASC") ){
			for( $i = 0; $i < sizeof($shops); $i++ ){
				?>
				<tr>
				<td>
                <input name="rank[]" class="form-control" type="number" value="<?php echo $shops[$i]["rank"] ?>">
                <input name="id[]" class="form-control" type="hidden" value="<?php echo $shops[$i]["id"] ?>">
                </td>
				<td id="enTitle<?php echo $shops[$i]["id"]?>" ><?php echo $shops[$i]["enTitle"] ?></td>
				<td id="arTitle<?php echo $shops[$i]["id"]?>" ><?php echo $shops[$i]["arTitle"] ?></td>
				<td class="text-nowrap">
				
				<a id="<?php echo $shops[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i>
				</a>

				<a href="<?php echo "?v={$_GET["v"]}&delId={$shops[$i]["id"]}" ?>" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-close text-danger"></i>
				</a>
				<div style="display:none">
					<label id="enDetails<?php echo $shops[$i]["id"]?>"><?php echo $shops[$i]["enDetails"] ?></label>
					<label id="arDetails<?php echo $shops[$i]["id"]?>"><?php echo $shops[$i]["arDetails"] ?></label>
					<label id="logo<?php echo $shops[$i]["id"]?>"><?php echo $shops[$i]["logo"] ?></label>
					<label id="facebook<?php echo $shops[$i]["id"]?>"><?php echo $shops[$i]["facebook"] ?></label>
					<label id="twitter<?php echo $shops[$i]["id"]?>"><?php echo $shops[$i]["twitter"] ?></label>
					<label id="instagram<?php echo $shops[$i]["id"]?>"><?php echo $shops[$i]["instagram"] ?></label>
					<label id="email<?php echo $shops[$i]["id"]?>"><?php echo $shops[$i]["email"] ?></label>
					<label id="mobile<?php echo $shops[$i]["id"]?>"><?php echo $shops[$i]["mobile"] ?></label>
					<label id="url<?php echo $shops[$i]["id"]?>"><?php echo $shops[$i]["url"] ?></label>
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
			tinymce.get('enDetails').setContent($("#enDetails"+id).html());
			tinymce.get('arDetails').setContent($("#arDetails"+id).html());
			$("input[name=facebook]").val($("#facebook"+id).html());
			$("input[name=twitter]").val($("#twitter"+id).html());
			$("input[name=instagram]").val($("#instagram"+id).html());
			$("input[name=email]").val($("#email"+id).html());
			$("input[name=mobile]").val($("#mobile"+id).html());
			$("input[name=url]").val($("#url"+id).html());
			$("#images").empty().attr("style","margin-top:10px;display:block");
			$("#images").html("<img src='../logos/"+$("#logo"+id).html()+"' width='100' height='100'>");
		})
	</script>