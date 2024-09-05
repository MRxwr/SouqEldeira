<?php include 'config/config.php'; ?>

<?php
$verify = 0;
if (isset($_POST['forget']) && !empty($_POST['username'])) 
{
   if ($_POST['username'] == 'test')
   {
      $verify = 1;
   }
}
?>


<?php include 'layouts/start.php'; ?> 

        <?php include 'layouts/header.php'; ?> 
        
		<!-- Start page-content -->
		<div class="page-content my-5">
		
		<div class="container container-project">
		<div class="row"> 
		<?php include 'layouts/alert.php'; ?>
		<div class="col-md-11 mx-auto">
		<div class="guest-form-action">
    <div class="form-container">
	
		<div class="mb-4 text-center">
			<img src="assets/img/logo-1.png" class="img-fluid" alt="...">
		</div>

		
	     
		<form id="forget-password-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
			
		  <div class="mb-0 text-start form-title-as-label">
			<h5><?php echo Trans('app','Forgot password?'); ?></h5> 
		  </div>
		  
		  <!-- Email input -->
		  <div class="form-outline mb-4">
			<input type="text" class="form-control" name="username" placeholder="<?php echo Trans('app','Phone number or E-mail address'); ?>" />
		  </div>
  
		  <!-- Submit button -->
		  <button type="submit" name="forget" id="forgetPasswordBtn" class="btn btn-primary btn-block w-100 mb-4 py-2"><?php echo Trans('app','Send Activation Code'); ?></button>

		</form>
		
		
		
		<form id="forget-password-verify-form" method="post" style="display:none;">
		
		  <div class="mb-0 text-start form-title-as-label"> 
			<h5><?php echo Trans('app','Verification Code'); ?></h5>
		  </div>
		  <!-- Email input -->
		  <div class="form-outline mb-4">
			<input type="text" class="form-control" name="username" placeholder="<?php echo Trans('app','Phone number or E-mail address'); ?>" />
		  </div>
		  <!-- Email input -->
		  <div class="form-outline mb-4">
			<input type="text" class="form-control" name="password" placeholder="<?php echo Trans('app','password'); ?>" />
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
		
	</div>
</div>
</div>
</div>
</div>   
      
	    </div>
		<!-- End page-content -->
		
<?php include 'layouts/footer.php'; ?> 
<?php include 'layouts/end.php'; ?> 