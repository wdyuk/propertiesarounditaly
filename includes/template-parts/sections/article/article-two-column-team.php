<section class="article">
	<div class="container">
		<div class="row">
			<div class="col">
				<article class="article__content">
					<div class="row">
						<div class="col-12 col-md-6">
							<?php $path = get_image('teams/' . $pageData['id'] . '-image');
							if (strlen($path) == 0){
								$path = '/assets/img/generic.jpg';
							}?>
							<img src="<?= $path;?>" alt="<?= $pageData['full_name'];?>" style="max-width: 100%;">
						</div>
						<div class="col-12 col-md-6">
							<h4 class="mb-4">Position: <br/><span style="font-weight: bold; color: #b99881;"><?= $pageData['job_title'];?></span></h4>
							<?php if(strlen($pageData['qualifications']) > 0){?>
								<h4 class="mb-4">Qualifications: <br/><span style="font-weight: bold; color: #b99881;"><?= $pageData['qualifications'];?></span></h4>
							<?php } ?>
							<?= $pageData['content'];?>
							<?php if(!empty($pageData['phone_web_version']) && !empty($pageData['phone_display'])){?>
								<p class="mt-5 button mx-2"><a href="tel:<?= $pageData['phone_web_version'];?>">Call me on <?=  $pageData['phone_display'];?></a></p>
							<?php }
							if(!empty($pageData['phone_web_version_2']) && !empty($pageData['phone_display_2'])){?>
								<p class="button mx-2"><a href="tel:<?= $pageData['phone_web_version_2'];?>">Call me on <?=  $pageData['phone_display_2'];?></a></p>
							<?php } ?>
							<br/>
							<p class="button mx-2"><a href="mailto:<?= $pageData['email'];?>">Email Me</a></p>
						</div>
					</div>
				</article>
			</div>
		</div>
	</div>
</section>