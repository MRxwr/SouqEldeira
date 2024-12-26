<?php
if ( isset($_POST["username"]) && !empty($_POST["username"]) && isset($_POST["password"]) && !empty($_POST["password"]) ){
	$_SESSION["timeout"] = time() + (86400*30);
	if( $users = selectDBNew("users",[$_POST["username"],sha1($_POST["password"])],"`username` LIKE ? AND `password` LIKE ?","") ){
		if( $users[0]["status"] != 0 ){
			$msg = direction("Your account is blocked", "تم حظر حسابك");
		}
		if( $users[0]["hidden"] != 0 ){
			$msg = direction("Your account is locked", "تم قفل حسابك");
		}
		if( count($users) > 1 ){
			$msg = direction("Wrong username or password", "اسم المستخدم او كلمة المرور غير صحيحة");
		}else{
			$GenerateNewCC = md5(rand());
			var_dump($GenerateNewCC);
			if( updateDB("users",array("keepMeAlive"=>$GenerateNewCC),"`id` = '{$users[0]["id"]}'") ){
				var_dump($GenerateNewCC);
				$_SESSION[$cookieSession] = $email;
				header("Location: index.php?v=Home");
				setcookie($cookieSession, $GenerateNewCC, time() + (86400*30 ), "/");die();
			}else{
				$msg = direction("Browser not supported", "المتصفح غير مدعوم");
			}
		}
	}else{ 
		$msg = direction("Wrong username or password", "اسم المستخدم او كلمة المرور غير صحيحة");
	}
}
?>
		<div class="row"> 
		<div class="col-md-11 mx-auto">
		<div class="guest-form-action">
		

		
		
        <!-- Pills navs -->
		<ul class="nav nav-login-register nav-pills nav-justified" id="nav-tab" role="tablist">
		  <li class="nav-item" role="presentation">
		    <a class="nav-link active" id="tab-login" data-bs-toggle="pill" href="#pills-login" role="tab"
		      aria-controls="pills-login" aria-selected="true"><?php echo Trans('app','Login'); ?></a>
		  </li>
		  <li class="nav-item" role="presentation">
		    <a class="nav-link" id="tab-register" data-bs-toggle="pill" href="#pills-register" role="tab"
		      aria-controls="pills-register" aria-selected="false"><?php echo Trans('app','Register'); ?></a>
		  </li>
		</ul>
		<!-- Pills navs -->

		<!-- Pills content -->
		<div class="tab-content tab-form-content mt-5" id="nav-tabContent">
		
		  <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
		    <div class="form-container">
		    	
		    <form id="login-form" method="post" action="?v=Login" >
		
		      <div class="mb-4 text-center">
				<img src="assets/img/logo-1.png" class="img-fluid" alt="...">
			  </div>
			  
			  
			  <?php if(!empty($msg)) { ?>  
			  	<div class="alert alert-danger d-flex align-items-center py-1" role="alert">
				 <i class="bi bi-x" style="font-size:30px;"></i> <?php echo $msg; ?> 
				</div> 
			  <?php } ?> 
			  
			  
		      <!-- Email input -->
		      <div class="form-outline mb-4">
		        <input type="text" class="form-control" name="username" placeholder="<?php echo direction("Username","اسم المستخدم"); ?>" />
		      </div>
		
		      <!-- Password input -->
		      <div class="form-outline mb-3">
		        <input type="password" class="form-control"  name="password" placeholder="<?php echo Trans('app','Password'); ?>" />
		      </div>
		
		       
		      <div class="row mb-4">
		      	
		        <div class="col-md-12 d-flex justify-content-start">
		          <div class="form-check mb-2">
		            <input class="form-check-input" type="checkbox" value="" checked />
		            <label class="form-check-label" for="loginCheck"> <?php echo Trans('app','Remember me'); ?> </label>
		          </div>
		        </div> 
		
		        <div class="col-md-12 d-flex justify-content-start"> 
		          <a href="forget-password.php"><?php echo Trans('app','Click here if you forgot your password?'); ?></a>
		        </div>
		        
		      </div>
		 
		      <!-- Submit button -->
		      <button type="submit" name="login" class="btn btn-primary btn-block w-100 mb-4 py-2"><?php echo Trans('app','Sign in'); ?></button>
		
		      <!-- Register buttons -->
		      <div class="d-none text-center">
		        <p>Not a member? <a href="#!">Register</a></p>
		      </div>
			  
		    </form>
			</div>
		  </div>
		  
		  <div class="tab-pane fade" id="pills-register" role="tabpanel" aria-labelledby="tab-register">
		    <div class="form-container">
		    <form id="register-form">
		      
		      <div class="mb-4 text-center">
				<img src="assets/img/logo-1.png" class="img-fluid" alt="...">
			  </div>
		
		      <!-- Name input -->
		      <div class="form-outline mb-4">
		        <input type="text" class="form-control" name="name" placeholder="<?php echo Trans('app','Name'); ?>" />
		      </div>
		
		      <!-- Username input -->
		      <div class="form-outline mb-4">
		        <input type="text" class="form-control" name="username" placeholder="<?php echo Trans('app','Username'); ?>" />
		      </div>
		
		      <!-- Email input -->
		      <div class="form-outline mb-4">
		        <input type="email" class="form-control" name="email" placeholder="<?php echo Trans('app','Email'); ?>" />
		      </div>
		
		      <!-- Password input -->
		      <div class="form-outline mb-4">
		        <input type="password" class="form-control" name="password" placeholder="<?php echo Trans('app','Password'); ?>" />
		      </div>
		
		      <!-- Repeat Password input -->
		      <div class="form-outline mb-4">
		        <input type="password" class="form-control" name="repeat-password" placeholder="<?php echo Trans('app','Repeat Password'); ?>" />
		      </div>
		      
		      
		      
		      <!-- Checkbox -->
		      <div class="col-md-12 d-flex justify-content-start mb-4">
		        <input class="form-check-input me-2" type="checkbox" value="" id="registerCheck" checked
		          aria-describedby="registerCheckHelpText" />
		        <label class="form-check-label label-terms" for="registerCheck">
		          <?php echo Trans('app','I agree to the'); ?><a href="terms.php">&nbsp;<?php echo Trans('app','terms & conditions'); ?></a>
		        </label>
		      </div>
		
		      <!-- Submit button -->
		      <button type="submit" class="btn btn-primary btn-block w-100 mb-3 py-2"><?php echo Trans('app','Sign in'); ?></button>
		    </form>
			</div>
			
		  </div>
		</div>
		<!-- Pills content -->
		
</div>
</div>
</div>