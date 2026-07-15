<!-- T&Cs Page -->
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
		<div class="sub_content">
			<div class="row">
				<div class="col-md-12">
					<div class="top_text"><?= $pageData['description']; ?></div>
					<?= $pageData['content1']; ?>
					<?= $pageData['content2']; ?>
				</div>
			</div>
		</div>
	</div>

	<?php include('includes/template/accreditations.php'); ?>
</div>