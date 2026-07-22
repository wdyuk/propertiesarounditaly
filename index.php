<?php include("includes/initialize.php"); ?>
<!DOCTYPE html>
<html lang="en-GB">
    <?php include("includes/template-parts/global/head.php"); 
    	if($rewriteData['table_id'] == 22 || $rewriteData['table_id'] == 48 || $rewriteData['table_id'] == 53 || $rewriteData['table_id'] == 54 || $rewriteData['table_id'] == 55 && $rewriteData['table_name'] == 'page'){
    		$bodyclass = 'faqs-page';
    	}
    	else{
    		$bodyclass = 'home-page';
    	}
    ?>
    <body class="<?= $bodyclass;?>"><!--class="home-page"-->
    	<?php include('includes/template-parts/global/nav-drawer.php'); ?>
		<?php include("includes/template-parts/global/header.php"); ?>
		<?php include('includes/template-parts/global/newsletter-signup.php'); ?>
		<?php 
		$layouturl = explode('/',$rewriteData['url']);
		$countpieces = (count($layouturl) - 1);
		$layoutfile = '/'.str_replace('/','-',$layouturl[$countpieces]).'.php';
		if ($rewriteData['url'] == '/') {
			include('includes/layout/home.php');
		}
	
		elseif ($rewriteData['table_name'] == 'properties'){
			include('includes/layout/property.php');
		}

		elseif ($rewriteData['table_name'] == 'blog'){
			include('includes/layout/latest-news-single-article.php');
		}		
		elseif ($rewriteData['table_name'] == 'page' && in_array((int) $rewriteData['table_id'], array(35, 36, 37, 38, 39), true)) {
			include('includes/layout/page-three-image-story.php');
		}
		elseif (file_exists('includes/layout' . $layoutfile)) {
			include('includes/layout' . $layoutfile);
		}
		else {
			include('includes/layout/default.php');
		}
		//include('includes/template-parts/global/popup.php');
		?>
		<?php include('includes/template-parts/global/footer.php'); ?>
		<?php include('includes/template-parts/global/scripts.php'); ?>
	</body>
</html>
