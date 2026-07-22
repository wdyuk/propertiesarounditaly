<footer class="footer">

	<section class="footer__section-2">
		<div class="container footer-border-bottom py-5 pb-4">
			<div class="row px-md-4">
				<div class="col-md-8 col-12 pt-md-1">
					<p>PHONE: <a href="tel:<?= $site_settings['mobile_contact_number_html']; ?>"><?= $site_settings['mobile_contact_number']; ?></a> | <a href="tel:<?= $site_settings['contact_number_html']; ?>"><?= $site_settings['contact_number']; ?></a></p>
					<p>EMAIL: <a href="mailto:<?= $site_settings['contact_mail']; ?>"><?= $site_settings['contact_mail']; ?></a></p>
					<p class="small-text">We do not, and will not, give or sell your email address to any other organization. We personally reply to every message, generally within 24hrs. Occasionally email does get lost in transit so if you don’t hear from us please let us know.</p>

				</div>
				<div class="col-md-4 col-12 pt-4 pt-md-0 ps-1 ps-sm-0">
					<?php include('includes/template-parts/global/sm-links.php'); ?>
					<?php if (isset($site['domain']) && strpos($site['domain'], 'propertiesforsaleinabruzzo') !== false) { ?>
						<p class="mt-3 mb-0 footer__faq-link">
							<a href="/faqs">FAQs</a>
						</p>
					<?php } ?>
				</div>
			</div>
		</div>
	</section>
	<section class="footer__section-2 text-left">
		<div class="container">
			<div class="row px-md-4">
				<div class="col-12">
					<p class="small-text">Copyright &copy;<?= date('Y'); ?> <?= $site_settings['address'];?> - <?= $site_settings['company_number'] ;?></p>
				</div>
			</div>
		</div>
	</section>
</footer>
