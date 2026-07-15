<!-- <body class="basic-page"> -->

	
<?php $desktop_banner = get_image('page/'.$pageData['id'].'-header-image');
	   $mobile_banner = get_image('page/'.$pageData['id'].'-mobile-header-image');
	   if (strlen($desktop_banner)) { ?>
			<div class="container">
				<div class="banner">
		
			    
			        
			        <div class="hero-banner hero-banner-inner position-relative">
			            <img src="<?= $desktop_banner;?>" class="d-none d-sm-block w-100" />
			            <img src="<?= $mobile_banner;?>" class="d-block d-sm-none w-100" />
			           
				            <div class="hero-caption-inner">
				            	<h1><?= $pageData['h1_title'] ;?></h1>
				            </div>
				  
			        </div>
			   

			 </div>
			</div>
		<?php } else { 

			include('includes/template-parts/sections/basic-page-title.php'); 

		} ?>
    <main>
		<?php include('includes/template-parts/sections/article/article-two-column-buttons.php'); ?>
	</main>
<!-- </body> -->
