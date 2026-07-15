<?php if($rewriteData['table_name'] == 'news'){
	$parent = table_fetch_row('page','id = 33');
}
if($rewriteData['table_name'] == 'vacancies'){
	$parent = table_fetch_row('page','id = 35');
}
if($rewriteData['table_name'] == 'vebra_properties'){
	$parent = table_fetch_row('page','id = 49');
}
if($rewriteData['table_name'] == 'teams'){
	$parent = table_fetch_row('page','id = 100');
	$parentof = table_fetch_row('page','id = '.$parent['parent_id']);
	$style = 'style="background-color:white;"';
}
?>
<section class="breadcrumbs" <?php if(!empty($style)){echo $style;}?>>
	<div class="container">
		<div class="row">
			<div class="col">
				<span class="breadcrumbs__item"><a href="/">Home</a></span> > 
				<?php if (isset($parentof)){?>
					<span class="breadcrumbs__item"><a href="<?= $parentof['url'];?>"><?= $parentof['page_title'];?></a></span> >
				<?php } ?>
				<span class="breadcrumbs__item"><a href="<?= $parent['url'];?>"><?= $parent['page_title'];?></a></span> > <span class="breadcrumbs__item"><?= $pageData['page_title'];?></span>
			</div>
		</div>
	</div>
</section>