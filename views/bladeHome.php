<div class="alert alert-primary welcome-message responsive" role="alert">
	<?php
	if( $topNotification = selectDB("notifications","`status` = '0' AND `hidden` = '0' ORDER BY `id` DESC LIMIT 1") ){
		echo '<i class="bi bi-exclamation-circle"></i> <b>' . $topNotification[0]["title"] . ':</b> ' . $topNotification[0]["body"];
	} else {
		echo '<i class="bi bi-exclamation-circle"></i> ' . direction("A message from the manager to manage the website","رسالة من المدير لإدارة الموقع");
	}
	?>
</div>  

<form class="search-area" action="/search" method="POST">
	<div class="search-area-row"> 
		<div class="row">
			<div class="main-radio-btn">
				<?php
				if( $categories = selectDB("categories","`status` = '0' AND `hidden` = '1' ORDER BY `rank` ASC") ){
					for( $i = 0; $i < sizeof($categories); $i++ ){
						$title = direction($categories[$i]["enTitle"],$categories[$i]["arTitle"]);
						echo "<div class='radio-btn'>
							<input type='radio' id='a{$categories[$i]["id"]}' name='categoryId' value='{$categories[$i]["id"]}' />
							<label for='a{$categories[$i]["id"]}'>{$title}</label>
						</div>";
					}
				}
				?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="form-outline mt-4"> 
					<div class="input-group input-group-select-with-icon">  
						<label class="input-group-text labelIcon" for=""><i class="bi bi-geo-alt"></i></label>
						<select class="form-select" name="areaId" aria-label="Property Region">
						<option selected value=""><i class="bi bi-geo-alt"></i> <?php echo direction("Area or Region","المنطقة أو الإقليم"); ?></option>
						<?php
						$governateId = 0;
						$directionOfArea = direction("enTitle","arTitle");
						if( $governates = selectDB("governates","`status` = '0' ORDER BY `rank` ASC") ){
							for( $i = 0; $i < sizeof($governates); $i++ ){
								$governate = selectDB("governates","`id` = '{$governates[$i]["id"]}'");
								$governateTitle = direction($governate[0]["enTitle"],$governate[0]["arTitle"]);
								echo "<optgroup label='{$governateTitle}'>";
								if( $areas = selectDB("areas","`status` = '0' AND `governateId` = '{$governates[$i]["id"]}' ORDER BY `{$directionOfArea}` ASC") ){
									for( $j = 0; $j < sizeof($areas); $j++ ){
										$title = direction($areas[$j]["enTitle"],$areas[$j]["arTitle"]);
										echo "<option value='{$areas[$j]["id"]}'>{$title}</option>";
									}
								}
							}
							echo "</optgroup>";
						}
						?>
						</select>
					</div>
				</div>	
			</div>
			<div class="col-md-4">
				<div class="form-outline mt-4">
				<div class="input-group input-group-select-with-icon">  
						<label class="input-group-text labelIcon" for=""><i class="bi bi-building"></i></label>
						<select class="form-select" name="propertyType" aria-label="Properity Type">
						<option selected value=""><i class="bi bi-building"></i> <?php echo direction("Properity Type","نوع العقار"); ?></option>
						<?php
						if( $propertyType = selectDB("propertyType","`status` = '0' AND `hidden` = '1' ORDER BY `rank` ASC") ){
							for( $i = 0; $i < sizeof($propertyType); $i++ ){
								$title = direction($propertyType[$i]["enTitle"],$propertyType[$i]["arTitle"]);
								echo "<option value='{$propertyType[$i]["id"]}'>{$title}</option>";
							}
						}
						?>
						</select>
				</div> 
				</div>
			</div>
				<div class="col-6 col-md-4">
				<div class="form-outline mt-4">
				<button type="submit" class="btn btn-primary btn-block w-100"> <?php echo direction("Search Now","ابحث الآن"); ?> &nbsp; &nbsp; <i class="bi bi-search"></i></button>
				</div>
			</div>
			<div class="col-6 col-md-12">
				<div class="form-outline mt-3 advanced-search">  
				<a href="javascript:void(0)" class="advanced-search-a"><i class="bi bi-sliders"></i><span class="fw-bold"><?php echo direction("Advanced Search","بحث متقدم"); ?></span></a>
				</div>
			</div>
		</div>
		<div class="advanced-search-view">
			<div class="row mt-3">   
				<div class="col-6 col-md-6">
					<div class="form-outline"> 
					<input type="text" class="form-control" name="from" placeholder="<?php echo direction("Price From","السعر من"); ?>">
					</div>
				</div>
				<div class="col-6 col-md-6">
					<div class="form-outline">
					<input type="text" class="form-control" name="to" placeholder="<?php echo direction("Price To","السعر إلى"); ?>">
					</div> 
				</div>
			</div> 
		</div>
	</div>
</form>
 

<div class="homePageSecondContent my-3">
	<div class="container container-project">
		<?php
		if( $homeNotification = selectDB("notifications","`status` = '0' AND `hidden` = '0' ORDER BY `id` DESC LIMIT 1") ){
			?>
			<div class="alert alert-primary welcome-message" role="alert">
				<i class="bi bi-exclamation-circle"></i> <b><?php echo $homeNotification[0]["title"]; ?>:</b> <?php echo $homeNotification[0]["body"]; ?>
			</div>
			<?php
		}
		?>
	</div>
</div>	

<div class="homePageSecondContent my-3">
	<div class="container container-project">
		<?php echo "<h1>" . direction("Latest ads on Souq Al Deirah","أحدث الإعلانات في سوق الديرة") . "</h1>"; ?>
	</div>
</div>	
	
<div class="container container-project">
	<?php
	if( $categories = selectDB("categories","`status` = '0' AND `hidden` = '1' ORDER BY `rank` ASC") ){
		for( $x = 0; $x < sizeof($categories); $x++ ){
			$type = $categories[$x]["id"];
			$categoryTitle = str_replace(" ","-",direction($categories[$x]["enTitle"],$categories[$x]["arTitle"]));
			$title = direction("Latest ads for " . $categories[$x]["enTitle"]," أحدث الإعلانات لل" . $categories[$x]["arTitle"]);
			$type1 = ( !empty($type) ) ? " AND `categoryId` = '{$type}' " : "";
			if( $ads = selectDB("products","`status` = '0' AND `hidden` = '1' {$type1} ORDER BY `packageId` DESC,`id` DESC LIMIT 3") ){
				echo "<div class='listings-section'>";
				echo "<h2 class='mb-3'>{$title}</h2>";
				require('template/adsMainList.php');
				echo "<div class='d-block text-end mt-3'>";
				echo "<a href='/search/" . $categoryTitle . "/{$type}' class='btn btn-primary'>".direction("More","المزيد")." ...</a>";
				echo "</div>";
				echo "</div>";
			}
		}
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
						echo '<a href="/office-view/' . $offices[$i]["id"] . '/' . slug(direction($offices[$i]["enTitle"],$offices[$i]["arTitle"])) . '"><img src="/logos/' . $offices[$i]["logo"] . '" style="width:157px;height:157px" alt="' . direction($offices[$i]["enTitle"],$offices[$i]["arTitle"]) . '"></a>';
						echo '</div>';
					}
				}
				?>
			</div>
		</div>
	</div>
</div>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "name": "<?php echo direction("Souq Al Deirah","سوق الديرة"); ?>",
  "url": "https://souqeldeira.com/",
  "description": "<?php echo direction("The leading real estate website in Kuwait","موقع العقارات الأول في الكويت"); ?>",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "<?php echo urldecode("https://souqeldeira.com/search/%D8%A8%D9%8A%D8%B9/1"); ?>",
    "query-input": "required name=بيع"
  }
}
</script>

