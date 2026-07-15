<head>
	<meta charset="utf-8" />
	<title><?php echo $pageData['title']; ?> | <?= SITE_NAME; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta name="description" content="<?= $pageData['meta_description']; ?>">
	<meta property="og:title" content="<?= $pageData['page_title']; ?>" />
	<meta property="og:description" content="<?= $pageData['meta_description']; ?>" />
	<?php if (isset($pageData['meta_image'])) { ?>
	<meta property="og:image" content="<?= $pageData['meta_image']; ?>" />
	<meta name="twitter:card" content="summary_large_image">
	<?php } ?>
	<meta property="og:url" content="<?= BASE_URL; ?><?= ltrim($rewriteData['url'],'/') ; ?>" />
	<link rel="canonical" href="<?= BASE_URL; ?><?= ltrim($rewriteData['url'],'/') ; ?>" />
	
	<link rel="stylesheet" type="text/css" href="/includes/layout/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/includes/layout/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="/includes/layout/css/owl.carousel.min.css">
	<link rel="stylesheet" type="text/css" href="/includes/layout/css/fonts.css">
	<link rel="stylesheet" type="text/css" href="/includes/layout/css/style.css">
    <script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl=en"></script>
	
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-753HS3LCTL"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());
	  gtag('config', 'G-753HS3LCTL');
	</script>
</head>