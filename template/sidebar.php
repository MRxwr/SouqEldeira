<!-- Sidebar  -->
<nav id="sidebar">
	
	
	<div class="main-sidebar-container">
		
		<div class="sidebar-element1">
			
			<div class="element1-start">
		 
				<div class="change-language">
				    <?php if( $_SESSION['lang'] ==='en') { ?>   
		        		<a class='language p-0' href='?lang=ar'><img src='assets/img/lang/ar.png' class='img-fluid langimg'><span>عربى</span></a> 
					<?php } ?>
					<?php if( $_SESSION['lang'] ==='ar') { ?> 	
						<a class='language p-0' href='?lang=en'><img src='assets/img/lang/en.png' class='img-fluid langimg'><span>English</span></a>
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
			    		<a href="index.php" class="d-block">
			    			<img src="assets/img/profile.png" class="img-fluid" alt="...">
			    		</a>
		    		</div>
		    		
		    		<div class="details">
		    			<h3 class="fullname"><?php echo $_SESSION['firstname']." ".$_SESSION['lastname'] ?></h3>
		    			<a href="profile.php"><?php echo Trans('app','My Profile'); ?></a>
		    		</div>
		    		
		    	</div>
		    	<div class="">
		    		<a href="notifications.php" class="notifications">
		    		 <i class="bi bi-bell"></i> 
					 <span class="badge badge-light">9</span>				  
					</a> 
		    	</div>
		    </div>
		    <?php } else { ?> 
			<div class="sidebar-header">
		    	<div class="">
		    		<a href="index.php">
		    			<img src="assets/img/logo-1.png">
		    		</a>
		    	</div>
		    	<div class="">
		    		<a href="notifications.php" class="notifications">
		    		 <i class="bi bi-bell"></i> 
					 <span class="badge badge-light">9</span>				  
					</a> 
		    	</div>
		    </div>
		    <?php } ?>
		    
		    
		    <div class="sidebar-add-ad my-3">
				<a href="add-ad.php" class="btn btn-primary btn-border-radius-1 w-100">
					<i class="bi bi-plus-lg"></i> <?php echo Trans('app','Add Ad'); ?>
				</a>
		    </div>
		    
		    <ul class="sidebar-menu list-unstyled mt-2">
		        <li class="active">
		            <a href="index.php"><i class="bi bi-house"></i><?php echo Trans('app','Home'); ?></a>
		        </li>
		        <?php if(!$_SESSION['valid']){ ?>
		        <li>
		            <a href="login.php"><i class="bi bi-box-arrow-right"></i><?php echo Trans('app','Login'); ?></a>
		        </li>
		        <?php } ?>
		        <?php if($_SESSION['valid']){ ?>
		        <li>
		            <a href="my-ads.php"><i class="bi bi-grid"></i><?php echo Trans('app','My Ads'); ?> <span class="badge">2</span></a>
		        </li>
		        <?php } ?>
		        <li>
            		<a class="have-sub-menu" data-bs-toggle="collapse" data-bs-target="#realState-collapse"aria-expanded="false"><i class="bi bi-houses"></i><?php echo Trans('app','Real Estate'); ?></a>
		            <div class="collapse" id="realState-collapse">
		              <ul class="sub-menu-ul">
		                <li><a href="ads-list.php" class="rounded"><?php echo Trans('app','Sale'); ?></a></li>
		                <li><a href="ads-list.php" class="rounded"><?php echo Trans('app','Allowance'); ?></a></li>
		                <li><a href="ads-list.php" class="rounded"><?php echo Trans('app','Rent'); ?></a></li>
		                <li><a href="ads-list.php" class="rounded"><?php echo Trans('app','Request'); ?></a></li>
		              </ul>
		            </div>
          		</li>
		        <li>
		            <a href="offices.php"><i class="bi bi-buildings"></i><?php echo Trans('app','Real Estate Offices'); ?></a>
		        </li>
		        <li>
		            <a href="faq.php"><i class="bi bi-question-circle"></i><?php echo Trans('app','FAQ'); ?></a>
		        </li>
		        <li>
		            <a href="terms.php"><i class="bi bi-file-earmark-text"></i><?php echo Trans('app','Terms & Conditions'); ?></a>
		        </li>
		        <li>
		            <a href="contact.php"><i class="bi bi-envelope-arrow-up"></i><?php echo Trans('app','Contact Us'); ?></a>
		        </li>
		        <?php if($_SESSION['valid']){ ?>
		        <li>
		            <a class="logout" href="logout.php"><i class="bi bi-box-arrow-right"></i><?php echo Trans('app','Logout'); ?></a>
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