<?php
$_notifUserId = isset($userDetails['id']) ? $userDetails['id'] : '';
if( $notifications = selectDB("notifications","`status` = '0' AND `listOfUsers` NOT LIKE '%{$_notifUserId}%'") ){
	$totalNotSeen = sizeof($notifications);
}else{
	$totalNotSeen = 0;
}
?>
<!-- Sidebar  -->
<nav id="sidebar">
	<div class="main-sidebar-container">
		<div class="sidebar-element1">
			<div class="element1-start">
				<div class="change-language">
				    <?php if( $_SESSION['lang'] ==='en') { ?>   
		        		<a class='language p-0' href='<?php echo urldecode("http://{$_SERVER["HTTP_HOST"]}{$_SERVER["REQUEST_URI"]}" . getSign() . "lang=ar"); ?>'><img src='/assets/img/lang/ar.png' class='img-fluid langimg' alt="<?php echo direction("Arabic","العربية"); ?>"><span>عربى</span></a> 
					<?php } ?>
					<?php if( $_SESSION['lang'] ==='ar') { ?> 	
						<a class='language p-0' href='<?php echo urldecode("http://{$_SERVER["HTTP_HOST"]}{$_SERVER["REQUEST_URI"]}" . getSign() . "lang=en"); ?>'><img src='/assets/img/lang/en.png' class='img-fluid langimg' alt="<?php echo direction("English","الإنجليزية"); ?>"><span>English</span></a>
		        	<?php } ?>  
			    </div>
			    <div id="dismiss" class="siderbar-dismiss text-end">
			       <i class="bi bi-x-lg"></i>
			    </div>
			</div>
		    <?php if($_SESSION['valid']){ ?>
		    <div class="sidebar-header">
		    	<div class="profile">
		    		
		    		<div class="avatar">
			    		<a href="/profile" class="d-block">
			    			<img src="/logos/<?php echo $userDetails['logo'] ?>" class="img-fluid" alt="<?php echo direction($userDetails['name'],$userDetails['name']); ?>" style="border-radius: 100%;height: 58px;width: 100%;">
			    		</a>
		    		</div>
		    		<div class="details">
		    			<h3 class="fullname"><?php echo $userDetails['name'] ?></h3>
		    			<a href="/profile"><?php echo direction("My Profile","ملفي الشخصي"); ?></a>
		    		</div>
		    	</div>
		    	<div class="">
		    		<a href="/notifications" class="notifications">
						<i class="bi bi-bell"></i> 
		    		 <?php
					 /*
					 <span class="badge badge-light"><?php echo $totalNotSeen; ?></span>				  
					*/
					?>
					</a> 
		    	</div>
		    </div>
		    <?php } else { ?> 
			<div class="sidebar-header">
		    	<div class="">
		    		<a href="/home">
		    			<img src="/assets/img/logo-1.png" alt="<?php echo direction("Souq Al Deirah","سوق الديرة"); ?>">
		    		</a>
		    	</div>
		    	<div class="">
		    		<a href="#" class="notifications">
		    		 <i class="bi bi-bell"></i> 
					 <span class="badge badge-light">0</span>				  
					</a> 
		    	</div>
		    </div>
		    <?php } ?>
		    <div class="sidebar-add-ad my-3">
				<a href="/add-ad" class="btn btn-primary btn-border-radius-1 w-100">
					<i class="bi bi-plus-lg"></i> <?php echo direction("Add Ad","إضافة إعلان"); ?>
				</a>
		    </div>
		    <ul class="sidebar-menu list-unstyled mt-2">
		        <li class="active">
		            <a href="/home"><i class="bi bi-house"></i><?php echo direction("Home","الرئيسية"); ?></a>
		        </li>
		        <?php if(!$_SESSION['valid']){ ?>
		        <li>
		            <a href="/login"><i class="bi bi-box-arrow-right"></i><?php echo direction("Login","تسجيل الدخول"); ?></a>
		        </li>
		        <?php } ?>
		        <?php if($_SESSION['valid']){
					if( isset($userDetails["id"]) && !empty($userDetails["id"]) ){
						if( $myAds = selectDB("products","`userId` = '{$userDetails["id"]}' AND `status` = '0' AND `hidden` != '2'") ){
							$myAds = sizeof($myAds);
						}else{
							$myAds = 0;
						}
					}else{
						$myAds = 0;
					}
					?>
		        <li>
		            <a href="/my-ads"><i class="bi bi-grid"></i><?php echo direction("My Ads","إعلاناتي"); ?> <span class="badge"><?php echo $myAds; ?></span></a>
		        </li>
		        <?php } ?>
		        <li>
            		<a class="have-sub-menu" data-bs-toggle="collapse" data-bs-target="#realState-collapse"aria-expanded="false"><i class="bi bi-houses"></i><?php echo direction("Real Estate","العقارات"); ?></a>
		            <div class="collapse" id="realState-collapse">
		              <ul class="sub-menu-ul">
						<?php
						if( $categories = selectDB("categories","`status` = '0' AND `hidden` = '1' ORDER BY `rank` ASC") ){
							for( $x = 0; $x < sizeof($categories); $x++ ){
								$title = direction($categories[$x]['enTitle'],$categories[$x]['arTitle']);
								echo "<li><a class='rounded' href='/search/type={$categories[$x]['id']}'>{$title}</a></li>";
							}
						}
						?>
		              </ul>
		            </div>
          		</li>
		        <li>
		            <a href="/offices"><i class="bi bi-buildings"></i><?php echo direction("Real Estate Offices","مكاتب العقارات"); ?></a>
		        </li>
		        <li>
		            <a href="/faq"><i class="bi bi-question-circle"></i><?php echo direction("FAQ","الأسئلة الشائعة"); ?></a>
		        </li>
		        <li>
		            <a href="/terms"><i class="bi bi-file-earmark-text"></i><?php echo direction("Terms & Conditions","الشروط والأحكام"); ?></a>
		        </li>
		        <li>
		            <a href="/policy"><i class="bi bi-shield-lock"></i><?php echo direction("Privacy Policy","سياسة الخصوصية"); ?></a>
		        </li>
		        <li>
		            <a href="/about"><i class="bi bi-info-circle"></i><?php echo direction("About Us","من نحن"); ?></a>
		        </li>
		        <li>
		            <a href="/contact"><i class="bi bi-envelope-arrow-up"></i><?php echo direction("Contact Us","اتصل بنا"); ?></a>
		        </li>
		        <?php if($_SESSION['valid']){ ?>
		        <li>
		            <a class="logout" href="/logout"><i class="bi bi-box-arrow-right"></i><?php echo direction("Logout","تسجيل الخروج"); ?></a>
		        </li>
		        <?php } ?>
		    </ul>
		</div>

		<div class="sidebar-element2">
			<div class="sidebar-contact-whatsapp mb-3">
				<a href="https://wa.me/96522281412" class="btn btn-default btn-border-radius-1 w-100 py-2">
					<i class="bi bi-whatsapp"></i> <?php echo direction("Contact us via WhatsApp","اتصل بنا عبر واتساب"); ?>
				</a>
		    </div>
			<ul class="socila-links list-unstyled mb-3">
				<?php
				if( $socials = selectDB("s_media","`id` = '1'") ){
					$arraySmedia = ["facebook","instagram","twitter","email","mobile"];
					$arrayIcons = ["facebook","instagram","twitter","envelope","telephone"];
					$arrayLinks = ["https://www.facebook.com/","https://www.instagram.com/","https://www.twitter.com/","mailto:","tel:"];
					for( $x = 0; $x < sizeof($arraySmedia); $x++ ){
						if( !empty($socials[0][$arraySmedia[$x]]) ){
							echo '<li><a href="' . $arrayLinks[$x] . $socials[0][$arraySmedia[$x]] . '"><i class="bi bi-' . $arrayIcons[$x] . '"></i></a></li>';
						}
					}
				}
				?>
		    </ul>
		</div>
	</div>
</nav>