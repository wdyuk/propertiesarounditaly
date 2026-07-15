<!-- Default Page -->
<div class="banner_image">
	<?php
		$bannerImage = get_image('page/'. $pageData['id'] .'-large');
	?>
	<div class="img" style="background-image: url('<?= $bannerImage; ?>');"></div>
</div>

<div class="container">
	<div class="about_us">
		<div class="main_title">
			<h1><?= $pageData['h1_title']; ?></h1>
		</div>
		<div class="row">
			<div class="col-lg-6 col-sm-6">
				<?= $pageData['content1']; ?>
			</div>
			<div class="col-lg-6 col-sm-6">
				<?= $pageData['content2']; ?>
			</div>
		</div>
		<div class="more_btn col-lg-12">
			<a href="/about"><?= $pageData['content_title']; ?></a>
		</div>
	</div>	
</div>

<?php include('includes/template/accreditations.php'); ?>