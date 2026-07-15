<div class="container mb-5">
   
    <div class="row py-4">
        <div class="col-12 text-center">
            <h2 class="featured-properties py-4">Featured Properties</h2>
        </div>
    </div>
    <?php $properties = table_fetch_rows('properties', 'featured=1', 'price ASC'); ?>
    <div class="row gy-md-3">
        <?php foreach($properties as $property):
       
            $image = get_image('properties/' .$property['id'] . '-top');
           
            $caption = '';
            if (!strlen($image)) {
                $image = 'assets/img/awaiting-image.jpg';
            }

            if ($property['type'] == 'Sale') {
                
                $notetext = 'For Sale';

            } else {

                $notetext = 'To Let';

            }
           
            if (($property['price'] == '0') || ($property['price'] == '')) {
                    $property['price'] = 'TBA';
                    $property['price_qualifier'] = '';
                } else {
               $property['price'] = number_format($property['price']);
           };?>
            <div class="col-lg-4 col-md-6 col-xs-12 property home-properties">
                <div class="props-box h-100">
                    <a href="<?= getRewriteUrl('properties', $property['id']); ?>">
                        <div class="home-page__featured-property-info">
                            <p class="home-page__featured-property-status mb-1"><?= $notetext;?></p>
                            <h6 class="home-page__featured-property-price mb-1">&euro;<?= $property['price'];?></h6>
                            <p class="home-page__featured-property-price-qualifier mb-1"><?=$property['price_qualifier'];?></p>
                            <p class="button simple light hover-button">View details<i class="fas fa-arrow-right ps-3"></i></p>
                        </div>
                    	<div class="home-page__featured-property bg-img" style="background-image:url(<?= $image;?>);">
                            <div class="price-block for-sale py-2 ps-3">
                                <p class="mb-0"><?= $notetext;?></p>
                                <p class="mb-0">&euro;<?= $property['price'];?> <?=$property['price_qualifier'];?></p>
                            </div>
        				</div>
        				
    					<div class="row pt-md-4 pb-3 px-3">
    						<div class="col-md-10 col-12">
    							<h6 class="home-page__featured-property-title"><?php echo ucwords(strtolower($property['name'])); ?> - ref.: <?= $property['reference']; ?><br><?= $property['location']; ?></h6>
    						</div>
    						<div class="col-md-2 col-12 text-md-start text-end ps-0 pe-md-0">
                                <?php if (strlen($property['size'])) { ?>
        							<div class="home-page__featured-property-details text-center">
                                        <img alt="size" src="/assets/img/icons/measurement.svg" class="icon icon--d-iblock icon--md"> 
        								<span class="home-page__featured-property-detail pe-3 d-block"><?= $property['size'];?></span>
        							
        							</div>
                                <?php } ?>
    						</div>
        				
        				</div>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
