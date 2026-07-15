<!-- Project Article Page -->
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

<div class="news_article project_article">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="news-next-prev">
					<ul>
					<?php
						$currentid = $pageData['id'];
						$projectsp = table_fetch_rows('projects','id<'.$currentid.' AND status=1','id DESC LIMIT 1');
						if($projectsp != null){
							foreach($projectsp as $projectp){
					?>
						<li><a href="<?= $projectp['url']; ?>"><i class="fa fa-angle-left" aria-hidden="true"></i> Prev</a></li>
					<?php
							}
						}
					?>
					<?php
						$currentid = $pageData['id'];
						$projectsn = table_fetch_rows('projects','id>'.$currentid.' AND status=1','id ASC LIMIT 1');
						if($projectsn != null){
							foreach($projectsn as $projectn){
					?>
						<li><a href="<?= $projectn['url']; ?>">Next <i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
					<?php
							}
						}
					?>
					</ul>
				</div>
				<div class="page-title news-article-title">
					<h1><?= $pageData['title']; ?></h1>
				</div>	
			</div>		
		</div>
	</div>

	<div class="page-main">
		<div class="container">	
			<div class="row">
				<div class="col-lg-12">	
					<div class="news-article-content project_content">
						<?php 
						   @$photos = get_table_photos('projects', $data['id'], 'FULL');				
							$bannerCount = 0;							
							if($photos != NULL){
						?>
						<div class="owl-carousel owl-theme project_slider">
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
							}
							else
							{
								$projectImage = get_image('/projects/' . $pageData['id'] . '-project');
						?>
							<img src="<?= $projectImage; ?>" alt="<?= $pageData['img_alt']; ?>">
						<?php
							}
						?>
					</div>
				</div>
			</div>
			
			<div class="news_article_desc">
				<div class="row">
					<div class="col-lg-8">				
						<div class="project_article_desc">
							<?= $pageData['description']; ?>	
							<div class="social-share">
								<a href="#"><i class="fa fa-share-alt" aria-hidden="true"></i></a>
							</div>
						</div>
				
						<div class="news-next-prev">
							<ul>
								<?php
									$currentid = $pageData['id'];
									$projectsp = table_fetch_rows('projects','id<'.$currentid.' AND status=1','id DESC LIMIT 1');
									if($projectsp != null){
										foreach($projectsp as $projectp){
								?>
									<li><a href="<?= $projectp['url']; ?>"><i class="fa fa-angle-left" aria-hidden="true"></i> Prev</a></li>
								<?php
										}
									}
								?>
								<?php
									$currentid = $pageData['id'];
									$projectsn = table_fetch_rows('projects','id>'.$currentid.' AND status=1','id ASC LIMIT 1');
									if($projectsn != null){
										foreach($projectsn as $projectn){
								?>
									<li><a href="<?= $projectn['url']; ?>">Next <i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
								<?php
										}
									}
								?>
							</ul>
						</div>	
					</div>
					<div class="col-lg-4">
						<div class="page_sidebar">
							<div class="services">
								<?= $pageData['services']; ?>
							</div>
							<div class="sidebar_contact">
								<?php $block3 = table_fetch_row('blocks', 'id=1 AND status=1'); ?>
								<?= $block3['description']; ?>
							</div>
						</div>
					</div>
				</div>
			</div>	
		</div>
	</div>
</div>

<?php include('includes/template/accreditations.php'); ?>