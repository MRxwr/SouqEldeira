<?php
$socialMedia = selectDB("s_media","`id` = '1'");
?>
<nav aria-label="breadcrumb" class="mb-3">
	<ol class="breadcrumb mb-0">
		<li class="breadcrumb-item"><a href="/"><?php echo direction("Home","الرئيسية"); ?></a></li>
		<li class="breadcrumb-item active" aria-current="page"><?php echo direction("FAQ","الأسئلة الشائعة"); ?></li>
	</ol>
</nav>
<div class="row">
<div class="col-md-11 mx-auto">
	<div class="form-container form-container-faq">
		<div class="mb-4 text-center">
			<img src="assets/img/logo-1.png" class="img-fluid" alt="<?php echo direction("Souq Al Deirah","سوق الديرة"); ?>">
		</div>
		<div class="mb-4 text-center">
			<h1 class="faq-title" ><?php echo direction("FAQ","الأسئلة الشائعة"); ?></h1> 
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
			<a href="/contact"><?php echo direction("call us","اتصل بنا"); ?></a> <?php echo direction("for help","للمساعدة"); ?></p>
		</div>
	</div>
</div>
</div>