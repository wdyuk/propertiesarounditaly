<?php

    $limit = 6;
    $page = 1;
    
    if (isset($_GET['page'])) {
        $page = intval($_GET['page']);
    }
    
    $visibility_where = build_visible_property_where($site['id']);
    $total_rows = table_row_count('properties','type="Rental" AND status="1" AND ' . $visibility_where);
    $total_pages = ceil($total_rows / $limit);
    
    $properties = table_fetch_rows('properties', 'type="Rental" and status="1" AND ' . $visibility_where, 'price ASC', ($page-1) * $limit, $limit);
?>

<div class="container mb-5">
   
    <div class="row pb-2">
        <div class="col-12 text-center">
            <h1 class="featured-properties py-1 fs-1">Properties for Rental</h1>
        </div>
    </div>

    <div class="row py-1">
        <div class="col-12 col-md-6">
            <?php if (count($properties)) {
                if ($page * $limit > $total_rows) {
                    $end = $total_rows;
                } else {
                    $end = $page * $limit;
                }
                $start= (($page-1) * $limit) + 1;

                ?>
                <p>Showing <?= $start; ?> to <?= $end; ?> of <?= $total_rows; ?> properties</p> 
            </div>
            <div class="col-12 col-md-6 d-flex justify-content-end">
                 <?php show_pagination($total_pages, $page); ?>
            <?php } else { ?>
                <p>Sorry there are currently no properties to view.</p>
            <?php } ?>
           
        </div>
    </div>

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
                                    <div class="home-page__featured-property-details text-end">
                                        <span class="home-page__featured-property-detail pe-3"><img alt="size" src="/assets/img/icons/measurement.svg" style="width: 100px; height auto;" class="icon icon--d-iblock icon--md"> <?= $property['size'];?></span>
                                    
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
