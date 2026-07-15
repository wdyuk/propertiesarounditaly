<div id="exTab1" class="container">
    
	<section class="property-listing-page__details pt-3">
		<div class="container">
			<div class="row">
			   
	    			
				<div class="property-listing-page__slider  property-listing-page__slider--gallery">
					<?php foreach ($images as $image) {
						?>
						<div class="text-center">
							<a data-fancybox="property_id_<?= $pageData['id']; ?>" href="<?= $image; ?>"><img src="<?= $image;?>" class="img-fluid"  alt="<?= $pageData['display_address'];?>"></a>
						
						</div>
					<?php }?>
				</div>

			</div>
		</div>
	</section>
</div>