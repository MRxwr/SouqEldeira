<?php
if( isset($_GET['id']) && $news = selectDBNew("news",[$_GET['id']],"`id` = ? AND `status` = '0' AND `hidden` = '1'","") ){
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
<h1 class="mb-md-5 mb-3 text-center ad-title"><?php echo direction($news[0]['enTitle'], $news[0]['arTitle']); ?></h1>

<div class="ad-details">
	<div class="row">
		<div class="col-sm-8">
			<img src="/logos/<?php echo $news[0]['imageurl']; ?>" class="img-fluid w-100" style="object-fit: cover; height: 300px; border-radius: 10px;" alt="<?php echo direction($news[0]['enTitle'], $news[0]['arTitle']); ?>">
		</div>
		<div class="col-sm-8">
			<h5 class="fw-bold"><?php echo direction("Description","الوصف"); ?></h5>
			<p><?php echo direction($news[0]['enDetails'], $news[0]['arDetails']); ?></p>
		</div>
		<div class="col-sm-4">
			<div class="listings-section">
				<h4 class="text-start mt-2 mb-3"><?php echo direction("More News","المزيد من الأخبار"); ?></h4>
				<?php
				if( $newsList = selectDB("news","`status` = '0' AND `hidden` = '1' AND `id` != {$news[0]['id']} ORDER BY `id` DESC LIMIT 3") ){
					include 'template/newsMainList.php';
				}
				?>
				<div class="d-block text-end mt-3">
					<a href="/news-list/1" class="btn btn-primary"><?php echo direction("More","المزيد"); ?> <i class="bi bi-three-dots"></i></a>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "NewsArticle",
  "headline": "<?php echo direction($news[0]['enTitle'], $news[0]['arTitle']); ?>",
  "description": "<?php echo htmlspecialchars(strip_tags(direction($news[0]['enDetails'], $news[0]['arDetails']))); ?>",
  "image": "<?php echo $baseURL . "logos/" . $news[0]['imageurl']; ?>",
  "url": "<?php echo urldecode("http://{$_SERVER["HTTP_HOST"]}{$_SERVER["REQUEST_URI"]}"); ?>",
  "publisher": {
    "@type": "Organization",
    "name": "<?php echo direction("Souq Al Deirah","سوق الديرة"); ?>",
    "logo": {
      "@type": "ImageObject",
      "url": "<?php echo $baseURL . "assets/img/logo-1.png"; ?>"
    }
  }
}
</script>

<hr>
