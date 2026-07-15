<?php $latest_news = table_fetch_rows('news','status = 1', 'published_at DESC', 0, 2);?>
<section class="latest-news">
	<div class="container">
		<div class="row">
			<div class="col text-center">
				<h2>Latest News</h2>
			</div>
		</div>
		<div class="row">
			<?php foreach ($latest_news as $news) {
				$image = get_image('news/' . $news['id'] . '-image');
				if (strlen($image) > 0){
					$class = 'latest-news__post--img';
					$class2 = 'latest-news__post-overlay--img';
					$style = 'style="background-image:url('.$image.');"';
				}
				else{
					$class = 'latest-news__post-overlay--no-img';
					$class2 = 'latest-news__post-overlay--no-img';
					$style = '';
				}
				$date = date('d F',strtotime($news['published_at']));?>
			
				<div class="col-md-6 p-md-1">
					<div class="latest-news__post <?= $class;?>" <?= $style;?>>
						<div class="latest-news__post-overlay <?= $class2;?>">
							<div class="latest-news__post-content">
								<div class="latest-news__post-meta">
									<span class="latest-news__post-meta-date"><?= $date;?></span>
								</div>
								<h2 class="latest-news__post-title"><?= substr(strip_tags($news['title']),0,60);?>...</h2>
								<p class="latest-news__post-snippet"><?= substr(strip_tags($news['short_description']),0,150);?>...</p>
								<p class="button simple blue"><a href="<?= $news['url'];?>">Read More</a></p>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</section>