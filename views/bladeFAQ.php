<?php
$socialMedia = selectDB("s_media","`id` = '1'");
?>
<div class="row">
<div class="col-md-11 mx-auto">
	<div class="form-container form-container-faq">
		<div class="mb-4 text-center">
			<img src="assets/img/logo-1.png" class="img-fluid" alt="...">
		</div>
		<div class="mb-4 text-center">
			<h5 class="faq-title" ><?php echo direction("Frequently asked questions about properties for rent or sale in Kuwait","الأسئلة الشائعة حول العقارات للإيجار أو البيع في الكويت"); ?></h5> 
		</div>
		<div class="accordion accordion-flush" id="accordionFlushExample">
			<?php
			if( $faq = selectDB("faq","`id` != '0' AND `status` = '0' ORDER BY `rank` ASC") ){
				for( $i = 0; $i < count($faq); $i++ ){
					?>
					<div class="accordion-item">
					<h2 class="accordion-header" id="flush-heading<?php echo $i ?>">
						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?php echo $i ?>" aria-expanded="false" aria-controls="flush-collapse<?php echo $i ?>">
							<?php echo direction($faq[$i]["enQuestion"],$faq[$i]["arQuestion"]) ?>
						</button>
					</h2>
					<div id="flush-collapse<?php echo $i ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?php echo $i ?>" data-bs-parent="#accordionFlushExample">
						<div class="accordion-body"><?php echo direction($faq[$i]["enAnswer"],$faq[$i]["arAnswer"]) ?></div>
					</div>
					</div>
					<?php
				}
			}
			?>
		</div>
			<div class="text-center mt-4"> 
			<p class="add-ad-form-text fw-bold"><?php echo direction("Send us message by","أرسل لنا رسالة عبر"); ?>
			<a href="https://wa.me/<?php echo $socialMedia[0]['mobile']; ?>"><?php echo direction("WhatsApp","واتساب"); ?></a>
			<?php echo direction("or","أو"); ?>
			<a href="?v=Contact"><?php echo direction("call us","اتصل بنا"); ?></a> <?php echo direction("for help","للمساعدة"); ?></p>
			</div>
	</div>
</div>
</div>