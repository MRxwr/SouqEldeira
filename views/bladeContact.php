<?php
if( isset($_POST) && !empty($_POST) ){
	if( empty($_POST["name"]) || empty($_POST["phone"]) || empty($_POST["email"]) || empty($_POST["message"]) ){
		?>
		<script>
			alert("<?php echo direction("Please fill all the fields","الرجاء ملء جميع الحقول"); ?>");
			window.location = "index.php?v=Contact";
		</script>
		<?php
	}else{
		$msg = "
		Name: {$_POST["name"]}<br>
		Phone: {$_POST["phone"]}<br>
		Email: {$_POST["email"]}<br>
		Message: {$_POST["message"]}
		";
		$data = array(
			"email" => $_POST["email"],
			"msg" => $msg
		);
		contactUsMail($data);
		?>
		<script>
			alert("<?php echo direction("Your message has been sent successfully","تم إرسال رسالتك بنجاح"); ?>");
			window.location = "index.php?v=Contact";
		</script>
		<?php
	}
}
?>
<div class="row"> 
	<div class="main-contact with-white-bg p-4 pt-4 d-flex align-items-center">
		<div class="col-lg-6 col-md-12">  
			<h4 class="mb-3"><?php echo direction("Contact Us","اتصل بنا"); ?></h4>
			<form class="contact-us-form" method="post" action="">
				<div class="row row-fields d-flex align-items-stretch g-3">
					<div class="col-md-6">
						<div class="form-outline mb-4">
						<input type="text" class="form-control" name="name" placeholder="<?php echo direction("Name","الاسم"); ?>" />
						</div>
						<div class="form-outline mb-4">
						<input type="text" class="form-control" name="phone" placeholder="<?php echo direction("Phone Number","رقم الهاتف"); ?>" />
						</div>
						<div class="form-outline mb-4">
						<input type="text" class="form-control" name="email" placeholder="<?php echo direction("Email","البريد الإلكتروني"); ?>" />
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-outline h-100 pb-4"> 
							<textarea class="form-control h-100" name="message"  rows="3" placeholder="<?php echo direction("Message","الرسالة"); ?>"></textarea>
						</div>
					</div>
				</div>
				<div class="row">	
					<div class="col-md-12">
						<button type="submit" class="btn btn-primary btn-block w-100 mb-3 py-2"><i class="bi bi-send"></i> <?php echo direction("Send","إرسال"); ?></button>
					</div>
				</div>
			</form>
			<div class="contact-details">
				<div class="row align-items-center g-1 mt-2"> 
					<div class="col-md-12">
						<h3><?php echo direction("Contact details","تفاصيل الاتصال"); ?></h3>
						<h5 class="mb-3"><?php echo direction("To communicate and inquire with customer service","للتواصل والاستفسار مع خدمة العملاء"); ?></h5>
						<div class="data">
							<a href="tel:22281412"><i class="bi bi-telephone-fill"></i>22281412</a> 
							<a href="tel:22281412"><i class="bi bi-newspaper"></i>22281412</a>
							<a href="mailto:info@souqeldeira.com"><i class="bi bi-envelope"></i>info@souqeldeira.com</a>
						</div> 
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-12 text-center"> 
			<img src="assets/img/logo-big.png" class="img-fluid p-5 img-fluid-logo" alt="...">		  		
		</div> 
	</div>
</div>