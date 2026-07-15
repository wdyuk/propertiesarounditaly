<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="breadcrumbs">
				<ul>
					<?php
						$crumbs = explode("/",$_SERVER["REQUEST_URI"]);
						foreach($crumbs as $crumb){
							$crumb_titles = table_fetch_rows('page', 'status = 1 AND url = "/'. $crumb .'"', '');
							foreach($crumb_titles as $crumb_title){ 
								if($crumb_title['url'] != $pageData['url']){
					?>
					<li><a href="<?= $crumb_title['url']; ?>"><?= $crumb_title['page_title']; ?> /</a></li>
					<?php
								}
							}
						}
					?>
					<li><a href="<?= $pageData['url']; ?>" class="active"><?= $pageData['title']; ?></a></li>
				</ul>	
			</div>
		</div>		
	</div>
</div>

<div class="news_article">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="news-next-prev">
					<ul>
					<?php
						$currentid = $pageData['id'];
						$newsesp = table_fetch_rows('news','id<'.$currentid.' AND status=1','id DESC LIMIT 1');
						if($newsesp != null){
							foreach($newsesp as $newsp){
					?>
						<li><a href="<?= $newsp['url']; ?>"><i class="fa fa-angle-left" aria-hidden="true"></i> Prev</a></li>
					<?php
							}
						}
					?>
					<?php
						$currentid = $pageData['id'];
						$newsesn = table_fetch_rows('news','id>'.$currentid.' AND status=1','id ASC LIMIT 1');
						if($newsesn != null){
							foreach($newsesn as $newsn){
					?>
						<li><a href="<?= $newsn['url']; ?>">Next <i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
					<?php
							}
						}
					?>
					</ul>
				</div>
				<div class="page-title news-article-title">
					<h1><?= $pageData['h1_title']; ?></h1>
				</div>	
			</div>		
		</div>
	</div>

	<div class="page-main">
		<div class="container">	
			<div class="row">
				<div class="col-lg-12">	
					<div class="news-article-content slider-img">
						<?php
							if(strlen($pageData['video_alt']) > 0){
							$videos = BASE_URL. 'uploads/news/' .$pageData['video_alt'];
						?>
						<div class="news-video">
							<figure>
								<video data-keepplaying="" playsinline="" controls style="width: 100%;">
									<source src="<?= $videos; ?>"  type="video/mp4">
								</video>
							</figure>
						</div>
						
						<?php
							} else {
						?>
						<?php
								@$photos = get_table_photos('news', $data['id'], 'FULL');
								$bannerCount = 0;							
								if($photos != NULL){
						?>
						<div class="owl-carousel owl-theme news_slider">
							<?php 
									foreach($photos as $key => $photo){
										$bannerCount++;
							?>
								<div class="item">
									<div class="article_img" style="background-image: url('<?php echo $photo['file']; ?>');"></div>
								</div>
							<?php 
									}
							?>
						</div>
						<?php
							} else {
								$newsImage = get_image('news/' . $pageData['id'] . '-image');
						?>
							<div class="news-image">
								<div class="article_img" style="background-image: url('<?= $newsImage; ?>');"></div>
							</div>
						<?php
								}
							}
						?>
				
						<div class="news_article_desc">
							<?= $pageData['description']; ?>	
							<div class="social-share">
								<a href="#"><i class="fa fa-share-alt" aria-hidden="true"></i></a>
							</div>
						</div>

						<div class="news-next-prev">
							<ul>
								<?php
									$currentid = $pageData['id'];
									$newsesp = table_fetch_rows('news','id<'.$currentid.' AND status=1','id DESC LIMIT 1');
									if($newsesp != null){
										foreach($newsesp as $newsp){
								?>
									<li><a href="<?= $newsp['url']; ?>"><i class="fa fa-angle-left" aria-hidden="true"></i> Prev</a></li>
								<?php
										}
									}
								?>
								<?php
									$currentid = $pageData['id'];
									$newsesn = table_fetch_rows('news','id>'.$currentid.' AND status=1','id ASC LIMIT 1');
									if($newsesn != null){
										foreach($newsesn as $newsn){
								?>
									<li><a href="<?= $newsn['url']; ?>">Next <i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
								<?php
										}
									}
								?>
							</ul>
						</div>
					</div>	
				</div>
			</div>	
		</div>
	</div>
</div>

<?php include('includes/template/accreditations.php'); ?>