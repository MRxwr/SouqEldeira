
<?php if(!$_SESSION['valid']){
	echo "<script>window.location.href = '/index.php?v=Login';</script>";
 } else {
	$settings = selectDB("settings","`id` = '1'");
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
			
				  
				  <div class="form-outline mb-4">
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
				  <div class="form-outline mb-4">
				  	<div class="main-radio-btn">			  		
				  		<div class="radio-btn">
					  		<input type="radio" name="adType" id="aRegular" />
					  		<label for="aRegular"><?php echo Trans('app','Regular Ad'); ?> (1)</label>
					  	</div>
					  	<div class="radio-btn">
					  		<input type="radio" name="adType" id="aSpecial" checked  />
					  		<label for="aSpecial"><?php echo Trans('app','Special Ad'); ?> (9)</label>  
					  	</div>
				 	</div>
				 </div> 
				  
				  <!-- State input -->
			      <div class="form-outline mb-4">
			      	<select class="form-select form-control mb-3" name="ad-state">
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
			      	<select class="form-select form-control mb-3" name="propertyType">
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
			        <input type="number"  class="form-control" name="ad-price" placeholder="<?php echo Trans('app','Price'); ?>" />
			      </div>
			
				  <!-- Phone input -->
			      <div class="form-outline mb-4">
			        <input type="text"  class="form-control" name="ad-phone" placeholder="<?php echo Trans('app','Phone Number'); ?>" />
			      </div>

				  <!-- Title input -->
			      <div class="form-outline mb-4">
			        <input type="text"  class="form-control" name="adTitle" placeholder="<?php echo Trans('app','Title'); ?>" />
			      </div>
			     
				  <!-- Description input --> 
			      <div class="form-outline mb-3">
			         <textarea class="form-control" style="min-height:100px;"  rows="9" name="ad-description" placeholder="<?php echo Trans('app','Description'); ?>"></textarea>
			      </div>
			      
			      <!-- Description input -->
			      <div class="form-outline mb-4">
			      	 <label class="mb-3"><?php echo Trans('app','Images'); ?></label>
			      	 <div class="add-ad-images" for="fileInput" id="fileInputLabel">
			      	 	<span for="fileI1nputFld" class="images" id="file1Input">+</span>
			      	 	<span for="fileI2nputFld" class="images" id="file2Input">+</span>
			      	 	<span for="fileI3nputFld" class="images" id="file3Input">+</span>
			      	 	<span for="fileI4nputFld" class="images" id="file4Input">+</span>
			      	 </div>
					 <div style="display:none">
					   <input type="file" id="fileI1nputFld">
					   <input type="file" id="fileI2nputFld">
					   <input type="file" id="fileI3nputFld">
					   <input type="file" id="fileI4nputFld">
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
		<script>
			$(document).ready(function () {
				// Map span clicks to corresponding file input clicks
				$('.images').on('click', function () {
					const id = $(this).attr('id'); // Get the ID of the clicked span
					const fileInputId = id.replace('Input', 'InputFld'); // Map to file input ID
					$('#' + fileInputId).trigger('click'); // Trigger file input click
				});

				// Display the selected image
				$('input[type="file"]').on('change', function (event) {
					const inputId = $(this).attr('id'); // Get file input ID
					const spanId = inputId.replace('InputFld', 'Input'); // Map to span ID
					const file = event.target.files[0]; // Get the selected file

					if (file) {
						const reader = new FileReader();
						reader.onload = function (e) {
							$('#' + spanId).css('background-image', `url(${e.target.result})`).text(''); // Display image
						};
						reader.readAsDataURL(file); // Read the file as a DataURL
					}
				});
			});
		</script>