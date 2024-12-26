<?php
if( isset($_POST["password"]) && !empty($_POST["password"]) ){
	if( $user = selectDBNew("users",[$userDetails["id"],sha1($_POST["password"])],"`id` = ? AND `password` = ?","") ){
		if( isset($_POST["new-password"]) && !empty($_POST["new-password"]) && isset($_POST["confirm-new-password"]) && !empty($_POST["confirm-new-password"]) ){
			if( $_POST["new-password"] == $_POST["confirm-new-password"] ){
				if( $user = selectDBNew("users",[$userDetails["id"],sha1($_POST["new-password"])],"`id` = ? AND `password` = ?","") ){
					?>
					<script>
						alert("<?php echo direction("This password is already in use","هذه كلمة المرور مستخدمة بالفعل"); ?>");
						window.location = "index.php?v=Profile";
					</script>
					<?php
				}else{
					if( updateDB("users",array("password"=>sha1($_POST["new-password"])), "`id` = '{$userDetails["id"]}'") ){
						?>
						<script>
							alert("<?php echo direction("Your password has been updated successfully","تم تغيير كلمة المرور بنجاح"); ?>");
							window.location = "index.php?v=Profile";
						</script>
						<?php
					}else{
						?>
						<script>
							alert("<?php echo direction("An error occurred while updating your password","حدث خطأ أثناء تحديث كلمة المرور الخاصة بك"); ?>");
							window.location = "index.php?v=Profile";
						</script>
						<?php
					}
				}
			}else{
			?>
			<script>
				alert("<?php echo direction("Passwords do not match","كلمات المرور لا تتطابق"); ?>");	
				window.location = "index.php?v=Profile";
			</script>
			<?php
			}
		}else{
			?>
			<script>
				alert("<?php echo direction("Please enter a new password","الرجاء إدخال كلمة مرور جديدة"); ?>");	
				window.location = "index.php?v=Profile";
			</script>
			<?php
		}
	}else{
		?>
		<script>
			alert("<?php echo direction("The password you entered is incorrect","كلمة المرور التي أدخلتها غير صحيحة"); ?>");	
			window.location = "index.php?v=Profile";
		</script>
		<?php
	}
}
var_dump($_POST);
if( isset($_POST["email"]) && !empty($_POST["email"]) ){
	if( $user = selectDBNew("users",[$_POST["email"]],"`email` = ?","") ){
		if( $user[0]["id"] != $userDetails["id"] ){
			?>
			<script>
				alert("<?php echo direction("This email is already in use","هذا البريد الإلكتروني مستخدم بالفعل"); ?>");
				window.location = "index.php?v=Profile";
			</script>
			<?php
		}
	}
	$_POT["logo"] = $userDetails["logo"];
	$data = array(
		"email" => $_POST["email"],
		"username" => $_POST["username"],
		"name" => $_POST["name"],
		"phone" => $_POST["phone"],
		"facebook" => $_POST["facebook"],
		"twitter" => $_POST["twitter"],
		"instagram" => $_POST["instagram"],
		"url" => $_POST["url"],
		"contactEmail" => $_POST["contactEmail"],
		"logo" => $_POST["logo"],
	);
	var_dump($data);
	if( updateDB("users",$data, "`id` = '{$userDetails["id"]}'") ){
		?>
		<script>
			alert("<?php echo direction("Your email has been updated successfully","تم تغيير بريدك الإلكتروني بنجاح"); ?>");
			window.location = "index.php?v=Profile";
		</script>
		<?php
	}else{
		?>
		<script>
			alert("<?php echo direction("An error occurred while updating your email","حدث خطأ أثناء تحديث بريدك الإلكتروني"); ?>");
			window.location = "index.php?v=Profile";
		</script>
		<?php
	}
}

if( isset($_GET["deleteAccount"]) && !empty($_GET["deleteAccount"]) ){
	if( updateDB('users',array('status'=> '1'),"`id` = '{$userDetails["id"]}'") ){
		?>
		<script>
			alert("<?php echo direction("Your account has been deleted successfully","تم حذف حسابك بنجاح"); ?>");
			window.location = "index.php?v=Home";
		</script>
		<?php
	}else{
		?>
		<script>
			alert("<?php echo direction("An error occurred while deleting your account","حدث خطأ أثناء حذف حسابك"); ?>");
			window.location = "index.php?v=Profile";
		</script>
		<?php
	}
}
?>
<div class="row"> 
	<div class="col-md-12"> 
		<div class="start-page-title with-white-bg text-center mb-4 py-3">
			<h4 class="mb-0"><?php echo Trans('app','Profile'); ?></h4>
		</div>
	</div>
	<div class="col-md-6"> 
		<div class="with-white-bg py-1 px-4">
			<form id="profile-form" class="mt-4" method="post" action="index.php?v=Profile">		
				<div class="mb-4 text-center">
				<img src="assets/img/profile.png" class="img-fluid" alt="...">
				</div>
				<!-- Price input -->
				<div class="form-outline mb-4">
				<input type="text" class="form-control" name="username" value="<?php echo $userDetails["username"]; ?>" placeholder="<?php echo Trans('app','Username'); ?>" />
				</div>
				<!-- Price input -->
				<div class="form-outline mb-4">
				<input type="text" class="form-control" name="phone" value="<?php echo $userDetails["phone"]; ?>" placeholder="<?php echo Trans('app','Phone Number'); ?>" />
				</div>
				<!-- Price input -->
				<div class="form-outline mb-4">
				<input type="text" class="form-control" name="email" value="<?php echo $userDetails["email"]; ?>" placeholder="<?php echo Trans('app','Email'); ?>" />
				</div>
				<div class="form-outline mb-4">
				<h5 class="fw-bold mb-3"><?php echo Trans('app','Update Profile Image'); ?></h5>
				<div class="change-profile-image">
					<span><?php echo Trans('app','Click or drag an account image'); ?></span>
					<span><i class="bi bi-image"></i></span>
				</div>
				</div>
				<div class="form-outline mb-4">
					<h5 class="fw-bold mb-3"><?php echo Trans('app','Social Media Accounts'); ?></h5>
					<div class="row align-items-center g-3">
					<div class="col-md-6"> 
						<div class="input-group mb-1">
							<span class="input-group-text"><i class="bi bi-facebook"></i></span>
							<input type="text" name="facebook" class="form-control" value="<?php echo $userDetails["facebook"]; ?>">
						</div>
					</div>
					<div class="col-md-6"> 
						<div class="input-group mb-1">
							<span class="input-group-text"><i class="bi bi-twitter-x"></i></span>
							<input type="text" name="twitter" class="form-control" value="<?php echo $userDetails["twitter"]; ?>">
						</div>
					</div>
					<div class="col-md-6"> 
						<div class="input-group mb-1">
							<span class="input-group-text"><i class="bi bi-instagram"></i></span>
							<input type="text" name="instagram" class="form-control" value="<?php echo $userDetails["instagram"]; ?>">
						</div>
					</div>
					<div class="col-md-6"> 
						<div class="input-group mb-1">
							<span class="input-group-text"><i class="bi bi-envelope"></i></span>
							<input type="text" name="email" class="form-control" value="<?php echo $userDetails["contactEmail"]; ?>">
						</div>
					</div>
					<div class="col-md-12"> 
						<div class="input-group mb-1">
							<span class="input-group-text"><i class="bi bi-link"></i></span>
							<input type="text" name="website" class="form-control" value="<?php echo $userDetails["url"]; ?>">
						</div>
					</div>
					</div>
				</div>
				<!-- Submit button -->
				<button type="submit" class="btn btn-primary btn-block w-100 mb-3 py-2"><?php echo Trans('app','Update Profile'); ?></button>
			</form>
		</div>
	</div>
	<div class="col-md-6"> 
		<div class="with-white-bg px-4 py-5 mt-4 mt-md-0">    
			<h4 class="mb-0"><?php echo Trans('app','Change Password'); ?></h4>		
			<form id="change-password-form" class="mt-4" method="post" action="index.php?v=Profile">>
				<!-- Price input -->
				<div class="form-outline mb-4">
				<input type="text" class="form-control" name="password" placeholder="<?php echo Trans('app','Current Password'); ?>" /> 
				</div>
				<!-- Price input -->
				<div class="form-outline mb-4">
				<input type="text" class="form-control" name="new-password" placeholder="<?php echo Trans('app','New Password'); ?>" />
				</div>
				<!-- Price input -->
				<div class="form-outline mb-4">
				<span class="form-hint form-hint-confirm-new-password d-block mt-0"><?php echo Trans('app','The password is at least four letters, symbols or Numbers'); ?></span>
				<input type="text" class="form-control" name="confirm-new-password" placeholder="<?php echo Trans('app','Confirm New Password'); ?>" />
				</div>
				<!-- Submit button -->
				<button type="submit" class="btn btn-primary btn-block w-100 mb-3 py-2"><?php echo direction("Change Password","تغيير كلمة المرور"); ?></button>
				<a href="?v=Profile&deleteAccount=1" onclick='return confirm("<?php echo direction("Are you sure you want to delete your account?","هل أنت متأكد أنك تريد حذف حسابك؟")?>")' class="btn btn-danger btn-block w-100 mt-3 py-2"> 
				<?php echo Trans('app','Delete Account'); ?>
				</a>
			</form>
		</div>
	</div>
</div>