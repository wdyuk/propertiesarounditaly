<!-- Projects Page -->
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

<div class="projects_landing">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="main_title">
					<h1><?= $pageData['page_title']; ?></h1>
				</div>	
			</div>
		</div>
	</div>
	<div class="projects">
		<div class="form-group">
	        <div class="dropdown">
			    <button type="button" class="category_filter dropdown-toggle" id="filterSelect" data-toggle="dropdown">
			      Filter
			    </button>
			    <div class="dropdown-menu">
			      	<a class="dropdown-item" href="/projects" value="All">All</a>
			     	<?php
						$categories = table_fetch_rows('page', 'parent_id = 3 AND status = 1');
						foreach($categories as $category){
					?>
			            <a class="dropdown-item" href="/project-category?id=<?= $category['id']; ?>" value="<?= $category['menu_title']; ?>"><?= $category['menu_title']; ?></a>
					<?php
						}
					?>
			    </div>
			</div>
	    </div>
		
		<?php
			$p = isset($_GET['p']) && is_numeric($_GET['p']) ? intval($_GET['p']) : 1;
			$limit = 20;
			$start = ($p - 1) * $limit;

			$total_rows = table_row_count('projects', 'status=1');
			$total_pages = ceil($total_rows / $limit);
			$projects = table_fetch_rows('projects','status=1','created_at ASC', $start, $limit);
			if(count($projects)){
				foreach($projects as $project){
		?>
		<div class="pro_landingcontent">
			<a href="<?= $project['url']; ?>">
				<?php
					$projectimg = get_image('projects/' . $project['id'] . '-project');

					if (strlen($projectimg) > 0):
				?>
				<div class="pro_img" style="background-image: url('<?= $projectimg; ?>');"></div>
				<?php
					endif;
				?>
				<div class="pro_innerinfo">
					<i class="fa fa-plus" aria-hidden="true"></i>
					<h3><?= $project['title']; ?></h3>
					<?= $project['short_description']; ?>
				</div>
			</a>
		</div>
		<?php
				}	
			}
		?>
		
		<div class="pagination">
			<?php if ($total_pages > 1) { ?>
				<ul>
					<?php for ($i = 1; $i <= $total_pages; $i++) { ?>			
						<?php if ($p == $i) { ?>
							<li><a class="current" href="?p=<?php echo $i; ?>"><?php echo $i; ?></a></li>
						<?php } else { ?>
							<li><a href="?p=<?php echo $i; ?>"><?php echo $i; ?></a></li>
						<?php } ?>			
					 <?php } ?>
				</ul>
			<?php
			}
			?>
		</div>
	</div>
</div>	
<?php include('includes/template/accreditations.php'); ?>