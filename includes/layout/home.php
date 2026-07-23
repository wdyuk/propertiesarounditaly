<main>
	<?php
        $slider_site_id = isset($site['id']) ? (int) $site['id'] : 0;
        $slider_visibility_where = $slider_site_id > 0 ? build_visible_homepage_slider_where($slider_site_id) : '1=0';
        $slides = table_fetch_rows('homepage_slider', 'status = 1 AND ' . $slider_visibility_where, 'position ASC');
    ?>
	<div class="banner">
	  <div class="img-slider main-slider">
	    <?php foreach ($slides as $slide) {
	        $desktop_banner = get_image('homepage_slider/'.$slide['id'].'-desktop-slide');
	        $mobile_banner = get_image('homepage_slider/'.$slide['id'].'-mobile-slide');?>
	        <div class="hero-banner position-relative">
	        	<?php if (strlen($slide['link_url'])) { ?>
	        		<a href="<?= $slide['link_url']; ?>">
	        	<?php } ?>
		            <img src="<?= $desktop_banner;?>" class="d-none d-sm-block img-fluid" />
		            <img src="<?= $mobile_banner;?>" class="d-block d-sm-none img-fluid" />
		            <div class="container position-relative">
			            <div class="hero-caption">
			            	<h2><?= $slide['heading_line_1'];?></h2>
			            </div>
			        </div>
			    <?php if (strlen($slide['link_url'])) { ?>
	        		</a>
	        	<?php } ?>
	        </div>
	    <?php } ?>

	  </div>
	</div>
	
	<?php include('includes/template-parts/pages/home-page/featured-properties.php'); ?>
	
</main>
