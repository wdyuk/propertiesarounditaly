<!-- People Page -->
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
					<li><a href="<?= $pageData['url']; ?>" class="active"><?= $pageData['page_title']; ?></a></li>
				</ul>	
			</div>	
		</div>
	</div>
</div>

<div class="container">
	<div class="people_page">
		<div class="main_title">
			<h1><?= $pageData['h1_title']; ?></h1>
		</div>
		<div class="sub_title">
			<?= $pageData['description']; ?>
		</div>
		<div class="people_list">
			<div class="row">
			<?php
				$peoples = table_fetch_rows('peoples', 'status = 1', 'position ASC');
				foreach($peoples as $people){
					$peopleImage = get_image('peoples/' . $people['id'] . '-image');
			?>
				<div class="col-lg-6 col-sm-12">
					<div class="people_item">
						<div class="row">
							<div class="col-lg-4 col-sm-4 col-12">
								<a href="<?= $people['url'];?>">
									<div class="people_img" style="background-image:url(<?= $peopleImage; ?>); "></div>
								</a>	
							</div>
							<div class="col-lg-8 col-sm-8 col-12">
								<div class="people_text">
									<a href="<?= $people['url'];?>">
										<h1><?= $people['name'];?></h1>
										<h1><?= $people['designation'];?></h1>
									</a>	
									<div class="people_info">
										<p>M: <a href="tel:<?= $people['mobile'];?>"><?= $people['mobile'];?></a></p>
										<a href="mailto:<?= $people['email'];?>" class="email_link">Email</a>
										<a href="<?= $people['linkedin'];?>" target="_blank" class="lin_link">View Linked in profile</a>
									</div>	
								</div>
							</div>
						</div>
					</div>		
				</div>
			<?php } ?>
			</div>
		</div>
	</div>	
</div>

<?php include('includes/template/accreditations.php'); ?>