<?php
$settings = selectDB("settings","`id` = '1'");
?>
<div class="row"> 
	<div class="col-md-12"> 
		<div class="start-page-title with-white-bg text-center mb-0 py-3">
			<h1 class="mt-3"><?php echo direction("Privacy Policy","سياسة الخصوصية"); ?></h1>  
			<div class="px-3 pt-3">   
				<p><?php echo direction($settings[0]["enPolicy"],$settings[0]["arPolicy"]); ?></p>
			</div> 
		</div>
	</div>
</div>