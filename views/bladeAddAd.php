
<?php if(!$_SESSION['valid']){
	echo "<script>window.location.href = '/index.php?v=Login';</script>";
 } else {
	$settings = selectDB("settings","`id` = '1'");
	var_dump($user);
	if( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["addads"]) && !empty($_POST["adType"]) && !empty($_POST["adTitle"]) && !empty($_POST["adDescription"]) && !empty($_POST["adPrice"]) && !empty($_POST["propertyType"]) ){
		$data = array(
			"userId" => "{$_POST["userId"]}",
			"categoryId"	=>	$_POST["categoryId"],
			"propertyType"	=>	$_POST["propertyType"],
			"areaId"	=>	$_POST["adArea"],
			"adType"	=>	$_POST["adType"],
			"enTitle"		=>	$_POST["adTitle"],
			"price"		=>	$_POST["adPrice"],
			"enDetails"	=>	$_POST["adDescription"],
			"categoryId"	=>	$GenerateNewCC,
		);
		
		if( insertDB("products", $data) ){
			// Get last inserted id
			$lastId = $conn->insert_id;
			// Upload images
				if ( isset($_FILES['files'])) {
					for( $i = 0; $i < sizeof($_FILES['files']['tmp_name']); $i++ ){
						if( is_uploaded_file($_FILES['files']['tmp_name'][$i]) ){
							$filenewname = uploadImageBanner($_FILES["files"]["tmp_name"][$i]);
							insertDB("images",array("productId" => $lastId,"imageurl" => $filenewname));
						}
					}
				}
			header("LOCATION: index.php?v=AddAd");
		}else{
			?>
			<script>
				alert("Could not process your request, Please try again.");
			</script>
			<?php
			header("LOCATION: index.php?v=AddAd");
		}	
	}
}
?>
			
			
		<div class="row"> 
		<div class="col-md-11 mx-auto">
		<div class="guest-form-action">
			    <div class="form-container form-container-add">
			    	
		    	<div class="start-page-title text-center mb-4">
					<h4><?php echo Trans('app','Add Ad'); ?></h4>
			 	</div>
			 	
			    <form id="add-ad-form" class="mt-4" method="post" action="index.php?v=AddAd" enctype="multipart/form-data">
				<input type="hidden" name="addads" value="1">
				<div class="form-outline mb-4">
						<div class="main-radio-btn">
						<?php
							if( $categories = selectDB("categories","`status` = '0' AND `hidden` = '1' ORDER BY `rank` ASC") ){
								$checked =  "";
								for( $i = 0; $i < sizeof($categories); $i++ ){
									$title = direction($categories[$i]["enTitle"],$categories[$i]["arTitle"]);
									$checked = ($i == 0) ? "checked" : "";
									echo "<div class='radio-btn'>
										<input type='radio' id='a{$categories[$i]["id"]}' name='categoryId' value='{$categories[$i]["id"]}' {$checked} />
										<label for='a{$categories[$i]["id"]}'>{$title}</label>
									</div>";
								}
							}
							?>
						</div>
				 </div> 
				  <div class="form-outline mb-4">
				  	<div class="main-radio-btn">			  		
				  		<div class="radio-btn">
					  		<input type="radio" name="adType" id="aRegular" value="0" />
					  		<label for="aRegular"><?php echo Trans('app','Regular Ad'); ?> (1)</label>
					  	</div>
					  	<div class="radio-btn">
					  		<input type="radio" name="adType" id="aSpecial" checked value="1"  />
					  		<label for="aSpecial"><?php echo Trans('app','Special Ad'); ?> (9)</label>  
					  	</div>
				 	</div>
				 </div> 
				  
				  <!-- State input -->
			      <div class="form-outline mb-4">
			      	<select class="form-select form-control mb-3" name="adArea" required>
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
			      
			       <!-- Property type input -->
			      <div class="form-outline mb-4">
			      	<select class="form-select form-control mb-3" name="propertyType" required>
					  <option selected><i class="bi bi-building"></i> <?php echo Trans('app','Properity Type'); ?></option>
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

			      <!-- Price input -->
			      <div class="form-outline mb-4">
			        <input type="number"  class="form-control" name="ad-price" placeholder="<?php echo Trans('app','Price'); ?>" required />
			      </div>
			
				  <!-- Phone input -->
			      <div class="form-outline mb-4">
			        <input type="text"  class="form-control" name="ad-phone" placeholder="<?php echo Trans('app','Phone Number'); ?>" />
			      </div>

				  <!-- Title input -->
			      <div class="form-outline mb-4">
			        <input type="text"  class="form-control" name="adTitle" placeholder="<?php echo Trans('app','Title'); ?>"  required/>
			      </div>
			     
				  <!-- Description input --> 
			      <div class="form-outline mb-3">
			         <textarea class="form-control" style="min-height:100px;"  rows="9" name="ad-description" placeholder="<?php echo Trans('app','Description'); ?>" required></textarea>
			      </div>
			      
			      <!-- Description input -->
			      <div class="form-outline mb-4">
			      	 <label class="mb-3"><?php echo Trans('app','Images'); ?></label>
			      	 <div class="add-ad-images" for="fileInput" id="fileInputLabel">
			      	 	<label for="file1InputFld" class="fileInput images" id="file1Input">+</label>
			      	 	<label for="file2InputFld" class="fileInput images" id="file2Input">+</label>
			      	 	<label for="file3InputFld" class="fileInput images" id="file3Input">+</label>
			      	 	<label for="file4InputFld" class="fileInput images" id="file4Input">+</label>
			      	 </div>
					 <div style="display:none">
					   <input type="files[]" id="file1InputFld">
					   <input type="files[]" id="file2InputFld">
					   <input type="files[]" id="file3InputFld">
					   <input type="files[]" id="file4InputFld">
					</div>
			      	 <span class="form-hint d-block mt-3"><?php echo Trans('app','Picture size is 1:1 square'); ?></span>
			      </div>
			      <!-- Submit button -->
			      <button type="submit" class="btn btn-primary btn-block w-100 mb-3 py-2"><?php echo Trans('app','Add Ad'); ?></button>
			      <div class="text-center">  
			      	<p class="add-ad-form-text fw-bold"><?php echo Trans('app','Send us message by'); ?> <a href=""><?php echo Trans('app','WhatsApp'); ?></a> <?php echo Trans('app','or'); ?> <a href="contact.php"><?php echo Trans('app','call us'); ?></a> <?php echo Trans('app','for help'); ?></p>
			      </div> 
			    </form>
			 </div>
		   </div>
		  </div>
		</div>
		