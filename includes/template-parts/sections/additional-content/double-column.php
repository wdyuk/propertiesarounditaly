<?php if (empty($pageData['content1']) && empty($pageData['content2'])){

}
else{?>
	<section class="additional-content" id="area2">
		<div class="container">
			<div class="row">
				<div class="col mb-5">
					<div class="additional-content__content">
						<div class="row">
							<div class="col-12 col-md-6 pe-md-5">
								<?= $pageData['content1'];?>
							</div>
							<div class="col-12 col-md-6 ps-md-5">
								<?= $pageData['content2'];?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php } ?>