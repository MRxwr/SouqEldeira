<?php 
if( isset($_GET["hide"]) && !empty($_GET["hide"]) ){
	if( updateDB("news",array('hidden'=> '2'),"`id` = '{$_GET["hide"]}'") ){
		header("LOCATION: ?v=News");
	}
}

if( isset($_GET["show"]) && !empty($_GET["show"]) ){
	if( updateDB("news",array('hidden'=> '1'),"`id` = '{$_GET["show"]}'") ){
		header("LOCATION: ?v=News");
	}
}

if( isset($_GET["delId"]) && !empty($_GET["delId"]) ){
	if( updateDB("news",array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		header("LOCATION: ?v=News");
	}
}

if( isset($_POST["updateRank"]) ){
	for( $i = 0; $i < sizeof($_POST["rank"]); $i++){
		updateDB("news",array("rank"=>$_POST["rank"][$i]),"`id` = '{$_POST["id"][$i]}'");
	}
	header("LOCATION: ?v=News");
}

if( isset($_POST["enTitle"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);
    if (is_uploaded_file($_FILES['imageurl']['tmp_name'])) {
        $_POST["imageurl"] = uploadImageBanner($_FILES['imageurl']['tmp_name']);
    }else{
        unset($_POST["imageurl"]);
    }
    if (is_uploaded_file($_FILES['enImageurl']['tmp_name'])) {
        $_POST["enImageurl"] = uploadImageBanner($_FILES['enImageurl']['tmp_name']);
    }else{
        unset($_POST["enImageurl"]);
    }
	if ( $id == 0 ){
		if( insertDB("news", $_POST) ){
			header("LOCATION: ?v=News");
		}else{
		?>
<script>
alert("Could not process your request, Please try again.");
</script>
<?php
		}
	}else{
		if( updateDB("news", $_POST, "`id` = '{$id}'") ){
			header("LOCATION: ?v=News");
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
                    <h6 class="panel-title txt-dark"><?php echo direction("News Details","تفاصيل الخبر") ?></h6>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <form class="" method="POST" action="" enctype="multipart/form-data">
                        <div class="row m-0">
                            <div class="col-md-4">
                                <label><?php echo direction("Arabic Title","العنوان بالعربي") ?></label>
                                <input type="text" name="arTitle" class="form-control" required>
                            </div>

                            <div class="col-md-4">
                                <label><?php echo direction("English Title","العنوان بالإنجليزي") ?></label>
                                <input type="text" name="enTitle" class="form-control" required>
                            </div>

                            <div class="col-md-4">
                                <label><?php echo direction("Hide News","أخفي الخبر") ?></label>
                                <select name="hidden" class="form-control">
                                    <option value="1">No</option>
                                    <option value="2">Yes</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label><?php echo direction("English Details","التفاصيل بالإنجليزي") ?></label>
                                <textarea name="enDetails" class="tinymce"></textarea>
                            </div>

                            <div class="col-md-6">
                                <label><?php echo direction("Arabic Details","التفاصيل بالعربي") ?></label>
                                <textarea name="arDetails" class="tinymce"></textarea>
                            </div>

                            <div class="col-md-6">
                                <label><?php echo direction("English Logo","الشعار بالإنجليزي") ?></label>
                                <input type="file" name="enImageurl" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label><?php echo direction("Logo","الشعار") ?></label>
                                <input type="file" name="imageurl" class="form-control">
                            </div>

                            <div id="images" style="margin-top: 10px; display:none">
                                <div class="col-md-6">
                                    <img id="logoEnImg" src="" style="width:250px;height:250px">
                                </div>
                                <div class="col-md-6">
                                    <img id="logoImg" src="" style="width:250px;height:250px">
                                </div>
                            </div>


                            <div class="col-md-6" style="margin-top:10px">
                                <input type="submit" class="btn btn-primary"
                                    value="<?php echo direction("Submit","أرسل") ?>">
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
                        <h6 class="panel-title txt-dark"><?php echo direction("News List","قائمة الأخبار") ?></h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <button class="btn btn-primary">
                            <?php echo direction("Submit rank","أرسل الترتيب") ?>
                        </button>
                        <div class="table-wrap mt-40">
                            <div class="table-responsive">
                                <table class="table display responsive product-overview mb-30" id="myTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><?php echo direction("English Title","العنوان بالإنجليزي") ?></th>
                                            <th><?php echo direction("Arabic Title","العنوان بالعربي") ?></th>
                                            <th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php 
		if( $newsList = selectDB("news","`status` = '0' ORDER BY `rank` ASC") ){
			for( $i = 0; $i < sizeof($newsList); $i++ ){
				$counter = $i + 1;
			if ( $newsList[$i]["hidden"] == 2 ){
				$icon = "fa fa-eye";
				$link = "?v={$_GET["v"]}&show={$newsList[$i]["id"]}";
				$hide = direction("Show","إظهار");
			}else{
				$icon = "fa fa-eye-slash";
				$link = "?v={$_GET["v"]}&hide={$newsList[$i]["id"]}";
				$hide = direction("Hide","إخفاء");
			}
			?>
                                        <tr>
                                            <td>
                                                <input name="rank[]" class="form-control" type="number"
                                                    value="<?php echo $counter ?>">
                                                <input name="id[]" class="form-control" type="hidden"
                                                    value="<?php echo $newsList[$i]["id"] ?>">
                                            </td>
                                            <td id="enTitle<?php echo $newsList[$i]["id"]?>">
                                                <?php echo $newsList[$i]["enTitle"] ?></td>
                                            <td id="arTitle<?php echo $newsList[$i]["id"]?>">
                                                <?php echo $newsList[$i]["arTitle"] ?></td>
                                            <td class="text-nowrap">

                                                <a id="<?php echo $newsList[$i]["id"] ?>" class="mr-25 edit"
                                                    data-toggle="tooltip"
                                                    data-original-title="<?php echo direction("Edit","تعديل") ?>"> <i
                                                        class="fa fa-pencil text-inverse m-r-10"></i>
                                                </a>
                                                <a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip"
                                                    data-original-title="<?php echo $hide ?>"> <i
                                                        class="<?php echo $icon ?> text-inverse m-r-10"></i>
                                                </a>
                                                <a href="<?php echo "?v={$_GET["v"]}&delId={$newsList[$i]["id"]}" ?>"
                                                    data-toggle="tooltip"
                                                    data-original-title="<?php echo direction("Delete","حذف") ?>"><i
                                                        class="fa fa-close text-danger"></i>
                                                </a>
                                                <div style="display:none">
                                                    <label
                                                        id="hidden<?php echo $newsList[$i]["id"]?>"><?php echo $newsList[$i]["hidden"] ?></label>
                                                    <label
                                                        id="logo<?php echo $newsList[$i]["id"]?>"><?php echo $newsList[$i]["imageurl"] ?></label>
                                                    <label
                                                        id="enLogo<?php echo $newsList[$i]["id"]?>"><?php echo $newsList[$i]["enImageurl"] ?></label>
                                                    <label
                                                        id="enDetails<?php echo $newsList[$i]["id"]?>"><?php echo $newsList[$i]["enDetails"] ?></label>
                                                    <label
                                                        id="arDetails<?php echo $newsList[$i]["id"]?>"><?php echo $newsList[$i]["arDetails"] ?></label>
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
$(document).on("click", ".edit", function() {
    var id = $(this).attr("id");
    $("input[name=update]").val(id);

    $("input[type=file]").prop("required", false);
    $("input[name=enTitle]").val($("#enTitle" + id).html()).focus();
    $("input[name=arTitle]").val($("#arTitle" + id).html());
    tinymce.get('enDetails').setContent($("#enDetails" + id).html());
    tinymce.get('arDetails').setContent($("#arDetails" + id).html());
    $("select[name=hidden]").val($("#hidden" + id).html());
    $("#logoImg").attr("src", "../logos/" + $("#logo" + id).html());
    $("#logoEnImg").attr("src", "../logos/" + $("#enLogo" + id).html());
    $("#images").attr("style", "margin-top:10px;display:block");
})
</script>