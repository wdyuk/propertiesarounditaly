<!-- Accreditations Slider -->
<div class="Accreditations_slider">
	<div class="container">
		<div class="main_title">
			<h1>accreditations</h1>
		</div>
		<div class="owl-carousel owl-theme" id="accreditations-slider">
		<?php
			$accreditations = table_fetch_rows('accreditations', 'status=1');
			foreach($accreditations as $accreditation){
				$accreditationImage = get_image('accreditations/' . $accreditation['id'] . '-accreditation');
				if(strlen($accreditationImage) > 0){
		?>
			<div class="item">
		    	<div class="accreditations-logo">
		    		<img src="<?= $accreditationImage; ?>" alt="<?= $accreditation['img_alt']; ?>">
		    	</div>
		    </div>
		<?php
				}
			}
		?>
	    </div>
	</div>
</div>	