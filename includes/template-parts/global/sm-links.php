<div class="sm-links d-block">
	<?php if (strlen($site_settings['linkedin_link'])) { ?><div class="sm-links__link"><a href="<?= $settings['linkedin_link']; ?>" target="_blank"><i class="fab fa-lg fa-linkedin"></i></a></div><?php } ?>
	<?php if (strlen($site_settings['facebook_link'])) { ?><div class="sm-links__link"><a href="<?= $settings['facebook_link']; ?>" target="_blank"><i class="fab fa-lg fa-facebook-square"></i></a></div><?php } ?>
	<?php if (strlen($site_settings['twitter_link'])) { ?><div class="sm-links__link"><a href="<?= $settings['twitter_link']; ?>" target="_blank"><i class="fab fa-lg fa-twitter-square"></i></a></div><?php } ?>
	<?php if (strlen($site_settings['google_link'])) { ?><div class="sm-links__link"><a href="<?= $settings['google_link']; ?>" target="_blank"><i class="fab fa-lg fa-brands fa-square-google-plus"></i></a></div><?php } ?>
	<?php if (strlen($site_settings['instagram_link'])) { ?><div class="sm-links__link"><a href="<?= $settings['instagram_link']; ?>" target="_blank"><i class="fab fa-lg fa-instagram"></i></a></div><?php } ?>
	<!-- <button type="button" class="pink-button" onclick="myFunction()">Sign Up</button> -->
</div>
