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

		    <div class="sidebar-header" id="sidebarHeader"></div>

		    
		    
		    <div class="sidebar-add-ad my-3">
				<a href="add-ad" class="btn btn-primary btn-border-radius-1 w-100">
					<i class="bi bi-plus-lg"></i> <?php echo Trans('app','Add Ad'); ?>
				</a>
		    </div>
		    
		    <ul class="sidebar-menu list-unstyled mt-2" id="sidebarMenu">
		        <li class="active">
		            <a href="/"><i class="bi bi-house"></i><?php echo Trans('app','Home'); ?></a>
		        </li>

		        <li>
            		<a class="have-sub-menu" data-bs-toggle="collapse" data-bs-target="#realState-collapse"aria-expanded="false"><i class="bi bi-houses"></i><?php echo Trans('app','Real Estate'); ?></a>
		            <div class="collapse" id="realState-collapse">
		              <ul class="sub-menu-ul">
		                <li><a href="/search-view?SaleType=SALE" class="rounded"><?php echo Trans('app','Sale'); ?></a></li>
		                <li><a href="/search-view?SaleType=EXCHANGE" class="rounded"><?php echo Trans('app','Allowance'); ?></a></li>
		                <li><a href="/search-view?SaleType=RENT" class="rounded"><?php echo Trans('app','Rent'); ?></a></li>
		                <li><a href="/search-view?SaleType=REQUEST" class="rounded"><?php echo Trans('app','Request'); ?></a></li>
		              </ul>
		            </div>
          		</li>
		        <li>
		            <a href="/offices"><i class="bi bi-buildings"></i><?php echo Trans('app','Real Estate Offices'); ?></a>
		        </li>
		        <li>
		            <a href="/faq"><i class="bi bi-question-circle"></i><?php echo Trans('app','FAQ'); ?></a>
		        </li>
		        <li>
		            <a href="/terms"><i class="bi bi-file-earmark-text"></i><?php echo Trans('app','Terms & Conditions'); ?></a>
		        </li>
		        <li>
		            <a href="/contact"><i class="bi bi-envelope-arrow-up"></i><?php echo Trans('app','Contact Us'); ?></a>
		        </li>
		    </ul>
			
		</div>
		
		<div class="sidebar-element2">
			<div class="sidebar-contact-whatsapp mb-3">
				<a href="" id="whatsapp" class="btn btn-default btn-border-radius-1 w-100 py-2">
					<i class="bi bi-whatsapp"></i> <?php echo Trans('app','Contact us via WhatsApp'); ?>
				</a>
		    </div>
			<ul class="socila-links list-unstyled mb-3">
		        <li><a href="" id="uemail"><i class="bi bi-envelope"></i></a></li>
		        <li><a href="" id="uinstagram"><i class="bi bi-instagram"></i></a></li>
		        <li><a href="" id="utwitter"><i class="bi bi-twitter-x"></i></a></li>
		        <li><a href="" id="ufacebook"><i class="bi bi-facebook"></i></a></li>
		        <li><a href="" id="utelephone"><i class="bi bi-telephone"></i></a></li>
		    </ul>  
		</div>
		
	</div>

</nav>