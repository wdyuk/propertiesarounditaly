<?php $parents = table_fetch_rows('page', 'status = 1 AND parent_id = -1 AND top_nav = 1', 'position ASC');
foreach ($parents as $key => $parent) {
	$child_parents = table_fetch_rows('page', 'status = 1 AND parent_id = '.$parent['id'].' AND top_nav = 1', 'position ASC');

	if(!empty($child_parents)){
		$parent['childs'] = 1;
	}
	else{
		$parent['childs'] = 0;
	}
	$catsarray = array();
	$child_pages = array();
	foreach ($child_parents as $child){
		if($child['page_category'] > 0){
			if(!in_array($child['page_category'], $catsarray)){
				$catsarray[] = $child['page_category'];
			}
		}
		$child_pages[] = $child['id'];
	}
	if(!empty($catsarray)){
		$parent['categories'] = $catsarray;
		$parent['childpages'] = $child_pages;
		$parents[$key] = $parent;
	}
	$parents[$key] = $parent;
}
$sold_link = table_fetch_row('page','id = 97 AND status = 1');
?>

<nav class="main-menu d-none d-md-block">
	<ul class="main-menu__list">
		<?php foreach ($parents as $parent) {
			?>
				<li class="main-menu__item">
					<a class="main-menu__link" href="<?= getRewriteUrl('page',$parent['id']); ?>"><?= $parent['menu_title'];?></a>
				</li>
									
		<?php } ?>
	</ul>
</nav>
<nav class="main-menu d-block d-md-none">
	<ul class="main-menu__list">
		<?php foreach ($parents as $parent) {
			?>
			<li class="main-menu__item main-menu__item--has-child"><a href="<?= getRewriteUrl('page', $parent['id']); ?>" class="main-menu__link child-mobile-click"><?= $parent['menu_title'];?></a>
				<ul class="main-menu__child-list-main-container">
					<li class="main-menu__child-list-inner-container">
						<div class="container">
							<div class="row justify-content-center">
								<?php if(isset($parent['categories'])){ ?>
									<div class="col-md-10">
										<?php foreach ($parent['categories'] as $cat) {
											$heading = table_fetch_row('page_categories','id ='.$cat);
											$child_parents = table_fetch_rows('page', 'status = 1 AND parent_id = '.$parent['id'].' AND top_nav = 1 AND page_category = '.$cat.'', 'position ASC');?>
											<ul class="main-menu__child-list">
												<li class="main-menu__child-item main-menu__menu-title"><?= $heading['name'];?></li>
												<?php foreach ($child_parents as $child){
													if($child['id'] == 49){
														$child['menu_title'] = 'View All '.$child['menu_title'];
													}
													if($child['id'] == 52){
														$child['menu_title'] = 'View All '.$child['menu_title'];
													}
												 ?>
													<li class="main-menu__child-item"><a class="main-menu__link" href="<?= getRewriteUrl('page',$child['id']);?>"><?= $child['menu_title']; ?></a></li>
												<?php }?>
											</ul>
										<?php } ?>
									</div>
								<?php } 
								else {?>
									<div class="col-md-10 text-center">
										<ul class="main-menu__child-list">
											<?php $child_parents = table_fetch_rows('page', 'status = 1 AND parent_id = '.$parent['id'].' AND top_nav = 1', 'position ASC');
											foreach ($child_parents as $child){ ?>
												<li class="main-menu__child-item"><a class="main-menu__link" href="<?= getRewriteUrl('page',$child['id']);?>"><?= $child['menu_title']; ?></a></li>
											<?php } ?>
										</ul>
									</div>	
								<?php } ?>
							</div>
						</div>
					</li>
				</ul>
			</li>						
		<?php } ?>
	</ul>
</nav>