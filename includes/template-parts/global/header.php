<header class="header">
	<div class="header__main">
		<div class="container">
			<div class="row align-items-start align-items-center">
				<div class="col-8 col-md-12 col-lg-5">
                    <div class="header__logo-container text-start text-md-center text-lg-start px-2">
						<a href="/"><img src="<?= $site_logo; ?>" alt="<?= $settings['website_name']; ?>" title class="img-fluid"></a>
					</div>
				</div>
				<div class="col-4 d-md-none">

					<div class="menu-mobile d-md-none d-flex justify-content-end text-maroon">
						<div class="text-center me-4">
                          <a href="tel: <?= $site_settings['mobile_contact_number_html']; ?>"><i class="fas fa-phone"></i></a>
                        </div>
                        <div class="menu-click text-center me-2">
                            <i class="fas fa-bars"></i>
                
                        </div>
                    </div>
	            </div>
				<div class="col-6 col-md-12 col-lg-7 position-static align-items-center">
					<div class="row">
						<div class="col-12">
							<div class="d-none d-lg-block pt-1 text-end w-100">
								<a class="top-phone-number" href="tel:<?= $site_settings['mobile_contact_number_html']; ?>"><?= $site_settings['mobile_contact_number']; ?></a><span class="top-phone-number px-3">|</span><a class="pe-3 top-phone-number" href="tel:<?= $site_settings['contact_number_html']; ?>"><?= $site_settings['contact_number']; ?></a>
							</div>
		                    <!-- <div class="header__nav header__nav--mobile">
		                        <div class="menu-mobile d-none d-sm-block">
			                        <div class="menu-click text-center">
			                            <i class="fas fa-bars"></i>
			                            <p class="menu">MENU</p>
			                        </div>
			                    </div>
		                    </div> -->
		                </div>
		                <div class="col-12">
		                    <div class="header__nav header__nav--desktop w-100">
		                    	<?php include('includes/template-parts/global/main-menu.php'); ?>
		                    </div>
		                </div>
		            </div>
                </div>
			</div>
		</div>
	</div>
</header>
