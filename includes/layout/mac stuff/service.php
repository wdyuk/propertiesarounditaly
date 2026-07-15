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
									if($crumb_title['url'] == '/services'){
										$crumb_title['url'] = '/';
									}
					?>
						<li><a href="<?= $crumb_title['url']; ?>"><?= $crumb_title['page_title']; ?> /</a></li>
					<?php
								}
							}
						}
					?>
					<li><a href="<?= $pageData['url']; ?>" class="active"><?= $pageData['page_title']; ?></a></li>
				</ul>	
			</div>	
		</div>
	</div>
</div>
<div class="sub_pages">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="main_title">
					<h1><?= $pageData['page_title']; ?></h1>
					<p><?= $pageData['h3_title']; ?></p>
				</div>
			</div>
		</div>
		<div class="top_content">
			<div class="row">
				<div class="col-md-6">
					<div class="top_text"><?= $pageData['description']; ?></div>
				</div>
				<div class="col-md-6">
				<?php
					$image = get_image('additional_images/' . $pageData['id'] . '-large');
					if(strlen($image) > 0){
				?>
					<img src="<?= $image; ?>" alt="<?= $pageData['additional_img_alt']; ?>">
				<?php
					}
				?>
				</div>
			</div>
		</div>	
		
		<div class="middel_content">
			<div class="row">
				<div class="col-md-12">
					<h4><?= $pageData['content_title']; ?></h4>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<?= $pageData['content1']; ?>
				</div>
				<div class="col-md-6">
					<?= $pageData['content2']; ?>
				</div>
			</div>
		</div>

		<div class="our_services">
			<div class="row">
				<div class="col-md-12">
					<div class="main_title">
						<h1>VIEW OUR OTHER SERVICES</h1>
					</div>
				</div>
			</div>
			<div class="row">
				<?php
					$services = table_fetch_rows('page', 'parent_id = 3 AND id != "'.$pageData['id'].'" AND status = 1','', 0,3);
					$counter = 0;
					foreach($services as $service){
						$counter++;
						$serviceImage = get_image('page/' . $service['id'] . '-large');
						if($service['id'] != $pageData['id']){?>
							<div class="col-lg-4 col-sm-4">
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
						<?php }
					}
				?>
			</div>
		</div>
	</div>

	<?php include('includes/template/accreditations.php'); ?>
</div>	