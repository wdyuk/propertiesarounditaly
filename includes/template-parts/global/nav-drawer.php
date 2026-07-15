<?php 
	$settings = table_fetch_row('site_settings','status=1');
	$logo = get_image('settings/'.$settings['id'] .'-image');
	if(strlen($logo) == 0){
	   $logo = '/assets/img/logo.png';
	}
?>
<section id="menu-container" class="nav-drawer">
	<div class="nav-drawer__layer-1">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="nav-drawer__menu-container">
						<div class="nav-drawer__header">
							<div class="nav-drawer__logo-container">
								<a href="/"><img src="/assets/img/logo_reverse.png" alt="<?= $settings['website_name']; ?>" title class="img-fluid"></a>
							</div>
							<div class="close-menu nav-drawer__close-menu">
								<span class="menu-click"><i class="fas fa-times"></i></span>
							</div>
						</div>
						<div class="nav-drawer__body">
							<?php include('includes/template-parts/global/main-menu.php'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>