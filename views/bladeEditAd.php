
<?php if(!$_SESSION['valid']){
	echo "<script>window.location.href = '/index.php?v=Login';</script>";
 } else {
	$product = selectDB("products","`id` = '{$_GET["id"]}'");
	$normalAds = 0;
	$specialAds = 0;
	if($user[0]["id"] >0){
		
		$normalAds = $user[0]["normalAd"];
		$specialAds = $user[0]["specialAd"];
		$order = selectDB("orders2","`userId` = '{$user[0]["id"]}' ORDER BY `id` DESC LIMIT 1","");
		$package = selectDBNew("packages",[$order[0]["packageId"]],"`status` = '0' AND `hidden` = '1' AND `id` = ?","");
	//var_dump($user);
	
	if(isset($_POST["editAds"])){
		//var_dump($user);
		if(isset($_POST["id"])){
			$dataArray = array(
			"categoryId"	=>	$_POST["categoryId"],
			"packageId" => "{$order[0]["packageId"]}",
			"propertyType"	=>	$_POST["propertyType"],
			"areaId"	=>	$_POST["adArea"],
			"enTitle"		=>	$_POST["adTitle"],
			"arTitle"		=>	$_POST["adTitle"],
			"price"		=>	$_POST["adPrice"],
			"enDetails"	=>	$_POST["adDescription"],
			"arDetails"	=>	$_POST["adDescription"],
		);
		updateDB("products",$dataArray,"`id` LIKE '{$_POST["id"]}'");
		
			// Upload images
			if ( isset($_FILES['files'])) {
				for( $i = 0; $i < sizeof($_FILES['files']['tmp_name']); $i++ ){
					if( is_uploaded_file($_FILES['files']['tmp_name'][$i]) ){
						$filenewname = uploadImageBannerown($_FILES["files"]["tmp_name"][$i]);
						insertDB("images",array("productId" => $_POST["id"],"imageurl" => $filenewname));
					}
				}
			}	
			header("LOCATION: index.php?v=MyAds");
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
 }

?>
	
		<div class="row"> 
		<div class="col-md-11 mx-auto">
		<div class="guest-form-action">
			    <div class="form-container form-container-add">
			    	
		    	<div class="start-page-title text-center mb-4">
					<h4><?php echo Trans('app','Edit Ad'); ?></h4>
			 	</div>
			 	
			    <form id="add-ad-form" class="mt-4" name="add-ad-form" method="POST"  action="" enctype="multipart/form-data">
				<input type="hidden" name="editAds" value="1">
				<input type="hidden" name="id" value="<?php echo $product[0]["id"]; ?>">
				<div class="form-outline mb-4">
						<div class="main-radio-btn">
						<?php
							if( $categories = selectDB("categories","`status` = '0' AND `hidden` = '1' ORDER BY `rank` ASC") ){
								$checked =  "";
								for( $i = 0; $i < sizeof($categories); $i++ ){
									$title = direction($categories[$i]["enTitle"],$categories[$i]["arTitle"]);
									$checked = ($i == $product[0]["categoryId"]) ? "checked" : "";
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
						<?php if($product[0]["adType"] == 1){ ?>
							<div class="radio-btn">
					  		  <input type="radio" name="adType" id="aRegular" checked value="1" />
					  		  <label for="aRegular"><?php echo Trans('app','Regular Ad'); ?> (<?php echo $normalAds; ?>)</label>
					  	   </div>
						  <div class="radio-btn">
					  		<input type="radio" name="adType" id="aSpecial"  value="2" disabled  />
					  		<label for="aSpecial"><?php echo Trans('app','Special Ad'); ?> (<?php echo $specialAds; ?>)</label>  
					  	   </div>
						<?php }else{ ?>
							<div class="radio-btn">
					  		  <input type="radio" name="adType" id="aRegular" value="1" disabled />
					  		  <label for="aRegular"><?php echo Trans('app','Regular Ad'); ?> (<?php echo $normalAds; ?>)</label>
					  	   </div>
						  <div class="radio-btn">
					  		<input type="radio" name="adType" id="aSpecial" checked value="2"  />
					  		<label for="aSpecial"><?php echo Trans('app','Special Ad'); ?> (<?php echo $specialAds; ?>)</label>  
					  	   </div>
						<?php } ?>			  		
				  		
					  	
				 	</div>
				 </div> 
				  
				  <!-- State input -->
			      <div class="form-outline mb-4">
			      	<select class="form-select form-control mb-3" name="adArea" required>
					  <option value=""><i class="bi bi-geo-alt"></i> <?php echo Trans('app','Area or Region'); ?></option>
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
										$selected = ($areas[$j]["id"] == $product[0]["areaId"]) ? "selected" : "";
										$title = direction($areas[$j]["enTitle"],$areas[$j]["arTitle"]);
										echo "<option value='{$areas[$j]["id"]}' {$selected}>{$title}</option>";
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
					  <option value=""><i class="bi bi-building"></i> <?php echo Trans('app','Properity Type'); ?></option>
						<?php
						if( $propertyType = selectDB("propertyType","`status` = '0' AND `hidden` = '1' ORDER BY `rank` ASC") ){
							for( $i = 0; $i < sizeof($propertyType); $i++ ){
								$selected = ($i == $product[0]["propertyType"]) ? "selected" : "";
								$title = direction($propertyType[$i]["enTitle"],$propertyType[$i]["arTitle"]);
								echo "<option value='{$propertyType[$i]["id"]}' {$selected}>{$title}</option>";
							}
						}
						?>
					</select>
			      </div>

			      <!-- Price input -->
			      <div class="form-outline mb-4">
			        <input type="number"  class="form-control" name="adPrice" placeholder="<?php echo Trans('app','Price'); ?>" value="<?php echo $product[0]["price"]; ?>" required />
			      </div>
			
				  <!-- Title input -->
			      <div class="form-outline mb-4">
			        <input type="text"  class="form-control" name="adTitle" placeholder="<?php echo Trans('app','Title'); ?>" value="<?php echo $product[0]["enTitle"]; ?>"  required/>
			      </div>
			     
				  <!-- Description input --> 
			      <div class="form-outline mb-3">
			         <textarea class="form-control" style="min-height:100px;"  rows="9" name="adDescription" placeholder="<?php echo Trans('app','Description'); ?>" required><?php echo $product[0]["enDetails"]; ?></textarea>
			      </div>
			      
			      <!-- Description input -->
			      <div class="form-outline mb-4">
			      	 <label class="mb-3"><?php echo Trans('app','Images'); ?></label>
			      	 <div class="add-ad-images" for="fileInput" id="fileInputLabel">
					   <?php
								if( $images = selectDB("images","`productId` = '".$product[0]["id"]."'") ){
									for( $z = 0; $z < sizeof($images); $z++ ){
										if( $z == 0 ){
											$active = "active";
										}else{
											$active = "";
										}
										?>
										<label for="file<?php echo $z+1; ?>InputFld" class="fileInput images" id="file<?php echo $z+1; ?>Input">
											<img src="logos/<?php echo $images[$z]["imageurl"] ?>" class="d-block w-100 h-100" alt="...">
									    </label>
										<?php
									}
									for( $x = sizeof($images); $x < 5; $x++ ){ ?>
										<label for="file<?php echo x; ?>InputFld" class="fileInput images" id="file<?php echo x; ?>Input">+</label>
									<?php }
								}else{
									?>
									<label for="file1InputFld" class="fileInput images" id="file1Input">+</label>
			      	 				<label for="file2InputFld" class="fileInput images" id="file2Input">+</label>
			      	 				<label for="file3InputFld" class="fileInput images" id="file3Input">+</label>
			      	 				<label for="file4InputFld" class="fileInput images" id="file4Input">+</label>
									<?php
								}
								?>
			      	 	
			      	 </div>
					 <div style="display:none">
					   <input type="file" name="files[]" id="file1InputFld">
					   <input type="file" name="files[]" id="file2InputFld">
					   <input type="file" name="files[]" id="file3InputFld">
					   <input type="file" name="files[]" id="file4InputFld">
					</div>
			      	 <span class="form-hint d-block mt-3"><?php echo Trans('app','Picture size is 1:1 square'); ?></span>
			      </div>
			      <!-- Submit button -->
			      <button type="submit" class="btn btn-primary btn-block w-100 mb-3 py-2"><?php echo Trans('app','Update Ad'); ?></button>
			      <div class="text-center">  
			      	<p class="add-ad-form-text fw-bold"><?php echo Trans('app','Send us message by'); ?> <a href=""><?php echo Trans('app','WhatsApp'); ?></a> <?php echo Trans('app','or'); ?> <a href="contact.php"><?php echo Trans('app','call us'); ?></a> <?php echo Trans('app','for help'); ?></p>
			      </div> 
			    </form>
			 </div>
		   </div>
		  </div>
		</div>
		