<section class="property-listing-page__article">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-9">
				<div class="row g-0 mb-4 order-sm-1">
				
					
					<div class="row g-0 property-listing_content order-sm-2">
						<?= $pageData['content_1'];?>
					</div>
				</div>
			</div>
			<div class="col-sm-12 col-md-3">
				<div class="row order-sm-3">
					<!-- Sidebar -->
					<div class="col-12 col-sm-12 g-0 order-sm-1">
						<div class="contact-us mx-xxl-5 mt-3 text-center py-5 px-2">
							<h3 class="text-left">CONTACT US TODAY</h3>
							<h3 class="contact-us_number"><a href="tel:<?=$site_settings['mobile_contact_number_html'];?>" class=""><?= $site_settings['mobile_contact_number'];?></a></h3>
							<p class="contact-us_email"><a href="mailto:<?=$site_settings['contact_mail'];?>"><?= $site_settings['contact_mail'];?></a></p>
						</div>
					</div>
					<?php if (strlen($pageData['amenities']) > 0) { ?>
						<div class="col-12 col-sm-12 g-0 order-sm-2">
							<div class="bullet-points mx-xxl-5 mb-3 py-4 mt-4 px-4">
								<h4 class="text-left mb-3 fw-400">AMENITIES</h4>
								<?= $pageData['amenities']; ?>
							</div>
						</div>
					<?php } ?>
					
					
				</div>
			</div>
			<div class="col-12">
				<div class="row g-0 property-listing_content order-sm-2">
					<?= $pageData['description'];?>
				</div>
			</div>

		</div>
	</div>
</section>