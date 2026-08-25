<nav aria-label="breadcrumb" class="mb-3">
	<ol class="breadcrumb mb-0">
		<li class="breadcrumb-item"><a href="/"><?php echo direction("Home","الرئيسية"); ?></a></li>
		<li class="breadcrumb-item active" aria-current="page"><?php echo direction("Real Estate Offices","المكاتب العقارية"); ?></li>
	</ol>
</nav>
<div class="offices-list"> 
	<div class="row d-flex align-items-stretch gy-3 gx-2">
		<div class="col-md-12"> 
			<div class="start-page-title text-center mb-md-4 py-md-3 mt-1 mt-md-0">
				<h1 class="mb-0"><?php echo direction("Offices List","قائمة المكاتب"); ?></h1>
			</div>
		</div>
		<?php 
		if ( $offices = selectDB("shops","`id` != '0' AND `status` = '0' ")){
			for( $i = 0; $i < sizeof($offices); $i++ ){
				?>
				<div class="col-6 col-lg-4">
					<div class="card card-office text-center">
						<a class="card-img" href="/office-view/<?php echo $offices[$i]["id"]; ?>">
						<img src="/logos/<?php echo $offices[$i]["logo"]; ?>" class="img-fluid" alt="<?php echo direction($offices[$i]["enTitle"],$offices[$i]["arTitle"]); ?>">
						</a>
						<div class="card-body">
						<h5 class="card-title fw-bold"><a href="/office-view/<?php echo $offices[$i]["id"]; ?>"><?php echo direction($offices[$i]["enTitle"],$offices[$i]["arTitle"]); ?></a></h5>
						<div class="card-social">
							<ul>
						<?php 
						$arraySMIcons = ["bi bi-facebook","bi bi-twitter-x","bi bi-instagram","bi bi-envelope"];
						$arrayLinks = ["https://www.facebook.com/","https://www.twitter.com/","https://www.instagram.com/","mailto:"]; 
						$arraySM = ["facebook","twitter","instagram","email"];
						for( $j = 0; $j < sizeof($arraySMIcons); $j++ ){
							if( !empty($offices[$i][$arraySM[$j]]) ){
							?>
							<li><a href="<?php echo $arrayLinks[$j] . $offices[$i][$arraySM[$j]]; ?>"><i class="<?php echo $arraySMIcons[$j]; ?>"></i></a></li>
							<?php
							}
						}
						?>
							</ul>
						</div>
						<div class="mx-0"> 
							<a href="tel:<?php echo $offices[$i]["mobile"]; ?>" class="btn btn-primary w-100"><i class="bi bi-telephone-fill mx-2"></i><?php echo direction("Call","اتصل"); ?></a>
						</div>
						</div>
					</div>
				</div>
				<?php
			}
		}
		?>
	</div>
</div>