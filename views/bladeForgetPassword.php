<?php
$verify = 0;
if (isset($_POST['forget']) && !empty($_POST['email'])){
	if( $user = selectDBNew("users",[$_POST["email"]],"`email` = ?","") ){
		$randomPass = rand(100000,999999);
		$GenerateNewCC = sha1($randomPass);
		if( updateDB("users",array("password"=>$GenerateNewCC),"`id` = '{$user[0]["id"]}'") ){
			$verify = 1;
			$data = array(
				"email"	=>	$user[0]["email"],
				"password"	=>	$randomPass
			);
			forgetPass($data);
		}
	}
}
?>
<div class="row"> 
<div class="col-md-11 mx-auto">
<div class="guest-form-action">
    <div class="form-container">
		<div class="mb-4 text-center">
			<img src="assets/img/logo-1.png" class="img-fluid" alt="...">
		</div>
	    <?php if($verify === 0) { ?>  
		<form id="forget-password-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
		  <div class="mb-0 text-start form-title-as-label">
			<h5><?php echo Trans('app','Forgot password?'); ?></h5> 
		  </div>
		  <!-- Email input -->
		  <div class="form-outline mb-4">
			<input type="text" class="form-control" name="email" placeholder="<?php echo direction("E-mail Address","البريد الالكتروني"); ?>" />
		  </div>
		  <!-- Submit button -->
		  <button type="submit" name="forget" class="btn btn-primary btn-block w-100 mb-4 py-2"><?php echo Trans('app','Send Activation Code'); ?></button>
		</form>
		<?php } ?>
		<?php if($verify === 1) { ?>
		<form id="forget-password-verify-form" method="post">
		  <div class="mb-0 text-start form-title-as-label"> 
			<h5><?php echo Trans('app','Verification Code'); ?></h5>
		  </div>
		  <!-- Email input -->
		  <div class="form-outline"> 
			<input type="text" class="form-control" name="code" placeholder="<?php echo Trans('app','Please Enter Verification Code'); ?>" />
		  </div>
		  <div class="form-outline my-3 verify-code-time">   
		  	<span id="timerOTP"></span>
		  	<a href="#!"><?php echo Trans('app','Re-send'); ?></a>
		  </div> 
		  <!-- Submit button -->
		  <button type="submit" name="verify" class="btn btn-primary btn-block w-100 mb-4 py-2"><?php echo Trans('app','Verification'); ?></button> 
		</form>
		<?php } ?>
	</div>
</div>
</div>
</div>