<div class="alert alert-primary welcome-message responsive" role="alert">
	<i class="bi bi-exclamation-circle"></i> <?php echo Trans('app','A message from the manager to manage the website'); ?>
</div>  

<form class="" action="?v=SearchView" method="POST">
	<div class="search-area-row"> 
		<div class="row">
			<div class="main-radio-btn">
				<div class="radio-btn">
					<input type="radio" id="aSale" name="propertyType" checked />
					<label for="aSale"><?php echo Trans('app','Sale'); ?></label>
				</div>
				<div class="radio-btn">
					<input type="radio" id="aRent" name="propertyType" />
					<label for="aRent"><?php echo Trans('app','Rent'); ?></label>
				</div>
				<div class="radio-btn">
					<input type="radio" id="aAllowance" name="propertyType" />
					<label for="aAllowance"><?php echo Trans('app','Allowance'); ?></label>
				</div>
				<div class="radio-btn"> 
					<input type="radio" id="aRequest" name="propertyType" />
					<label for="aRequest"><?php echo Trans('app','Request'); ?></label>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="form-outline mt-4"> 
					<div class="input-group input-group-select-with-icon">  
						<label class="input-group-text labelIcon" for=""><i class="bi bi-geo-alt"></i></label>
						<select class="form-select" name="propertyRegion" aria-label="Property Region">
						<option selected><i class="bi bi-geo-alt"></i> <?php echo Trans('app','Area or Region'); ?></option>
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
						<select class="form-select" name="categoryId" aria-label="Properity Type">
						<option selected><i class="bi bi-building"></i> <?php echo Trans('app','Properity Type'); ?></option>
						<?php
						if( $categories = selectDB("categories","`status` = '0' AND `hidden` = '1' ORDER BY `rank` ASC") ){
							for( $i = 0; $i < sizeof($categories); $i++ ){
								$title = direction($categories[$i]["enTitle"],$categories[$i]["arTitle"]);
								echo "<option value='{$categories[$i]["id"]}'>{$title}</option>";
							}
						}
						?>
						</select>
				</div> 
				</div>
			</div>
				<div class="col-6 col-md-4">
				<div class="form-outline mt-4">
				<button type="submit" class="btn btn-primary btn-block w-100"> <?php echo Trans('app','Search Now'); ?> &nbsp; &nbsp; <i class="bi bi-search"></i></button>
				</div>
			</div>
			<div class="col-6 col-md-12">
				<div class="form-outline mt-3 advanced-search">  
				<a href="#!" class="advanced-search-a"><i class="bi bi-sliders"></i><span class="fw-bold"><?php echo Trans('app','Advanced Search'); ?></span></a>
				</div>
			</div>
		</div>
		<div class="advanced-search-view">
			<div class="row mt-3">   
					<div class="col-6 col-md-6">
						<div class="form-outline"> 
						<input type="text" class="form-control" name="propertyPriceFrom" placeholder="<?php echo Trans('app','Price From'); ?>">
						</div>
					</div>
					<div class="col-6 col-md-6">
						<div class="form-outline">
						<input type="text" class="form-control" name="propertyPriceTo" placeholder="<?php echo Trans('app','Price To'); ?>">
						</div> 
					</div>
			</div> 
		</div>
	</div>
</form>
 

<div class="homePageSecondContent my-3">
	<div class="container container-project">
		<div class="alert alert-primary welcome-message" role="alert">
			<i class="bi bi-exclamation-circle"></i> <?php echo Trans('app','A message from the manager to manage the website'); ?>
		</div>
	</div>
</div>	
	
<div class="container container-project">
	<?php
	$arrayOf4 = [Trans('app','Latest ads for sale'),Trans('app','For rent the latest ads'),Trans('app','For the latest ads allowance'),Trans('app','To request the latest announcements')];
	for( $i = 0; $i < 4; $i++ ){
		$type = $i;
		echo "<div class='ads-section'>";
		echo "<h4 class='mb-3'>{$arrayOf4[$i]}</h4>";
		require('template/adsMainList.php');
		echo "<div class='d-block text-end mt-3'>";
		echo "<a href='' class='btn btn-primary'>".Trans('app','More')." ...</a>";
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
				<img src="assets/img/logo-white.png" class="img-fluid logo">
				<br>
				<p><?php 
				if ( $settings = selectDB("settings","`id` = '1'") ){
					echo direction($settings[0]["enAbout"],$settings[0]["arAbout"]);
				}
				?></p>
			</div>
		</div>
	</div> 
</div> 

<!--  Demos -->
<div class="demos">
	<div class="container container-projectX">
		<div class="mt-5">
			<h3 class="fw-bold text-center mb-5"><?php echo Trans('app','Real estate offices in Kuwait'); ?></h3> 
			<div class="owl-carousel owl-carousel-offices owl-theme">
				<?php
				if( $offices = selectDB("shops","`id` != '0' AND `status` = '0' ORDER BY `rank` ASC")){
					for( $i = 0; $i < count($offices); $i++ ){
						echo '<div class="item">';
						echo '<a href="?v=OfficeView&id=' . $offices[$i]["id"] . '"><img src="logos/' . $offices[$i]["logo"] . '" style="width:157px;height:157px"></a>';
						echo '</div>';
					}
				}
				?>
			</div>
		</div>
	</div>
</div>

