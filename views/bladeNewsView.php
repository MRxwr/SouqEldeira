<?php
if( isset($_GET['id']) && $news = selectDBNew("news",[$_GET['id']],"`id` = ? AND `status` = '0' AND `hidden` = '1'","" ) ){
	$newsTitleForSlug = slug($news[0]['enTitle']) . "-" . slug($news[0]['arTitle']);
}else{
	?>
	<script>
		alert("Could not process your request, Please try again.");
		window.location = "/news-list/1";
	</script>
	<?php
}
?>

<div class="ad-details">
	<div class="row">
		<div class="col-md-8 col-sm-12 mx-auto">
			<div class="row">
				<div class="col-12 mb-3">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb mb-2">
							<li class="breadcrumb-item"><a href="/"><?php echo direction("Home","الرئيسية"); ?></a></li>
							<li class="breadcrumb-item"><a href="/news-list/1"><?php echo direction("News","الأخبار"); ?></a></li>
							<li class="breadcrumb-item active" aria-current="page"><?php echo direction($news[0]['enTitle'], $news[0]['arTitle']); ?></li>
						</ol>
					</nav>
					<h1 class="fw-bold"><?php echo direction($news[0]['enTitle'], $news[0]['arTitle']); ?></h1>
				</div>
				<div class="col-sm-12 mb-3">
					<img src="/logos/<?php echo $news[0]['imageurl']; ?>" class="img-fluid w-100" style="object-fit: cover; height: 300px; border-radius: 10px;" alt="<?php echo direction($news[0]['enTitle'], $news[0]['arTitle']); ?>">
				</div>
				<div class="col-sm-12 mb-3">
					<h5 class="fw-bold"><?php echo direction("Description","الوصف"); ?></h5>
					<p><?php echo direction($news[0]['enDetails'], $news[0]['arDetails']); ?></p>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-sm-12">
			<div class="listings-section">
				<h4 class="text-start mt-2 mb-3"><?php echo direction("More News","المزيد من الأخبار"); ?></h4>
				<?php
				if( $newsList = selectDB("news","`status` = '0' AND `hidden` = '1' AND `id` != {$news[0]['id']} ORDER BY `id` DESC LIMIT 3") ){
					include 'template/newsListInsideView.php';
				}
				?>
				<div class="d-block text-end mt-3">
					<a href="/news-list/1" class="btn btn-primary"><?php echo direction("More","المزيد"); ?> <i class="bi bi-three-dots"></i></a>
				</div>
			</div>
		</div>
	</div>
</div>

<hr>
