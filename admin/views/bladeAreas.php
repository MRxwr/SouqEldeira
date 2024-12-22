<?php 
if( isset($_GET["delId"]) && !empty($_GET["delId"]) ){
	if( updateDB('areas',array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		header("LOCATION: ?v=Areas");
	}
}

if( isset($_POST["enTitle"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);
	if ( $id == 0 ){
		if( insertDB("areas", $_POST) ){
			header("LOCATION: ?v=Areas");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}else{
		if( updateDB("areas", $_POST, "`id` = '{$id}'") ){
			header("LOCATION: ?v=Areas");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}
}
?>

<div class="row">		
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Area Details","تفاصيل المنطقة") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			<div class="col-md-4">
			<label><?php echo direction("Governate","المحافظة") ?></label>
			<select name="governateId" class="form-control" required>
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

			<div class="col-md-4">
			<label><?php echo direction("English Title","العنوان بالإنجليزي") ?></label>
			<input type="text" name="enTitle" class="form-control" required>
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("Arabic Title","العنوان بالعربي") ?></label>
			<input type="text" name="arTitle" class="form-control" required>
			</div>
			
			<div class="col-md-12" style="margin-top:10px">
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
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of Areas","قائمة المناطق") ?></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
<div class="table-wrap mt-40">
<div class="table-responsive">
	<table class="table display responsive product-overview mb-30" id="myTable">
		<thead>
		<tr>
		<th class="text-nowrap"><?php echo direction("Governate","المحافظة") ?></th>
		<th><?php echo direction("English Title","العنوان بالإنجليزي") ?></th>
		<th><?php echo direction("Arabic Title","العنوان بالعربي") ?></th>
		<th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		$orderBy = direction("enTitle","arTitle");
		if( $areas = selectDB("areas","`status` = '0' ORDER BY `{$orderBy}` ASC") ){
			for( $i = 0; $i < sizeof($areas); $i++ ){
				$governate = selectDB("governates","`id` = '{$areas[$i]["governateId"]}'");
				$governateTitle = direction($governate[0]["enTitle"],$governate[0]["arTitle"]);
				$counter = $i + 1;
				?>
				<tr>
				<td><?php echo $governateTitle ?><label style="display:none" id="governate<?php echo $areas[$i]["id"]?>"><?php echo $areas[$i]["governateId"] ?></label></td>
				<td id="enTitle<?php echo $areas[$i]["id"]?>" ><?php echo $areas[$i]["enTitle"] ?></td>
				<td id="arTitle<?php echo $areas[$i]["id"]?>" ><?php echo $areas[$i]["arTitle"] ?></td>
				<td class="text-nowrap">
					<a id="<?php echo $areas[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i>
					</a>
					<a href="<?php echo "?v={$_GET["v"]}&delId={$areas[$i]["id"]}" ?>" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-close text-danger"></i>
					</a>			
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
		$("input[name=update]").val(id);
		$("input[name=enTitle]").val($("#enTitle"+id).html()).focus();
		$("select[name=governateId]").val($("#governate"+id).html());
		$("input[name=arTitle]").val($("#arTitle"+id).html());
	})
</script>
