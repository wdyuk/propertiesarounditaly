<?php

// $images = table_fetch_rows('property_media', 'property_id=' . $pageData['id'].' AND (media_type="primary" OR media_type="secondary")', 'position ASC');
$pageData['price'] = number_format($pageData['price']);
$images = [];
$images[] = get_image('properties/' .$pageData['id'] . '-top');
$extra_images = table_fetch_rows('property_gallery_photos','property_id = "'.$pageData['id'].'"');
if ($extra_images) {
	foreach($extra_images as $extra_image) {
		$filename = '/uploads/property_gallery_photos/' .$extra_image['filename'];
		$temp_filename = explode('.',$filename);
		$parts = count($temp_filename) - 2;
		$temp_filename[$parts] = $temp_filename[$parts].'_web';
		$filename = implode('.',$temp_filename);

		$images[] = $filename;
	}
}
           
$caption = '';
if (!strlen($image)) {
    $image = 'assets/img/awaiting-image.jpg';
}

if ($pageData['type'] == 'Sale') {
    
    $notetext = 'For Sale';

} else {

    $notetext = 'To Let';

}
?>
<section class="property-listing-page__heading py-4">
	<div class="container">
		<div class="row my-2 my-md-3 my-lg-4">
			<div class="col-10 text-left">
				<div class="property-listing-page__heading__summary" style="position: relative">
					<h3><?= $notetext; ?></h3>
					<h2 class="property-listing-page__price">&euro;<?= $pageData['price'];?> <?= $pageData['price_qualifier'];?></h2>
					<h1 class="b-0 property-listing-page__header"><?php echo ucwords(strtolower($pageData['name'])); ?> - ref.: <?= $pageData['reference']; ?><br><?= $pageData['location']; ?></h1>
				</div>
					<!-- <h6 class="property_type_label my-2 d-block d-lg-none"><?= $pageData['type']; ?></h6>
					<span class="property-listings-page__property-label"><?= $vebra_prop_status[$web_status]; ?></span></h4> -->
			</div>
			<div class="col-2 text-right">
				<?php if (strlen($pageData['size'])) { ?>
					<div class="property-listing-page__heading__summary d-flex align-items-center" style="position: relative">
						<div class="text-center">
							<img class="property-listing-page__featured-property-detail" alt="size" src="/assets/img/icons/measurement.svg" style="width: 60px; max-width: 100%;color: #fff; height auto;" class="icon icon--d-iblock">
							<span class="d-block fs-4"><?= $pageData['size'];?></span>
						</div>
					</div>
				<?php } ?>
					<!-- <h6 class="property_type_label my-2 d-block d-lg-none"><?= $pageData['type']; ?></h6>
					<span class="property-listings-page__property-label"><?= $vebra_prop_status[$web_status]; ?></span></h4> -->
			</div>
		</div>
	</div>
</section>