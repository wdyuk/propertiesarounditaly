<!-- Career Article Page -->
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
								if($crumb_title['url'] != $pageData['url'] && $crumb_title['url'] != '/'){
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

<div class="career_article">
	<div class="container">
		<div class="career_list">
			<a href="/career-form?id=<?= $pageData['id']; ?>">
				<div class="row">
					<div class="col-lg-12">
						<div class="about_career">
							<h2><?= $pageData['title']; ?></h2>
							<span><div class="title">Location:</div> <?= $pageData['location']; ?></span>
							<span><div class="title">Contract Type:</div> <?= $pageData['contract_type']; ?></span>
							<span><div class="title">Closing Date:</div> <?= date('d F Y',strtotime($pageData['closing_date'])); ?></span>
							<a class="view_more" href="/career-form?id=<?= $pageData['id']; ?>">apply</a>
						</div>	
					</div>
				</div>
			</a>
		</div>	
		<div class="description">
			<?= $pageData['description']; ?>
			<div class="abt_resposbility">
				<p>Responsibilities</p>
				<?= $pageData['responsibilities']; ?>
				<p>Qualifications</p>
				<?= $pageData['qualifications']; ?>
				<div class="share_icon"><i class="fa fa-share-alt" aria-hidden="true"></i></div>
			</div>		
		</div>
	</div>
</div>	

<?php include('includes/template/accreditations.php'); ?>