<?php 
if( isset($_GET["delId"]) && !empty($_GET["delId"]) ){
	if( updateDB('notifications',array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		header("LOCATION: ?v=Notifications");
	}
}

if( isset($_POST["title"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);
	if ( $id == 0 ){
		if( insertDB("notifications", $_POST) ){
			header("LOCATION: ?v=Notifications");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}else{
		if( updateDB("notifications", $_POST, "`id` = '{$id}'") ){
			header("LOCATION: ?v=Notifications");
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
	<h6 class="panel-title txt-dark"><?php echo direction("Notification Details","تفاصيل الاشعار") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			<div class="col-md-6">
			<label><?php echo direction("Title","العنوان") ?></label>
			<input type="text" name="title" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Body","المحتوى") ?></label>
			<input type="text" name="body" class="form-control" required>
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
<h6 class="panel-title txt-dark"><?php echo direction("List of Notifications","قائمة التنبيهات") ?></h6>
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
		<th>#</th>
		<th><?php echo direction("Title","العنوان") ?></th>
		<th><?php echo direction("Body","المحتوى") ?></th>
		<th class="text-nowrap"><?php echo direction("الخيارات","Actions") ?></th>
		</tr>
		</thead>
		<tbody>
		<?php 
		if( $notification = selectDB("notifications","`status` = '0' ORDER BY `id` DESC") ){
			for( $i = 0; $i < sizeof($notification); $i++ ){
				$counter = $i + 1;
				?>
				<tr>
                <td><?php echo str_pad($counter, 3, "0", STR_PAD_LEFT); ?></td>
				<td id="title<?php echo $notification[$i]["id"]?>" ><?php echo $notification[$i]["title"] ?></td>
				<td id="body<?php echo $notification[$i]["id"]?>" ><?php echo $notification[$i]["body"] ?></td>
				<td class="text-nowrap">
					<a id="<?php echo $notification[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i>
					</a>
					<a href="<?php echo "?v={$_GET["v"]}&delId={$notification[$i]["id"]}" ?>" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-close text-danger"></i>
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
</form>
</div>

</div>
<script>
	$(document).on("click",".edit", function(){
		var id = $(this).attr("id");
		$("input[name=update]").val(id);
		$("input[name=title]").val($("#title"+id).html()).focus();
		$("input[name=body]").val($("#body"+id).html());
	})
</script>
