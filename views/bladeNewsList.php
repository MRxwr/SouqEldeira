<?php
$perPage = 9;
$page = ( isset($_GET['page']) && (int)$_GET['page'] > 0 ) ? (int)$_GET['page'] : 1;

$totalNews = 0;
if( $allNews = selectDB("news","`status` = '0' AND `hidden` = '1'") ){
	$totalNews = sizeof($allNews);
}
$totalPages = max(1, (int)ceil($totalNews / $perPage));
if( $page > $totalPages ){
	$page = $totalPages;
}
$offset = ($page - 1) * $perPage;

$newsList = selectDB("news","`status` = '0' AND `hidden` = '1' ORDER BY `id` DESC LIMIT {$offset},{$perPage}");
?>
<nav aria-label="breadcrumb" class="mb-3">
	<ol class="breadcrumb mb-0">
		<li class="breadcrumb-item"><a href="/"><?php echo direction("Home","الرئيسية"); ?></a></li>
		<li class="breadcrumb-item active" aria-current="page"><?php echo direction("News","الأخبار"); ?></li>
	</ol>
</nav>
<div class="row">
	<div class="col-md-12">
		<div class="start-page-title with-white-bg text-center mb-4 py-3">
			<h1 class="mb-0 fw-bold"><?php echo direction("News","الأخبار"); ?></h1>
		</div>
	</div>
</div>

<div class="listings-section">
	<?php
	if( $newsList ){
		include 'template/newsMainList.php';
	}else{
		echo '<p class="text-center">' . direction("No news available","لا توجد أخبار متاحة") . '</p>';
	}
	?>

	<?php if( $totalPages > 1 ){ ?>
	<nav aria-label="News pagination" class="mt-4">
		<ul class="pagination justify-content-center">
			<li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
				<a class="page-link" href="/news-list/<?php echo max(1, $page - 1); ?>"><?php echo direction("Previous","السابق"); ?></a>
			</li>
			<?php for( $p = 1; $p <= $totalPages; $p++ ){ ?>
			<li class="page-item <?php echo ($p == $page) ? 'active' : ''; ?>">
				<a class="page-link" href="/news-list/<?php echo $p; ?>"><?php echo $p; ?></a>
			</li>
			<?php } ?>
			<li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
				<a class="page-link" href="/news-list/<?php echo min($totalPages, $page + 1); ?>"><?php echo direction("Next","التالي"); ?></a>
			</li>
		</ul>
	</nav>
	<?php } ?>
</div>
