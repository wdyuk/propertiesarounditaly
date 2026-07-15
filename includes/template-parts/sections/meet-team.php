<?php $team = table_fetch_rows('teams','status = 1', 'position ASC');?>
<section class="meet-team">
	<div class="container">
		<div class="row">
			<div class="col text-center">
				<h2 class="meet-team-header">Our team of professionals</h2>
				<!-- <p>Highly skilled and passionate people - <a href="<?= getRewriteUrl('page', 28); ?>">View the Whole Team</a></p> -->
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="col-12">
				<div class="meet-team__slider">
					<?php foreach ($team as $member) {
						$image = get_image('teams/' . $member['id'] . '-image');
						if(strlen($image) == 0){
							$image = '/assets/img/rm-portrait.jpg';
						}?>
						<div class="meet-team__member">
							<div class="meet-team__member-img bg-img" style="background-image:url(<?= $image;?>);" style="display:none;">
								<div class="meet-team__member-content">
									<h3 class="meet-team__member-name"><?= $member['full_name'];?></h3>
									<h6 class="meet-team__member-position"><?= $member['qualifications'];?></h6>
									<h6 class="meet-team__member-position"><?= $member['job_title'];?></h6>
									<p class="button simple meet-team__member-link"><a href="<?= getRewriteUrl('teams',$member['id']);?>">Find Out More</a></p>
								</div>
							</div>
						</div>
					<?php }?>

				</div>
			</div>
		</div>
	</div>
</section>