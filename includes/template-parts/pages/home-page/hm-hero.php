<?php $headerproperties = table_fetch_rows('vebra_properties','header = 1 AND status = 1');?>
<section class="home-page__hero">
	<div class="home-page__hero__slider">
		<?php foreach ($headerproperties as $slide) {
			$mainimage = table_fetch_row('vebra_property_files','type = 0 AND property_id = '.$slide['id'],'id ASC');
			$name = explode('.',$mainimage['name']);
			$file = get_image('properties/'.$slide['folder_name'].'/'. $name[0] . '-original');
			?>
			<a href="<?= getRewriteUrl('vebra_properties', $slide['id']); ?>">
				<div class="home-page__hero__bg-img bg-img" style="background-image:url(<?= $file;?>); display: none;">
					<div class="home-page__hero__property-info">
						<h6 class="home-page__hero__property-title"><?= get_nice_property_name($slide); ?></h6>
						<h6 class="home-page__hero__property-price">£<?= number_format($slide['price']);?></h6>
						<div class="home-page__hero__property-details d-none d-md-block">
							<span class="home-page__hero__property-detail"><img alt="bedrooms" src="/assets/img/icons/bedroom--white.png" class="icon icon--d-iblock icon--xs"> <?= $slide['bedrooms'];?> Bedroom</span>
							<span class="home-page__hero__property-detail"><img alt="bathrooms" src="/assets/img/icons/bathroom--white.png" class="icon icon--d-iblock icon--xs"> <?= $slide['bathrooms'];?> Bathroom</span>
							<span class="home-page__hero__property-detail"><img alt="receptions" src="/assets/img/icons/reception--white.png" class="icon icon--d-iblock icon--xs"> <?= $slide['receptions'];?> Reception</span>
						</div>
					</div>
				</div>
			</a>
		<?php } ?>
	</div>
</section>