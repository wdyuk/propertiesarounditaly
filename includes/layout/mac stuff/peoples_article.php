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

<div class="people_article">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="main_title">
					<h1><?= $pageData['name']; ?></h1>
				</div>
				<div class="sub_title">	
					<h4><?= $pageData['designation']; ?></h4>
				</div>
			</div>
		</div>
		<div class="row">	
			<div class="col-md-9 flex-desc">
				<div class="article-desc">
					<?= $pageData['description']; ?>
					<div class="article-contact-info">
						<p>M : <?= $pageData['mobile']; ?></p>
						<p>E : <?= $pageData['email']; ?></p>
						<p>in : <?= $pageData['linkedin']; ?></p>
					</div>	
				</div>
			</div>	
			<div class="col-md-3 flex-image">		
				<div class="people-image">
				<?php
					$peopleImage = get_image('peoples/' . $pageData['id'] . '-image');
					if (strlen($peopleImage) > 0){
				?>
					<img src="<?= $peopleImage; ?>">
				<?php
					}
				?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include('includes/template/accreditations.php'); ?>			