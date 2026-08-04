<div class="listings-main-list news-main-list">
	<div class="row gy-3">
	<?php
		foreach( $newsList as $newsItem ){
			$newsUrl = "/news-view/{$newsItem['id']}/" . slug($newsItem['enTitle']) . "-" . slug($newsItem['arTitle']);
			$snippet = mb_substr(strip_tags(direction($newsItem['enDetails'], $newsItem['arDetails'])), 0, 150);
	?>
			<div class="col-lg-12">
				<a style="cursor: pointer" class="card listing-card news-card" href="<?php echo $newsUrl; ?>">
					<div class="row g-0 align-items-center">
						<div class="col-4 col-sm-3 position-relative">
							<img src="/logos/<?php echo $newsItem['imageurl']; ?>" class="d-block w-100 h-100" style="object-fit: cover; height: 120px;" alt="<?php echo direction($newsItem['enTitle'], $newsItem['arTitle']); ?>">
						</div>
						<div class="col-8 col-sm-9">
							<div class="card-body px-3">
								<h5 class="card-title fw-bold"><?php echo direction($newsItem['enTitle'], $newsItem['arTitle']); ?></h5>
								<p class="card-text"><?php echo $snippet; ?>...</p>
								<hr>
							</div>
						</div>
					</div>
				</a>
			</div>
	<?php
		}
	?>
	</div>
</div>
