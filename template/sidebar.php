<!-- Sidebar  -->
<nav id="sidebar">
	<div class="main-sidebar-container">
		<div class="sidebar-element1">
			<div class="element1-start">
				<div class="change-language">
				    <?php if( $_SESSION['lang'] ==='en') { ?>   
		        		<a class='language p-0' href='<?php echo "http://{$_SERVER["HTTP_HOST"]}{$_SERVER["REQUEST_URI"]}" . getSign() . "lang=ar" ?>'><img src='assets/img/lang/ar.png' class='img-fluid langimg'><span>عربى</span></a> 
					<?php } ?>
					<?php if( $_SESSION['lang'] ==='ar') { ?> 	
						<a class='language p-0' href='<?php echo "http://{$_SERVER["HTTP_HOST"]}{$_SERVER["REQUEST_URI"]}" . getSign() . "lang=en" ?>'><img src='assets/img/lang/en.png' class='img-fluid langimg'><span>English</span></a>
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
			    		<a href="?v=Profile" class="d-block">
			    			<img src="<?php echo "logos/{$userDetails['logo']}" ?>" class="img-fluid" alt="..." style="border-radius: 100%;height: 58px;width: 100%;">
			    		</a>
		    		</div>
		    		<div class="details">
		    			<h3 class="fullname"><?php echo $userDetails['name'] ?></h3>
		    			<a href="?v=Profile"><?php echo Trans('app','My Profile'); ?></a>
		    		</div>
		    	</div>
		    	<div class="">
		    		<a href="?v=Notifications" class="notifications">
		    		 <i class="bi bi-bell"></i> 
					 <span class="badge badge-light">9</span>				  
					</a> 
		    	</div>
		    </div>
		    <?php } else { ?> 
			<div class="sidebar-header">
		    	<div class="">
		    		<a href="?v=Home">
		    			<img src="assets/img/logo-1.png">
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
				<a href="?v=AddAd" class="btn btn-primary btn-border-radius-1 w-100">
					<i class="bi bi-plus-lg"></i> <?php echo Trans('app','Add Ad'); ?>
				</a>
		    </div>
		    <ul class="sidebar-menu list-unstyled mt-2">
		        <li class="active">
		            <a href="?v=Home"><i class="bi bi-house"></i><?php echo Trans('app','Home'); ?></a>
		        </li>
		        <?php if(!$_SESSION['valid']){ ?>
		        <li>
		            <a href="?v=Login"><i class="bi bi-box-arrow-right"></i><?php echo Trans('app','Login'); ?></a>
		        </li>
		        <?php } ?>
		        <?php if($_SESSION['valid']){
					if( isset($userDetails["id"]) && !empty($userDetails["id"]) ){
						if( $myAds = selectDB("products","`userId` = '{$_SESSION['userId']}' AND `status` = '0' AND `hidden` != '2'") ){
							$myAds = sizeof($myAds);
						}else{
							$myAds = 0;
						}
					}else{
						$myAds = 0;
					}
					?>
		        <li>
		            <a href="?v=MyAds"><i class="bi bi-grid"></i><?php echo Trans('app','My Ads'); ?> <span class="badge"><?php echo $myAds; ?></span></a>
		        </li>
		        <?php } ?>
		        <li>
            		<a class="have-sub-menu" data-bs-toggle="collapse" data-bs-target="#realState-collapse"aria-expanded="false"><i class="bi bi-houses"></i><?php echo Trans('app','Real Estate'); ?></a>
		            <div class="collapse" id="realState-collapse">
		              <ul class="sub-menu-ul">
						<?php
						if( $categories = selectDB("categories","`status` = '0' AND `hidden` = '1' ORDER BY `rank` ASC") ){
							for( $x = 0; $x < sizeof($categories); $x++ ){
								$title = direction($categories[$x]['enTitle'],$categories[$x]['arTitle']);
								echo "<li><a class='rounded' href='?v=Search&type={$categories[$x]['id']}'>{$title}</a></li>";
							}
						}
						?>
		              </ul>
		            </div>
          		</li>
		        <li>
		            <a href="?v=Offices"><i class="bi bi-buildings"></i><?php echo Trans('app','Real Estate Offices'); ?></a>
		        </li>
		        <li>
		            <a href="?v=FAQ"><i class="bi bi-question-circle"></i><?php echo Trans('app','FAQ'); ?></a>
		        </li>
		        <li>
		            <a href="?v=Terms"><i class="bi bi-file-earmark-text"></i><?php echo Trans('app','Terms & Conditions'); ?></a>
		        </li>
		        <li>
		            <a href="?v=Contact"><i class="bi bi-envelope-arrow-up"></i><?php echo Trans('app','Contact Us'); ?></a>
		        </li>
		        <?php if($_SESSION['valid']){ ?>
		        <li>
		            <a class="logout" href="?v=Logout"><i class="bi bi-box-arrow-right"></i><?php echo Trans('app','Logout'); ?></a>
		        </li>
		        <?php } ?>
		    </ul>
		</div>

		<div class="sidebar-element2">
			<div class="sidebar-contact-whatsapp mb-3">
				<a href="" class="btn btn-default btn-border-radius-1 w-100 py-2">
					<i class="bi bi-whatsapp"></i> <?php echo Trans('app','Contact us via WhatsApp'); ?>
				</a>
		    </div>
			<ul class="socila-links list-unstyled mb-3">
		        <li>
		            <a href=""><i class="bi bi-envelope"></i></a>
		        </li>
		        <li>
		            <a href=""><i class="bi bi-instagram"></i></a>
		        </li>
		        <li>
		            <a href=""><i class="bi bi-twitter-x"></i></a>
		        </li>
		        <li>
		            <a href=""><i class="bi bi-facebook"></i></a>
		        </li>
		        <li>
		            <a href=""><i class="bi bi-telephone"></i></a>
		        </li>
		    </ul>
		</div>
	</div>
</nav>