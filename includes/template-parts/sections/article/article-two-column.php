<section class="article">
	<div class="container">
		<div class="row">
			<div class="col">
				<article class="article__content">
					<div class="row">
						<div class="col-12 col-md-6">
							<h2><?= $pageData['h1_title'];?></h2>
							<h6><?= $pageData['h2_title'];?></h6>
							<?= $pageData['description'];?>
						</div>
						<div class="col-12 col-md-6">
							<?php $path = get_image('additional_images/' . $pageData['id'] . '-large');
							if (strlen($path) == 0){
								$path = '/assets/img/generic.jpg';
							}?>
							<img src="<?= $path;?>" alt="<?= $pageData['title'];?>" class="img-fluid">
						</div>
					</div>
				</article>
			</div>
		</div>
	</div>
</section>