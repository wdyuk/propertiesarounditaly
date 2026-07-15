<section class="article">
	<div class="container">
		<div class="row">
			<div class="col">
				<article class="article__content">
					<div class="row">
						<div class="col-12 col-md-8">
							<?= $pageData['content'];?>
							<?= $pageData['content_2'];?>
							<?= $pageData['content_3'];?>
							<?= $pageData['content_4'];?>
							<?= $pageData['content_5'];?>
						</div>
						<div class="col-12 col-md-4">
							<div class="col-12 col-sm-12 g-0 order-sm-1">
								<div class="contact-us mx-xxl-5 mt-3 text-center py-5 px-2">
									<h3 class="text-left">CONTACT US TODAY</h3>
									<h3 class="contact-us_number"><a href="tel:<?=$site_settings['mobile_contact_number_html'];?>" class=""><?= $site_settings['mobile_contact_number'];?></a></h3>
									<p class="contact-us_email"><a href="mailto:<?=$site_settings['contact_mail'];?>"><?= $site_settings['contact_mail'];?></a></p>
								</div>
							</div>
						
						
						</div>
					</div>
				</article>
			</div>
		</div>
	</div>
</section>