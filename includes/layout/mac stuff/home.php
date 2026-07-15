<div class="banner_slider">
	<div id="banner-slider" class="owl-carousel owl-theme">
	<?php
		@$photos = get_table_photos('page', $data['id'], 'FULL');				
		$bannerCount = 0;							
		if($photos != NULL){							
			foreach($photos as $key => $photo){
				$bannerCount++;
	?>
		<div class="item">
			<div class="slider_img" style="background-image: url('<?= $photo['file']; ?>'); "></div>
			<div class="slider_text">
				<p><?= $photo['banner_text']; ?></p>
			</div>
		</div>
	<?php
			}
		}
	?>
	</div>
</div>

<div class="container">
	<div class="welcome_section">
		<div class="row">
			<div class="col-lg-12 col-sm-12">
				<div class="wlc_text wlc_heading">
					<?= $pageData['content1']; ?>
				</div>
				<div class="wlc_text ">
					<?= $pageData['content2']; ?>
				</div>	
			</div>
			<div class="more_btn col-lg-12">
				<a href="/about">Learn more</a>
			</div>
		</div>
	</div>
	
	<div class="our_services">
		<div class="main_title">
			<h1>our services</h1>
		</div>
		<div class="row">
		<?php
			$services = table_fetch_rows('page', 'parent_id = 3 AND status = 1');
			$counter = 0;
			foreach($services as $service){
				$counter++;
				$serviceImage = get_image('page/' . $service['id'] . '-large');?>
				<div class="col-lg-3 col-sm-6">
					<div class="services_content">
						<div class="ser_img"><img src="<?= $serviceImage; ?>" alt="<?= $service['banner_alt']; ?>"></div>
						<div class="ser_text">
							<h2><?= $service['menu_title']; ?></h2>
							<p><?= $service['h3_title']; ?></p>
						</div>
						<a href="<?= $service['url']; ?>" class="ser_link">	
							<div class="ser_hover_text">
								<div class="ser_img"><img src="<?= $serviceImage; ?>"></div>
								<h2><?= $service['menu_title']; ?></h2>
								<p>Learn more</p>	
							</div>
						</a>	
					</div>
				</div>
				<?php if($counter == 4){
						$counter = 0;?>
		</div>
		<div class="row" style="padding-top: 20px;">
				<?php	}?>
			<?php } ?>


		</div>
	</div>
</div>

<div class="projects">
	<div class="main_title">
		<h1>projects</h1>
	</div>
	<?php
		$projects = table_fetch_rows('projects','status=1','position ASC',0,4);
		foreach($projects as $project){
	?>
	<div class="pro_landingcontent">
		<a href="<?= $project['url']; ?>">
		<?php
			$projectimg = get_image('projects/' . $project['id'] . '-project');

			if (strlen($projectimg) > 0){
		?>
			<div class="pro_img" style="background-image: url('<?= $projectimg; ?>');"></div>
		<?php
			}
		?>
			<div class="pro_innerinfo">
				<i class="fa fa-plus" aria-hidden="true"></i>
				<h3><?= $project['title']; ?></h3>
				<?= $project['short_description']; ?>
			</div>
		</a>
	</div>
	<?php } ?>
</div>

<div class="news">
	<div class="container">
		<div class="main_title">
			<h1>news</h1>
		</div>		
		<div class="row">
			<div class="col-lg-6 col-sm-6">
				<div class="left_news">
				<?php
					$newsf = table_fetch_row('news', 'status = 1', 'published_at DESC', 0, 1);
					$newsImage = get_image('news/' . $newsf['id'] . '-image');
				?>
					<a href="<?= $newsf['url']; ?>"><div class="news_img" style="background-image: url(<?= $newsImage; ?>);">
						<div class="news_text">
							<h1><?= $newsf['title']; ?></h1>
							<p class="read_link">Read more</p>
						</div>
					</div></a>
				</div>
			</div>
			<div class="col-lg-6 col-sm-6">
				<div class="right_news">
				<?php
					$newses = table_fetch_rows('news', 'status = 1', 'published_at DESC', 1, 2);
					foreach($newses as $news){
						$news['published_at'] = date('jS F Y', strtotime($news['published_at']));
				?>
					<div class="news_text">
						<a href="<?= $news['url']; ?>"><p class="date"><?= $news['published_at']; ?></p>
							<h1><?= $news['title']; ?></h1>
							<p class="read_link">Read more</p>
						</a>	
					</div>
					<?php
						}
					?>
				</div>
			</div>		
		</div>
	</div>
</div>

<?php include('includes/template/accreditations.php'); ?>