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
                        <div class="col-12 col-sm-12">
							<div class="card-body px-3">
								<h5 class="card-title fw-bold"><?php echo direction("Date", "التاريخ") . ": " . substr($newsItem['date'], 0, 10); ?></h5>
								<hr>
							</div>
						</div>
						<div class="col-12 col-sm-12">
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
