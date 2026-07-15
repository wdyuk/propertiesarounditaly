<head>
	<?php if (isset($_GET['p']) && $_GET['p'] > 1) {
		if (strlen($pageData['meta_title'] == 0)) {
			$pageData['meta_title'] == $pageData['title'];
		}
		$pageData['title'].= " Page: ".(int) $_GET['p'];
		$pageData['meta_title'].= " Page: ".(int) $_GET['p'];
		$pageData['meta_description'].= " Page: ".(int) $_GET['p'];
	} ?>
	<?php if (isset($_GET['year']) && $_GET['year'] > 1) {
		if (strlen($pageData['meta_title'] == 0)) {
			$pageData['meta_title'] == $pageData['title'];
		}
		$pageData['title'].= " ".(int) $_GET['year'];
		$pageData['meta_title'].= " ".(int) $_GET['year'];
		$pageData['meta_description'].= " in ".(int) $_GET['year'];
	} ?>
	<title><?php echo (isset($pageData['meta_title']) ? $pageData['meta_title'] : $pageData['title']); ?> | Properties around Italy</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="description" content="<?= $pageData['meta_description']; ?>">
	<meta property="og:title" content="<?= $pageData['meta_title']; ?>" />
	<meta property="og:description" content="<?= $pageData['meta_description']; ?>" />
	<?php if (isset($pageData['meta_image'])) { ?>
	<meta property="og:image" content="<?= $pageData['meta_image']; ?>" />
	<meta name="twitter:card" content="summary_large_image">
	<?php } ?>
	<meta property="og:url" content="<?= BASE_URL; ?><?= ltrim($rewriteData['url'],'/') ; ?>" />
	  <?php if ($rewriteData['url'] != '/about/latest-news' || isset($_GET['p']) && $_GET['p'] == 1) { ?>
		 <link rel="canonical" href="<?= BASE_URL; ?><?= ltrim($rewriteData['url'],'/') ; ?>" />
	  <?php } ?>
	<meta name="format-detection" content="telephone=yes">
	<meta name="author" content="Properties Around Italy">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<!-- <link rel="stylesheet" href="/dist/bootstrap.css?v1.15"> -->

	<!-- <link rel="preconnect" href="https://fonts.gstatic.com"> 
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,700;1,400;1,700&display=swap" rel="stylesheet"> -->
	<link rel="stylesheet" href="/dist/fonts.css?v1.15">
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
	<!-- <link rel="stylesheet" href="/dist/style.css?v1.17"> -->
	<link rel="stylesheet" href="/assets/css/style.css?v1.23">
	<!-- <link rel="stylesheet" href="/dist/tom.css?v1.2"> -->
	<link rel="stylesheet" href="/dist/popup.css?v.1">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://kit.fontawesome.com/3e38a85cdb.js" crossorigin="anonymous"></script>
	<link rel="apple-touch-icon-precomposed" sizes="57x57" href="/assets/img/favicomatic/apple-touch-icon-57x57.png" />
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/assets/img/favicomatic/apple-touch-icon-114x114.png" />
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/assets/img/favicomatic/apple-touch-icon-72x72.png" />
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/assets/img/favicomatic/apple-touch-icon-144x144.png" />
	<link rel="apple-touch-icon-precomposed" sizes="60x60" href="/assets/img/favicomatic/apple-touch-icon-60x60.png" />
	<link rel="apple-touch-icon-precomposed" sizes="120x120" href="/assets/img/favicomatic/apple-touch-icon-120x120.png" />
	<link rel="apple-touch-icon-precomposed" sizes="76x76" href="/assets/img/favicomatic/apple-touch-icon-76x76.png" />
	<link rel="apple-touch-icon-precomposed" sizes="152x152" href="/assets/img/favicomatic/apple-touch-icon-152x152.png" />
	<link rel="icon" type="image/png" href="/assets/img/favicomatic/favicon-196x196.png" sizes="196x196" />
	<link rel="icon" type="image/png" href="/assets/img/favicomatic/favicon-96x96.png" sizes="96x96" />
	<link rel="icon" type="image/png" href="/assets/img/favicomatic/favicon-32x32.png" sizes="32x32" />
	<link rel="icon" type="image/png" href="/assets/img/favicomatic/favicon-16x16.png" sizes="16x16" />
	<link rel="icon" type="image/png" href="/assets/img/favicomatic/favicon-128.png" sizes="128x128" />
	<meta name="application-name" content="&nbsp;"/>
	<meta name="msapplication-TileColor" content="#FFFFFF" />
	<meta name="msapplication-TileImage" content="/assets/img/favicomatic/mstile-144x144.png" />
	<meta name="msapplication-square70x70logo" content="/assets/img/favicomatic/mstile-70x70.png" />
	<meta name="msapplication-square150x150logo" content="/assets/img/favicomatic/mstile-150x150.png" />
	<meta name="msapplication-wide310x150logo" content="/assets/img/favicomatic/mstile-310x150.png" />
	<meta name="msapplication-square310x310logo" content="/assets/img/favicomatic/mstile-310x310.png" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;1,300;1,400;1,500&display=swap" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.4.2/jquery.fancybox.min.css" rel="stylesheet">
	<script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl=en"></script>

</head>