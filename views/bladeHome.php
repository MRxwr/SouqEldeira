<div class="alert alert-primary welcome-message responsive" role="alert">
	<?php
	if( $topNotification = selectDB("notifications","`status` = '0' AND `hidden` = '0' ORDER BY `id` DESC LIMIT 1") ){
		echo '<i class="bi bi-exclamation-circle"></i> <b>' . $topNotification[0]["title"] . ':</b> ' . $topNotification[0]["body"];
	} else {
		echo '<i class="bi bi-exclamation-circle"></i> ' . direction("A message from the manager to manage the website","رسالة من المدير لإدارة الموقع");
	}
	?>
</div>  

<?php include 'template/searchForm.php'; ?>
 
<?php
		if( $homeNotification = selectDB("notifications","`status` = '0' AND `hidden` = '0' ORDER BY `id` DESC LIMIT 1") ){
			?>
<div class="homePageSecondContent my-3">
	<div class="container container-project">
		<div class="alert alert-primary welcome-message" role="alert">
			<i class="bi bi-exclamation-circle"></i> <b><?php echo $homeNotification[0]["title"]; ?>:</b> <?php echo $homeNotification[0]["body"]; ?>
		</div>
	</div>
</div>	
			<?php
		}
		?>

<div class="homePageSecondContent my-3" style="justify-self: anchor-center;">
	<div class="container container-project">
		<?php echo "<h1>" . direction("Latest ads on Souq Al Deirah","أحدث الإعلانات في سوق الديرة") . "</h1>"; ?>
	</div>
</div>	
	
<div class="container container-project">
	<?php
	if( $categories = selectDB("categories","`status` = '0' AND `hidden` = '1' ORDER BY `rank` ASC") ){
		for( $x = 0; $x < sizeof($categories); $x++ ){
			$type = $categories[$x]["id"];
			$title = direction("Latest ads for " . $categories[$x]["enTitle"]," أحدث الإعلانات لل" . $categories[$x]["arTitle"]);
			$type1 = ( !empty($type) ) ? " AND `categoryId` = '{$type}' " : "";
			if( $ads = selectDB("products","`status` = '0' AND `hidden` = '1' {$type1} ORDER BY `packageId` DESC,`id` DESC LIMIT 3") ){
				echo "<div class='listings-section'>";
				echo "<h2 class='mb-3'>{$title}</h2>";
				require('template/adsMainList.php');
				echo "<div class='d-block text-end mt-3'>";
				echo "<a href='" . SeoUrls::searchUrl($categories[$x]) . "' class='btn btn-primary'>".direction("More","المزيد")." ...</a>";
				echo "</div>";
				echo "</div>";
			}
		}
	}
	?>
</div> 

<div class="container container-project">
	<?php
	if( $latestNews = selectDB("news","`status` = '0' AND `hidden` = '1' ORDER BY `id` DESC LIMIT 3") ){
		$newsList = $latestNews;
		echo "<div class='listings-section'>";
		echo "<h2 class='mb-3'>" . direction("Latest News","أحدث الأخبار") . "</h2>";
		require('template/newsMainList.php');
		echo "<div class='d-block text-end mt-3'>";
		echo "<a href='/news-list/1' class='btn btn-primary'>".direction("More","المزيد")." ...</a>";
		echo "</div>";
		echo "</div>";
	}
	?>
</div>

<div class="home-about">
	<div class="left-bg"></div>
	<div class="right-bg"></div>
	<div class="container container-project">
		<div class="row">
			<div class="col-md-12 text-center">
				<img src="assets/img/logo-white.png" class="img-fluid logo" alt="<?php echo direction("Souq Al Deirah","سوق الديرة"); ?>">
				<br>
				<p><?php 
				/*
				if ( $settings = selectDB("settings","`id` = '1'") ){
					echo direction($settings[0]["enAbout"],$settings[0]["arAbout"]);
				}
					*/
				?></p>
			</div>
		</div>
	</div> 
</div> 

<!--  Demos -->
<div class="demos">
	<div class="container container-projectX">
		<div class="mt-5">
			<h3 class="fw-bold text-center mb-5"><?php echo direction("Real estate offices in Kuwait","مكاتب العقارات في الكويت"); ?></h3> 
			<div class="owl-carousel owl-carousel-offices owl-theme">
				<?php
				if( $offices = selectDB("shops","`id` != '0' AND `status` = '0' AND `hidden` = '1' ORDER BY `rank` ASC")){
					for( $i = 0; $i < count($offices); $i++ ){
						echo '<div class="item">';
						echo '<a href="' . SeoUrls::titleUrl("office-view", $offices[$i]["id"], $offices[$i]["enTitle"], $offices[$i]["arTitle"]) . '"><img src="/logos/' . $offices[$i]["logo"] . '" style="width:157px;height:157px" alt="' . direction($offices[$i]["enTitle"],$offices[$i]["arTitle"]) . '"></a>';
						echo '</div>';
					}
				}
				?>
			</div>
		</div>
	</div>
</div>
