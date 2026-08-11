<?php 
if ( isset($_GET["update"]) AND $_GET["update"] = 1 && updateDB("s_media",$_POST,"`id` = '1'") ){
	$sMedia = selectDB("s_media","`id` = '1'");
	header("LOCATION: ?v={$_GET["v"]}");die();
}else{
	$sMedia = selectDB("s_media","`id` = '1'");
}
$mobile = $sMedia[0]["mobile"];
$facebook = $sMedia[0]["facebook"];
$instagram = $sMedia[0]["instagram"];
$location = $sMedia[0]["location"];
$twitter = $sMedia[0]["twitter"];
$email = $sMedia[0]["email"];
$tiktok = $sMedia[0]["tiktok"];
$youtube = $sMedia[0]["youtube"];

?>
<div class="row">
<div class="col-md-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
<div class="row">
<div class="col-sm-12 col-xs-12">
<div class="form-wrap">
<form action="?v=<?php echo $_GET["v"] ?>&update=1" method="POST">
<div class="form-body">
<h6 class="txt-dark capitalize-font">
<i class="zmdi zmdi-account mr-10"></i><?php echo direction("Social Media","وسائل التواصل الاجتماعي") ?>
</h6>
<hr class="light-grey-hr"/>
<div class="row">
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo direction("Mobile","الهاتف") ?></label>
<input type="number" step="any" min="0" name="mobile" class="form-control" value="<?php echo $mobile ?>"  >
</div>
</div>
<!--/span-->
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo direction("Facebook","فيسبوك") ?></label>
<input type="text" name="facebook" class="form-control" value="<?php echo $facebook ?>"  >
</div>
</div>
<!--/span-->
</div>
<!-- -->
<div class="row">
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo direction("Instagram","انستقرام") ?></label><br>
<input type="text" name="instagram" class="form-control" value="<?php echo $instagram ?>"  >
</div>
</div>

<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo direction("Twitter","تويتر") ?></label><br>
<input type="text" name="twitter" class="form-control" value="<?php echo $twitter ?>"  >
</div>
</div>

<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo direction("TikTok","تيك توك") ?></label><br>
<input type="text" name="tiktok" class="form-control" value="<?php echo $tiktok ?>"  >
</div>
</div>

<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo direction("Email","البريد الإلكتروني") ?></label><br>
<input type="text" name="email" class="form-control" value="<?php echo $email ?>"  >
</div>
</div>

<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo direction("Location","الموقع") ?></label><br>
<input type="text" name="location" class="form-control" value="<?php echo $location ?>"  >
</div>
</div>

<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo direction("Youtube","يوتيوب") ?></label><br>
<input type="text" name="youtube" class="form-control" value="<?php echo $youtube ?>"  >
</div>
</div>

<!--/span-->
</div>
<!-- -->
<!-- /Row -->
</div>
<div class="form-actions mt-10">
<button type="submit" class="btn btn-success  mr-10"><?php echo direction("Submit","حفظ") ?></button>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>		
</div>
</div>