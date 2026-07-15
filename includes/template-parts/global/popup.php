<div class='popup'>
	<div class='cnt223'>
		<h2 style="color: #756846;">Sign Up to Our Newsletter</h2>
		<!-- <p>New property alerts are sent to your requested email address at your selected frequency once we publish a new property or a price change takes place.</p> -->
		<?php if (!empty($newsletter_success_messages)) {
			echo '<div class="col-xs-12 normal-text no-pad-lr" style="padding-right: 15px;"><div class="alert alert-success">';
			foreach ($newsletter_success_messages as $message) {
				echo '<p>'.$message.'</p>';
			};
			echo '</div></div>';
		};?>
    	<?php if (!empty($newsletter_error_messages)) {
            echo '<div class="col-xs-12 normal-text no-pad-lr" style="padding-right: 15px;"><div class="alert alert-danger">';
            foreach ($newsletter_error_messages as $message) {
                echo '<p>'.$message.'</p>';
            };
            echo '</div></div>';
        }; ?>
		<div class="form">
			<form method="POST" enctype="multipart/form-data" class="form--type-contact">
				<div class="form__item form__item--type-text width50">
					<input type="text" id="first_name" name="first_name" placeholder="First Name">
				</div>
				<div class="form__item form__item--type-text width50">
					<input type="text" id="last_name" name="last_name" placeholder="Last Name">
				</div>
				<div class="form__item form__item--type-text">
					<input type="text" id="email" name="email_address" placeholder="Email Address">
				</div>
				<div class="">
					<div class="form-check form-check-inline">
					  	<label class="form-check-label" for="inlineCheckbox1">Type of Property Alerts:</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="checkbox" name="property_types[]" value="sales">
					  	<label class="form-check-label" for="inlineCheckbox1">Sales</label>
					</div>
					<div class="form-check form-check-inline">
					  	<input class="form-check-input" type="checkbox" name="property_types[]" value="lettings">
					  	<label class="form-check-label">Lettings</label>
					</div>
				</div>
				<div class="col-md-12">
					<div class="g-recaptcha col-xs-12 no-pad-lr" style="margin-bottom: 15px;" data-sitekey="<?= GOOGLE_RECAPTCHA_SITE; ?>"></div>
				</div>
				<div class="form__item form__item--type-submit">
					<input type="submit" value="Submit" name="newsletter-signup">
				</div>
			</form>
		</div>
		<br/><br/>
		<p><a href='' class='close'>Close</a></p>
	</div>
</div>