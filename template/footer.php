</div> 
 
 </div> 

 <footer class="mt-5x">
	<div class="container container-projectX">
		<div class="row">
		  <div class="col-md-12">
		  	<div class="footer-sec1 text-center">
				<a href="" class="logo"><img src="/assets/img/logo-1.png" alt="<?php echo direction("Souq Al Deirah","سوق الديرة"); ?>"></a>
			</div>
		  </div>
		  <div class="col-md-12 mt-4">
		  	<div class="footer-sec2 text-start">
				<?php
				if( $categories = selectDB("categories","`status` = '0' AND `hidden` = '1' ORDER BY `rank` ASC") ){
					for( $i = 0; $i < sizeof($categories); $i++ ){
						$title = direction("Properties for " . $categories[$i]["enTitle"]. " in Kuwait","العقارات لل" . $categories[$i]["arTitle"] . " في كويت");
						if( $ads = selectDB("products","`status` = '0' AND `hidden` != '2' AND `categoryId` = '{$categories[$i]["id"]}' ORDER BY RAND() LIMIT 5") ){
							echo "<div class='category-menu'><h5 class='mb-2'><a href='/search/type={$categories[$i]["id"]}' class='d-block text-start'>{$title}</a></h5><ul>";
							for( $x = 0; $x < sizeof($ads); $x++ ){
								$title = direction($ads[$x]["enTitle"],$ads[$x]["arTitle"]);
								echo "<li><a href='/ad-view/{$ads[$x]["id"]}/" . slug($ads[$x]["enTitle"]) . "-" . slug($ads[$x]["arTitle"]) . "'>{$title}</a></li>";
							}
							echo "</ul></div>";
						}
					}
				}
				?>
		  	</div>
		  </div>
		</div>	
		
		<div class="row mt-1">
		<div class="col-md-12">
			<hr>
		</div>
		</div>
		
		<div class="footer-sec3">
			<div class="row mt-4">
				<div class="col-6 col-md-4">
					<h3><?php echo direction("Contact Us","اتصل بنا"); ?></h3>
					<div class="contact-us">
						<div>
							<i class="bi bi-telephone"></i> <?php echo direction("Phone","هاتف"); ?>
							<br>
							<a href="tel:22281412">22281412</a>
						</div>
						<div>
							<i class="bi bi-envelope"></i> <?php echo direction("Email","البريد الإلكتروني"); ?>
							<br>
							<a href="mailto:info@souqeldeira.com">info@souqeldeira.com</a>
						</div>
					</div>
				</div>
				<div class="col-6 col-md-3 my-md-0 text-start text-md-center divApplications">  
					
					<h3><?php echo direction("Applications","التطبيقات"); ?></h3>
					<div class="application-links text-center">
						<a href="#"><i class="bi bi-google-play"></i><span><?php echo direction("Google Store","متجر جوجل"); ?></span></a>
						<a href="#"><i class="bi bi-apple"></i><span><?php echo direction("Apple Store","متجر آبل"); ?></span></a>
					</div>
					<hr class="res"> 
				</div>
				<div class="col-md-1"></div>
				<div class="col-md-4 divSocial">
					<hr class="res"> 
					<h3><?php echo direction("Social media platforms","منصات التواصل الاجتماعي"); ?></h3>
					<ul class="socila-links list-unstyled my-4">
						<?php
						if( $sMedia = selectDB("s_media", "`id` = '1'") ){
							$sMediaArray = ["facebook", "twitter", "instagram", "tiktok", "email", "mobile"];
							$sMediaIcons = ["bi bi-facebook","bi bi-twitter-x","bi bi-instagram","bi bi-tiktok","bi bi-envelope", "bi bi-telephone-fill"];
							$sMediaLinks = ["https://www.facebook.com/","https://www.twitter.com/","https://www.instagram.com/","https://www.tiktok.com/","mailto:", "tel:"];
							for ($i = 0; $i < count($sMediaArray); $i++) {
								if( !empty($sMedia[0]["$sMediaArray[$i]"]) ){
								echo '<li><a href="' . $sMediaLinks[$i] . $sMedia[0]["$sMediaArray[$i]"] . '"><i class="' . $sMediaIcons[$i] . '"></i></a></li>';
								}
							}
						}
						?>
				    </ul>
					<div class="copyright-text">
                        <p>
                        	<a href="https://www.createkuwait.com" target="_blank" class="copyright-icon">©</a> 
                        	<?php echo direction("All rights reserved to","جميع الحقوق محفوظة لـ"); ?>
                        	<a href="/home" target="_blank"><?php echo direction("Souq Al Deirah","سوق الديرة"); ?></a> 
                        </p> 
                    </div>
				</div>	
			</div>	
		</div>	
	</div>
</footer>

<!-- PWA Install Banner -->
<div id="install-pwa-banner" class="alert alert-light alert-dismissible shadow m-0 w-100" role="alert" style="display: none; position: fixed; bottom: 0; z-index: 9999; border-top: 1px solid #dee2e6; border-radius: 0;">
    <div class="container d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <img src="/assets/img/logo-192.png" width="40" height="40" class="me-3" alt="Logo" style="border-radius: 8px;" alt="<?php echo direction("Souq Al Deirah","سوق الديرة"); ?>">
            <div>
                <strong class="d-block text-dark"><?php echo direction("Install Souq Al Deerah","تثبيت تطبيق سوق الديرة"); ?></strong>
                <small class="text-muted d-block"><?php echo direction("Add to your home screen for quick access.","أضفه إلى شاشتك الرئيسية للوصول السريع."); ?></small>
                <small id="ios-instruction" class="text-primary mt-1" style="display: none; font-size: 0.8rem; font-weight: bold;">
                    <?php echo direction("To install, tap <i class='bi bi-box-arrow-up'></i> then 'Add to Home Screen'","للتثبيت، اضغط على <i class='bi bi-box-arrow-up'></i> ثم 'إضافة إلى الشاشة الرئيسية'"); ?>
                </small>
            </div>
        </div>
        <div class="d-flex align-items-center">
            <button id="install-pwa-btn" class="btn btn-primary btn-sm mx-2"><?php echo direction("Install","تثبيت"); ?></button>
            <button id="close-pwa-btn" type="button" class="btn-close position-static p-2" aria-label="Close"></button>
        </div>
    </div>
</div>

<div class="main-overlay"></div>
		<!-- ========================= scroll-top ========================= -->
	    <a href="#" class="scroll-top">
	        <i class="bi bi-chevron-up"></i>
	    </a>
		
    	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js?<?php echo randLetter() ?>=<?php echo $config['v'] ?>"></script>
    	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js?<?php echo randLetter() ?>=<?php echo $config['v'] ?>"></script>
    	
		<!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js?<?php echo randLetter() ?>=<?php echo $config['v'] ?>"></script>
        
        <!-- Owl JS -->
        <script src="/assets/components/owl-carousel/v-2.3.4/dist/owl.carousel.js?<?php echo randLetter() ?>=<?php echo $config['v'] ?>"></script>
        
         <!-- lightbox JS --> 
        <script src="/assets/components/bs5-lightbox/v-1.8.3/dist/index.bundle.min.js?<?php echo randLetter() ?>=<?php echo $config['v'] ?>"></script>
        
        <!-- Core theme JS-->
        <script src="/assets/js/scripts.js?<?php echo randLetter() ?>=<?php echo $config['v'] ?>"></script>
        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', function() {
                    navigator.serviceWorker.register('sw.js').then(function(registration) {
                        console.log('ServiceWorker registration successful with scope: ', registration.scope);
                    }, function(err) {
                        console.log('ServiceWorker registration failed: ', err);
                    });
                });
            }

            // PWA Install Prompt Logic
            let deferredPrompt;
            const installBanner = document.getElementById('install-pwa-banner');
            const installBtn = document.getElementById('install-pwa-btn');
            const closeBtn = document.getElementById('close-pwa-btn');
            const iosInstruction = document.getElementById('ios-instruction');

            // Detect iOS Safari
            const isIos = () => {
                const userAgent = window.navigator.userAgent.toLowerCase();
                return /iphone|ipad|ipod/.test(userAgent);
            };
            const isStandalone = () => ('standalone' in window.navigator) && (window.navigator.standalone);

            // Handle Android / Chrome (natively supports beforeinstallprompt)
            window.addEventListener('beforeinstallprompt', (e) => {
                e.preventDefault();
                deferredPrompt = e;
                if(installBanner) installBanner.style.display = 'block';
            });

            // Handle iOS (does not support beforeinstallprompt)
            if (isIos() && !isStandalone()) {
                if (installBanner) installBanner.style.display = 'block';
                if (installBtn) installBtn.style.display = 'none'; // Hide the install button because it won't work on iOS
                if (iosInstruction) iosInstruction.style.display = 'block'; // Show iOS specific instructions
            }

            if(installBtn) {
                installBtn.addEventListener('click', async () => {
                    installBanner.style.display = 'none';
                    if (deferredPrompt !== null) {
                        deferredPrompt.prompt();
                        const { outcome } = await deferredPrompt.userChoice;
                        console.log(`User response to the install prompt: ${outcome}`);
                        deferredPrompt = null;
                    }
                });
            }

            if(closeBtn) {
                closeBtn.addEventListener('click', () => {
                    installBanner.style.display = 'none';
                });
            }
        </script>
    </body>
</html>