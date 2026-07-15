<section class="property-listings-page__list">
	<div class="container container-listview">
		<div class="row">
			<?php foreach ($properties as $property) {
				if($pageData['id'] == 9){
					if($property['type'] == "commercial"){
						$details = false;
					}
					else{
						$details = true;
					}
				}
				$notetext = '';
                if ($property['sale_under_offer'] == 1) {
                    $notetext = $property['sale_under_offer'];
                } else {
                    if ($property['status'] != 'To Let') {
                        $notetext = 'For Sale';
                        $class = 'for-sale-proplist';
                        $mob_class = 'for-sale';
                    }
                    elseif($property['status'] == '0'){
                        $notetext = 'For Sale';
                        $class = 'for-sale-proplist';
                        $mob_class = 'for-sale';
                    }
                    else{
                    	$notetext = $property['status'];
                        $class='sstc-proplist';
                        $mob_class = 'sstc';
                    }
                }
				$firstimage = table_fetch_row('property_media', 'property_id=' . $property['id'], 'position ASC');
			    $caption = '';
                $image = '/assets/img/awaiting-image.jpg';

                if($firstimage != false) {
                    $caption = $firstimage['caption'];
                    $image = BASE_URL . 'media/properties/' . $firstimage['filename'];
                }; ?>
				<div class="col-12 col-md-12 p-md-1 mb-4 property-listings d-none d-md-block">
					<div class="props-box h-100">
						<div class="property-listings-page__property">
							<a href="<?= getRewriteUrl('properties', $property['id']); ?>" class="property-listings-page__property-link">
								<div class="row">
									<div class="col-lg-8 col-sm-6 g-md-0">
										<img class="img-fluid" src="<?= $image;?>"/>
									</div>
									<div class="col-lg-4 col-sm-6 g-md-0">
										<div class="all-info">
											<div class="property-listings-page__property-title-price-area mt-4 ps-xxl-5 ps-4 py-2 <?= $class;?>">
												<p class="property-listings-page__status"><?= $notetext;?></p>
												<?php if ($property['price'] > 0) { ?>
													<h6 class="property-listings-page__property-price mb-1">£<?= number_format($property['price']);?><span class="property-listings-page__property-price-qualifier"><?php if (strlen($property['price_qualifier']) > 0) { ?>
													<?= ' '.$property['price_qualifier']; } ?></span></h6>
												<?php } ?>
											</div>
											<div class="property-listings-page__property-alldetails ms-xxl-5 ms-4">
												<div class="property-listings-page__property-title-address-area py-xl-5 pt-lg-4 pt-3">
													<h6 class="property-listings-page__property-title mb-1"><?= str_replace(',', ', <br/>', $property['display_address']);?></h6>
												</div>
												<?php if($details == true){ ?>
													<div class="property-listings-page__property-details py-lg-5 pt-3">
														<span class="property-listings-page__property-detail pe-xl-4 pe-2"><img alt="Bedrooms" src="/assets/img/icons/bed-icon_Large_.png" class="icon icon--d-iblock icon--xl"> <?= $property['bedrooms'];?></span>
														<span class="property-listings-page__property-detail pe-xl-4 pe-2"><img alt="Bathrooms" src="/assets/img/icons/bathroom-icon_Large_.png" class="icon icon--d-iblock icon--xl"> <?= $property['bathrooms'];?></span>
														<span class="property-listings-page__property-detail pe-xl-4 pe-2"><img alt="Receptions" src="/assets/img/icons/sofa-icon_Large_.png" class="icon icon--d-iblock icon--xl"> <?= $property['reception_rooms'];?></span>
													</div>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
							</a>
						</div>
					</div>
				</div>
				<div class="col-sm-12 property home-properties d-block d-md-none">
                    <div class="props-box h-100">
                        <div class="home-page__featured-property-info">
                            <p class="home-page__featured-property-status mb-1"><?= $notetext;?></p>
                            <h6 class="home-page__featured-property-price mb-1">£<?= $property['price'];?></h6>
                            <p class="home-page__featured-property-price-qualifier mb-1"><?=$property['price_qualifier'];?></p>
                            <p class="button simple light hover-button"><a href="<?= getRewriteUrl('properties', $property['id']); ?>">View details</a></p>
                        </div>
                    	<div class="home-page__featured-property bg-img" style="background-image:url(<?= $image;?>);">
                            <div class="price-block <?= $mob_class;?> py-1 ps-3">
                                <p class="mb-0"><?= $notetext;?></p>
                                <p class="mb-0">£<?= number_format($property['price']);?> <?=$property['price_qualifier'];?></p>
                            </div>
						</div>
						<div class="">
							<div class="row pt-md-4 pt-1">
								<?php if($details == true){ ?>
									<div class="col-md-7 col-12">
										<h6 class="home-page__featured-property-title ps-3"><?php echo $property['display_address']; ?></h6>
									</div>
									<div class="col-md-5 col-12 text-md-start text-end ps-0 pe-md-0 pe-4">
										<div class="home-page__featured-property-details">
											<span class="home-page__featured-property-detail pe-xxl-2 pe-xl-1"><img alt="bedrooms" src="/assets/img/icons/bed-icon_.png" class="icon icon--d-iblock icon--md pe-xxl-2 pe-xl-1"> <?= $property['bedrooms'];?></span>
											<span class="home-page__featured-property-detail pe-xxl-2 pe-xl-1"><img alt="bathroom" src="/assets/img/icons/bathroom-icon_.png" class="icon icon--d-iblock icon--md pe-xxl-2 pe-xl-1"> <?= $property['bathrooms'];?></span>
											<span class="home-page__featured-property-detail pe-xxl-2 pe-xl-1"><img alt="receptions" src="/assets/img/icons/sofa-icon_.png" class="icon icon--d-iblock icon--md pe-xxl-2 pe-xl-1"> <?= $property['reception_rooms'];?></span>
										</div>
									</div>
								<?php }
								else{ ?>
									<div class="col-md-12 col-12">
										<h6 class="home-page__featured-property-title ps-3"><?php echo $property['display_address']; ?></h6>
									</div>
								<?php } ?>
							</div>
						</div>
                    </div>
                </div>
			<?php } ?>
		</div>
		
		<div class="row">
			<div class="col-12">
				<?php if ($total_pages > 1) { ?>
					<ul class="property-listings-page__pagination">
						<?php for ($i = 1; $i <= $total_pages; $i++) { ?>			
							<?php if ($p == $i) { ?>
								<li class="property-listings-page__pagination-item active"><a href="<?= $query;?>&p=<?php echo $i; ?>"><?php echo $i; ?></a></li>
							<?php } else { ?>
								<li class="property-listings-page__pagination-item"><a href="<?= $query;?>&p=<?php echo $i; ?>"><?php echo $i; ?></a></li>
							<?php } ?>			
						 <?php } ?> 
					</ul>
				<?php } ?>
			</div>
		</div>
		
	</div>
</section>