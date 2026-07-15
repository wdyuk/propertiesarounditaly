<!-- News Page -->
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="breadcrumbs">
				<ul>
					<?php
						$crumbs = explode("/",$_SERVER["REQUEST_URI"]);
						foreach($crumbs as $crumb){
							$crumb_titles = table_fetch_rows('page', 'status = 1 AND url = "/'. $crumb .'"', '');
							foreach($crumb_titles as $crumb_title){
								if($crumb_title['url'] != $pageData['url']){
					?>
						<li><a href="<?= $crumb_title['url']; ?>"><?= $crumb_title['page_title']; ?> /</a></li>
					<?php
								}
							}
						}
					?>
					<li><a href="<?= $pageData['url']; ?>" class="active"><?= $pageData['page_title']; ?></a></li>
				</ul>	
			</div>	
		</div>
	</div>
</div>
	
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="main_title">
				<h1><?= $pageData['h1_title']; ?></h1>
			</div>	
			<div class="success_message">
			<?php
				if (isset($_POST['subscribe'])) 
				{
					$fields = array('name', 'email', 'description', 'status', 'created_at', 'updated_at');
					
					$table_id = table_insert('subscribers', $fields, $_POST);
					$messages[] = 'Thanks for subscribing to our newsletter.';
					show_messages($messages);
				}
			?>
			</div>
		</div>		
	</div>
</div>

<div class="news_page">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<div class="row">
				<?php
					$today = date('Y-m-d H:i:s');
					$p = isset($_GET['p']) && is_numeric($_GET['p']) ? intval($_GET['p']) : 1;
					$limit = 6;
					$start = ($p - 1) * $limit;

					$total_rows = table_row_count('news', 'published_at <="'. $today .'" AND status=1');
					$total_pages = ceil($total_rows / $limit);
					$newses = table_fetch_rows('news', 'published_at <="'. $today .'" AND status=1', 'published_at DESC', $start, $limit);
					if(count($newses)){
						foreach($newses as $news){
							$string = $news['short_description'];	
							$words  = array_slice(explode(' ', $string), 0, 30);
							$short_description = implode(' ', $words);
							$news_image = get_image('news/' . $news['id'] . '-image');
				?>
					<div class="col-lg-6 col-sm-12 bottom_margin">
						<div class="news_list">
							<div class="news_item">
								<a class="news-btn" href="<?= $news['url']; ?>">
								<?php	
									if (strlen($news_image) > 0){
								?>
									<div class="news-image" style="background-image: url('<?= $news_image; ?>');"></div>
								<?php
									}
								?>
									<div class="news-content">
										<p class="news-title"><?= $news['title']; ?></p>
										<div class="news-desc"><?= $news['short_description']; ?></div>
									</div>
								</a>
							</div>	
						</div>
					</div>
				<?php
						}
					}
				?>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="pagination">										
							<?php if ($total_pages > 1) { ?>
								<ul>	
									<?php if ($p > 1) { ?>
										<li class="page-item"><a class="page-link" href="?p=<?php echo ($p - 1); ?>"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
									<?php } ?>	
									<?php for ($i = 1; $i <= $total_pages; $i++) { ?>			
										<?php if ($p == $i) { ?>
											<li class="page-item active"><a class="page-link" href="?p=<?php echo $i; ?>"><?php echo $i; ?></a></li>
										<?php } else { ?>
											<li class="page-item"><a class="page-link" href="?p=<?php echo $i; ?>"><?php echo $i; ?></a></li>
										<?php } ?>			
									 <?php } ?>		 
									 <?php if (($p + 1) <= $total_pages) { ?>
										<li class="page-item"><a class="page-link" href="?p=<?php echo ($p + 1); ?>"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
									 <?php } ?>		 
								</ul>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-md-4">
				<div class="sidebar">
					<div class="subscribe_form">
						<h1>Subscribe</h1>
						<form class="subscribe form" method="post">
							<input type="email" name="email" placeholder="Email" required>
							<input type="hidden" name="name" class="form-control" id="name">
							<input type="hidden" name="description" class="form-control" id="name">
							<input type="hidden" name="created_at" id="created_at" value="<?php echo $today =  date('Y-m-d H:i:s'); ?>" />
							<input type="hidden" name="updated_at" id="updated_at" value="<?php echo $today =  date('Y-m-d H:i:s'); ?>" />
							<input type="hidden" name="status" id="status" value="0" />
							<button class="btn btn_submit" type="submit" name="subscribe">Submit</button>
						</form>
					</div>
					
					<div class="category_list">
						<h1>Archive</h1>
						<ul>
							<?php
								$dt = strtotime(date('Y-m-01'));
								for ($j = 0; $j <= 4; $j++) {
									$dates = date("F Y", strtotime(" -$j month", $dt));
									$dateid = date('F-Y',strtotime($dates));
							?>
							<li><a href="/news-archives?id=<?= $dateid; ?>"><?= $dates; ?></a></li>
							<?php
								}
							?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>	

<?php include('includes/template/accreditations.php'); ?>