<!-- Careers Page -->
<div class="banner_image">
	<?php
		$bannerImage = get_image('page/'. $pageData['id'] .'-large');
	?>
	<div class="img" style="background-image: url('<?= $bannerImage; ?>');"></div>
</div>

<div class="container">
	<div class="career_into">
		<div class="main_title">
			<h1><?= $pageData['h1_title']; ?></h1>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<?= $pageData['content1']; ?>
				<?= $pageData['content2']; ?>
			</div>
		</div>
	</div>	
</div>

<div class="container">
	<div class="career_list">
		<?php
			$today = date('Y-m-d H:i:s');
			$vacancies = table_fetch_rows('vacancies', 'publish_date <="'. $today .'" AND status=1');
			foreach($vacancies as $vacancy){
			$vacancy['closing_date'] = date('d F Y', strtotime($vacancy['closing_date']));
		?>
		<a href="<?= $vacancy['url']; ?>">
			<div class="row">
				<div class="col-lg-12">
					<div class="about_career">
						<h2><?= $vacancy['title']; ?></h2>
						<span><div class="title">Location:</div> <?= $vacancy['location']; ?></span>
						<span><div class="title">Contract Type:</div> <?= $vacancy['contract_type']; ?></span>
						<span><div class="title">Closing Date:</div> <?= $vacancy['closing_date']; ?></span>
						<span><div class="title">Overview:</div> <?= $vacancy['short_description']; ?></span>
						<a class="view_more" href="<?= $vacancy['url']; ?>">view</a>
					</div>	
				</div>
			</div>
		</a>
		<?php
			}
		?>
	</div>	
</div>

<?php include('includes/template/accreditations.php'); ?>