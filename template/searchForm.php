<?php
/*
 * Search form shared by the home page and the search results page.
 * Optional pre-selected filters: $searchCategoryId, $searchAreaId,
 * $searchPropertyTypeId, $searchFrom, $searchTo and $searchFormClass.
 */
$formCategoryId     = isset($searchCategoryId) ? (int)$searchCategoryId : 0;
$formAreaId         = isset($searchAreaId) ? (int)$searchAreaId : 0;
$formPropertyTypeId = isset($searchPropertyTypeId) ? (int)$searchPropertyTypeId : 0;
$formFrom           = isset($searchFrom) ? (string)$searchFrom : "";
$formTo             = isset($searchTo) ? (string)$searchTo : "";
$formClass          = isset($searchFormClass) ? $searchFormClass : "search-area";
?>
<form class="<?php echo $formClass; ?>" action="/search" method="GET">
	<div class="search-area-row"> 
		<div class="row">
			<div class="main-radio-btn">
				<?php
				if( $formCategories = selectDB("categories","`status` = '0' AND `hidden` = '1' ORDER BY `rank` ASC") ){
					for( $x = 0; $x < sizeof($formCategories); $x++ ){
						$formCategoryTitle = direction($formCategories[$x]["enTitle"],$formCategories[$x]["arTitle"]);
						$formCategoryChecked = ( (int)$formCategories[$x]["id"] === $formCategoryId ) ? "checked" : "";
						echo "<div class='radio-btn'>
							<input type='radio' id='a{$formCategories[$x]["id"]}' name='categoryId' value='{$formCategories[$x]["id"]}' {$formCategoryChecked} />
							<label for='a{$formCategories[$x]["id"]}'>{$formCategoryTitle}</label>
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
						<select class="form-select select2-area" name="areaId" aria-label="Property Region">
						<option <?php echo ($formAreaId > 0 ? "" : "selected"); ?> value=""><?php echo direction("Area or Region","المنطقة أو الإقليم"); ?></option>
						<?php
						$formAreaOrderBy = direction("enTitle","arTitle");
						if( $formGovernates = selectDB("governates","`status` = '0' ORDER BY `rank` ASC") ){
							for( $g = 0; $g < sizeof($formGovernates); $g++ ){
								$formGovernateTitle = direction($formGovernates[$g]["enTitle"],$formGovernates[$g]["arTitle"]);
								echo "<optgroup label='{$formGovernateTitle}'>";
								if( $formAreas = selectDB("areas","`status` = '0' AND `governateId` = '{$formGovernates[$g]["id"]}' ORDER BY `{$formAreaOrderBy}` ASC") ){
									for( $a = 0; $a < sizeof($formAreas); $a++ ){
										$formAreaTitle = direction($formAreas[$a]["enTitle"],$formAreas[$a]["arTitle"]);
										$formAreaSelected = ( (int)$formAreas[$a]["id"] === $formAreaId ) ? "selected" : "";
										echo "<option value='{$formAreas[$a]["id"]}' {$formAreaSelected}>{$formAreaTitle}</option>";
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
						<option <?php echo ($formPropertyTypeId > 0 ? "" : "selected"); ?> value=""><?php echo direction("Properity Type","نوع العقار"); ?></option>
						<?php
						if( $formPropertyTypes = selectDB("propertyType","`status` = '0' AND `hidden` = '1' ORDER BY `rank` ASC") ){
							for( $p = 0; $p < sizeof($formPropertyTypes); $p++ ){
								$formPropertyTypeTitle = direction($formPropertyTypes[$p]["enTitle"],$formPropertyTypes[$p]["arTitle"]);
								$formPropertyTypeSelected = ( (int)$formPropertyTypes[$p]["id"] === $formPropertyTypeId ) ? "selected" : "";
								echo "<option value='{$formPropertyTypes[$p]["id"]}' {$formPropertyTypeSelected}>{$formPropertyTypeTitle}</option>";
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
		<div class="advanced-search-view"<?php echo ( $formFrom !== "" || $formTo !== "" ) ? ' style="display:block"' : ''; ?>>
			<div class="row mt-3">   
				<div class="col-6 col-md-6">
					<div class="form-outline"> 
					<input type="text" class="form-control" name="from" value="<?php echo htmlspecialchars($formFrom); ?>" placeholder="<?php echo direction("Price From","السعر من"); ?>">
					</div>
				</div>
				<div class="col-6 col-md-6">
					<div class="form-outline">
					<input type="text" class="form-control" name="to" value="<?php echo htmlspecialchars($formTo); ?>" placeholder="<?php echo direction("Price To","السعر إلى"); ?>">
					</div> 
				</div>
			</div> 
		</div>
	</div>
</form>
