<?php 
if( isset($_GET["delId"]) && !empty($_GET["delId"]) ){
	if( updateDB('faq',array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		header("LOCATION: ?v=FAQ");
	}
}

if( isset($_POST["enTitle"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);
	if ( $id == 0 ){
		if( insertDB("faq", $_POST) ){
			header("LOCATION: ?v=FAQ");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}else{
		if( updateDB("faq", $_POST, "`id` = '{$id}'") ){
			header("LOCATION: ?v=FAQ");
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
		updateDB("faq",array("rank"=>$_POST["rank"][$i]),"`id` = '{$_POST["id"][$i]}'");
	}
	header("LOCATION: ?v=FAQ");
}
?>

<div class="row">		
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Governate Details","تفاصيل المحافظة") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			<div class="col-md-6">
			<label><?php echo direction("English Title","العنوان بالإنجليزي") ?></label>
			<input type="text" name="enTitle" class="form-control" required>
			</div>
			
			<div class="col-md-6">
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
<form method="post" action="">
<input name="updateRank" type="hidden" value="1">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of Governates","قائمة المحافظات") ?></h6>
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
		<th>#</th>
		<th><?php echo direction("English Title","العنوان بالإنجليزي") ?></th>
		<th><?php echo direction("Arabic Title","العنوان بالعربي") ?></th>
		<th class="text-nowrap"><?php echo direction("الخيارات","Actions") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		$orderBy = direction("enTitle","arTitle");
		if( $faqs = selectDB("faq","`status` = '0' ORDER BY `rank` ASC") ){
			for( $i = 0; $i < sizeof($governate); $i++ ){
				$counter = $i + 1;
				?>
				<tr>
                <td>
                <input name="rank[]" class="form-control" type="number" value="<?php echo $faqs[$i]["rank"] ?>">
                <input name="id[]" class="form-control" type="hidden" value="<?php echo $faqs[$i]["id"] ?>">
                </td>
				<td><?php echo $faqs[$i]["enQuestion"] ?></td>
				<td><?php echo $faqs[$i]["arQuestion"] ?></td>
				<td class="text-nowrap">
					<a id="<?php echo $faqs[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i>
					</a>
					<a href="<?php echo "?v={$_GET["v"]}&delId={$faqs[$i]["id"]}" ?>" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-close text-danger"></i>
					</a>	
                    <div style="display:none">
                        <label id="enQuestion<?php echo $faqs[$i]["id"] ?>"><?php echo $faqs[$i]["enQuestion"] ?>"></label>
                        <label id="arQuestion<?php echo $faqs[$i]["id"] ?>"><?php echo $faqs[$i]["arQuestion"] ?>"></label>
                        <label id="enAnswer<?php echo $faqs[$i]["id"] ?>"><?php echo $faqs[$i]["enAnswer"] ?>"></label>
                        <label id="arAnswer<?php echo $faqs[$i]["id"] ?>"><?php echo $faqs[$i]["arAnswer"] ?>"></label>
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
</form>
</div>

</div>
<script>
	$(document).on("click",".edit", function(){
		var id = $(this).attr("id");
		$("input[name=update]").val(id);
		$("input[name=enQuestion]").val($("#enQuestion"+id).html()).focus();
		$("input[name=arQuestion]").val($("#arQuestion"+id).html());
		$("input[name=enAnswer]").val($("#enAnswer"+id).html());
		$("input[name=arAnswer]").val($("#arAnswer"+id).html());
	})
</script>
