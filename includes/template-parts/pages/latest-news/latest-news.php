<?php 
$blog_visibility_where = build_visible_blog_where($site['id']);
$latest_news = table_fetch_row('blog','status=1 AND ' . $blog_visibility_where,'publish_date DESC');
$current_year = $latest_news !== false ? date('Y',strtotime($latest_news['publish_date'])) : date('Y');

$today = date('Y-m-d H:i:s');
$p = isset($_GET['p']) && is_numeric($_GET['p']) ? intval($_GET['p']) : 1;
$limit = 6;
$start = ($p - 1) * $limit;
//$total_rows = table_row_count('blog', 'publish_date <="'. $today .'" AND status=1');
$query = '';
if (isset($_GET['year'])) {
	$current_year = (int) $_GET['year'];
	$query = 'year='.$current_year.'&';
}
$stories = table_fetch_rows('blog','publish_date >= "'.$current_year.'-01-01" AND publish_date <= "'.$current_year.'-12-31" and status = 1 AND ' . $blog_visibility_where,'publish_date DESC', $start, $limit);

$total_rows = table_row_count('blog', 'publish_date >= "'.$current_year.'-01-01" AND publish_date <= "'.$current_year.'-12-31" and status = 1 AND ' . $blog_visibility_where);
$total_pages = ceil($total_rows / $limit);
//$stories = table_fetch_rows('blog', 'publish_date <="'. $today .'" AND status=1', 'publish_date DESC', $start, $limit);
//Create dropdown
	$all_news = table_fetch_rows('blog','status=1 AND ' . $blog_visibility_where,'id ASC');

	$news_years = [];
	foreach($all_news as $all_news) {
		$news_years[] = date('Y',strtotime($all_news['publish_date']));
	}
	$news_years = array_unique($news_years);
	rsort($news_years);
?>
<section class="latest-news">
	<div class="container">
		<div class="row">
			<div class="col p-1 mb-3">
				<div class="select-filter-wrapper mb-2 mb-md-0">
					<form method="GET" id="news-archive-form" class="form-inline">
						<select name="year" id="new_archive" class="archive">
							<?php foreach($news_years as $newsyear) { ?>
								<option value="<?= $newsyear; ?>" <?php if ($newsyear == $current_year) { echo 'selected="selected"'; } ; ?>><?= $newsyear; ?></option>
							<?php } ?>
						</select>
					</form>
				</div>
<!-- 				
					<select name="archive" id="archive" class="archive">
						<option value="archive">Archive</option>
						<option value="archive">Archive</option>
						<option value="archive">Archive</option>
					</select>
				</div>
				<div class="select-filter-wrapper">
					<select name="category" id="category" class="category">
						<option value="category">Category</option>
						<option value="category">Category</option>
						<option value="category">Category</option>
					</select>
				</div> -->
			</div>
			<div class="col p-1 text-right">
				<?php if ($total_pages > 1) { ?>
					<ul class="latest-news__pagination">
						<?php if ($p > 1) { ?>
							<li class="latest-news__pagination-item"><a class="page-link" rel="prev" href="/news?<?= $query;?>p=<?php echo ($p - 1); ?>"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
						<?php } ?>	
						<?php for ($i = 1; $i <= $total_pages; $i++) { ?>			
							<?php if ($p == $i) { ?>
								<li class="latest-news__pagination-item active"><a href="/news?<?= $query;?>p=<?php echo $i; ?>"><?php echo $i; ?></a></li>
							<?php } else { ?>
								<li class="latest-news__pagination-item"><a href="/news?<?= $query;?>p=<?php echo $i; ?>"><?php echo $i; ?></a></li>
							<?php } ?>			
						 <?php } ?>		 
						 <?php if (($p + 1) <= $total_pages) { ?>
							<li class="latest-news__pagination-item"><a class="page-link" rel="next" href="/news?<?= $query;?>p=<?php echo ($p + 1); ?>"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
						<?php } ?>		 
					</ul>
				<?php } ?>
			</div>
		</div>
		<div class="row">
			<?php if(count($stories)){
				foreach($stories as $story){
					$news_image = get_image('blog/' . $story['id'] . '-medium');
					if (strlen($news_image) > 0){
						$class = 'latest-news__post--img';
						$class2 = 'latest-news__post-overlay--img';
						$style = 'style="background-image:url('.$news_image.');"';
					}
					else{
						$class = 'latest-news__post-overlay--no-img';
						$class2 = 'latest-news__post-overlay--no-img';
						$style = '';
					}
					?>
					<div class="col-md-6 p-1">
						<div class="latest-news__post <?= $class;?>" <?= $style;?>>
							<div class="latest-news__post-overlay <?= $class2;?>">
								<div class="latest-news__post-content">
									<div class="latest-news__post-meta">
										<span class="latest-news__post-meta-date"><?= date('d F Y',strtotime($story['publish_date']));?></span>
									</div>
									<div class="title">
										<h2 class="latest-news__post-title"><?= substr(strip_tags($story['title']),0,75);?>...</h2>
									</div>
									<div class="text">
										<p class="latest-news__post-snippet"><?= substr(strip_tags($story['teaser']),0,150);?>...</p>
									</div>
									<p class="button simple blue"><a href="<?= getRewriteUrl('blog',$story['id']);?>">Read More</a></p>
								</div>
							</div>
						</div>
					</div>
				<?php }
			}?>
		</div>
		<div class="row">
			<div class="col-12 text-right my-5">
				<?php if ($total_pages > 1) { ?>
					<ul class="latest-news__pagination">
 						<?php if ($p > 1) { ?>
							<li class="latest-news__pagination-item"><a class="page-link" rel="prev" href="/news?<?= $query;?>p=<?php echo ($p - 1); ?>"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
						<?php } ?>	
						<?php for ($i = 1; $i <= $total_pages; $i++) { ?>			
							<?php if ($p == $i) { ?>
								<li class="latest-news__pagination-item active"><a href="/news?<?= $query;?>p=<?php echo $i; ?>"><?php echo $i; ?></a></li>
							<?php } else { ?>
								<li class="latest-news__pagination-item"><a href="/news?<?= $query;?>p=<?php echo $i; ?>"><?php echo $i; ?></a></li>
							<?php } ?>			
						 <?php } ?>		 
						<?php if (($p + 1) <= $total_pages) { ?>
							<li class="latest-news__pagination-item"><a class="page-link" rel="next" href="/news?<?= $query;?>p=<?php echo ($p + 1); ?>"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
						<?php } ?>	 
					</ul>
				<?php } ?>
			</div>
		</div>
		<div class="row">
			<div class="col-12 my-4">
				<h3>News Archives by Year</h3>
				<?php foreach($news_years as $year) { ?>
					<a class="mx-2 mb-4 d-inline-block" href="/news?year=<?= $year; ?>"><?= $year; ?></a>
				<?php } ?>
		</div>
	</div>
</section>
