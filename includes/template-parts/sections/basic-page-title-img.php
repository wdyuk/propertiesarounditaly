<?php $header_image = get_image('page/' . $pageData['id'] . '-large');?>
<section class="basic-page-title">
	<div class="container">
		<div class="row">
			<div class="col text-center">
				<div class="basic-page-title__content">
					<h1><?= $pageData['page_title'];?></h1>
				</div>
			</div>
		</div>
	</div>
	<div class="basic-page-title__img bg-img" style="background-image:url(<?= $header_image;?>);">
		
	</div>
</section>