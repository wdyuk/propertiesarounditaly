<?php $team = table_fetch_rows('teams','status = 1', 'position ASC');?>
<section class="meet-team">
	<div class="container">
		<div class="row">
			<div class="col pb-md-5">
<!-- 				<div class="select-filter-wrapper">
					<select name="filter" id="filter" class="filter">
						<option value="filter">Filter</option>
						<option value="filter">Filter</option>
						<option value="filter">Filter</option>
					</select>
				</div> -->
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="meet-team__noslide row">
					<?php foreach ($team as $member) {
						$image = get_image('teams/' . $member['id'] . '-image');?>
						<div class="meet-team__memberold col-12 col-md-6 col-lg-4 text-center" >
							<div class="meet-team__member-img bg-img" style="background-image:url(<?= $image;?>);">
								<div class="meet-team__member-content">
									<h3 class="meet-team__member-name"><?= $member['full_name'];?></h3>
									<h6 class="meet-team__member-position"><?= $member['qualifications'];?></h6>
									<h6 class="meet-team__member-position"><?= $member['job_title'];?></h6>
									<p class="button simple blue"><a href="<?= getRewriteUrl('teams',$member['id']);?>" style="color: white;">Find Out More</a></p>
								</div>
							</div>
							<h3 class="meet-team__member-name"><?= $member['full_name'];?></h3>
							<h6 class="meet-team__member-position"><?= $member['job_title'];?></h6>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</section>