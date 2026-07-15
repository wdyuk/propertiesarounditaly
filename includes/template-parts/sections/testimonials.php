<?php $testimonials = table_fetch_rows('testimonials','status = 1','created_at DESC', 0,5);?>
<section class="testimonials bg-img" style="background-image:url(/assets/img/Testimonial_resized.jpg);">
	<div class="testimonials__overlay">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-10 text-center">
					<h2>Testimonials</h2>
				</div>
			</div>
		</div>
		<div class="row no-gutters justify-content-center">
			<div class="col-12">
				<div class="testimonials__slider">
					<?php foreach ($testimonials as $testimonial) { ?>
						<div class="testimonials__testimonial">
							<a href="<?= getRewriteUrl('page', 29); ?>" style="text-decoration: none; color: #271759;">
								<div class="testimonials__testimonial__header">
									<div class="testimonials__testimonial__title"><h6><?= $testimonial['title'];?></h6></div>
									<div class="testimonials__testimonial__stars">
										<span class="testimonials__testimonial__star">
											<?php
												for($i=1;$i<=5;$i++) {
													if(!empty($testimonial["rating"]) && $i<=$testimonial["rating"]) {
														$selected = "fas fa-star";
													} else {
														$selected = "fal fa-star";
													}
											?>
												<i class="<?= $selected; ?>" aria-hidden="true"></i>
											<?php
												}
											?>
											<!-- <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fal fa-star"></i> -->
										</span>
									</div>
								</div>
								<div class="testimonials__testimonial__info"><p><span class="testimonials__testimonial__client"><?= $testimonial['author'];?></span>, <span class="testimonials__testimonial__date"><?= date('d F Y',strtotime($testimonial['created_at']));?></span></p></div>
								<div class="testimonials__testimonial__text">
									<?= $testimonial['description'];?>
								</div>
							</a>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</section>