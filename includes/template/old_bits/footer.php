<!-- footer -->
<footer>
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-sm-3">
				<div class="footer_logo">
					<a href="/"><img src="<?= $footer_logo; ?>" alt="<?= $settings['website_name']; ?>"></a>
				</div>
			</div>
			<div class="col-lg-9 col-sm-9">
				<div class="footer_right">
					<div class="footer_links">
						<div class="social_links">
							<a href="<?= $settings['twitter_link']; ?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
							<a href="<?= $settings['linkedin_link']; ?>" target="_blank"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a>
						</div>	

						<?php
							$parents = table_fetch_rows('page', 'status = 1 AND footer_nav = 1', 'position ASC');
							foreach($parents as $parent)
							{
						?>
								<a href="<?= $parent['url']; ?>"><?= $parent['menu_title']; ?></a> 
						<?php
							}
						?>
					</div>
					<div class="copyright">
						<p>© Copyright <?= $settings['website_name']; ?> <?php echo(date('Y')); ?>
						| Company Number: <?= $settings['company_number']; ?>
					</div>
				</p>	
			</div>
		</div>
	</div>
</footer>

	<script src="/includes/layout/js/jquery.js"></script>
	<script src="/includes/layout/js/popper.js"></script>
	<script src="/includes/layout/js/bootstrap.min.js"></script>
	<script src="/includes/layout/js/owl.carousel.min.js"></script>
	<script src="/includes/layout/js/custom.js"></script>
	<!-- <script src="/includes/layout/js/filter.js"></script> -->
</body>