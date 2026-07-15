<section class="basic-page-title">
	<div class="container">
		<div class="row">
			<div class="col text-center">
				<div class="basic-page-title__content">
					<h1><?= $pageData['page_title'];?><?php if ($rewriteData['url'] == '/about/latest-news') {
						if (isset($_GET['year'])) { echo ' ('.(int) $_GET['year'].') '; }; ?><?php if (isset($_GET['p']) && $_GET['p'] > 1) { echo ' - Page '.(int) $_GET['p'].''; };
						} ?></h1>
				</div>
			</div>
		</div>
	</div>
</section>