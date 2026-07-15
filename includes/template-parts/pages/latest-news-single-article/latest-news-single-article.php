<?php
$image = get_image('blog/' . $pageData['id'] . '-large');
?>
<section class="latest-news-single-article__article-container">
	<div class="container">
		<div class="row">
			<div class="col text-center px-5">
				<div class="latest-news-single-article__article-heading px-4">

					<h6><?= date('d F Y',strtotime($pageData['publish_date']));?></h6>
					<h1><?= $pageData['page_title'];?></h1>
				
					<?php if (strlen($image) > 0){ ?>
						<img src="<?= $image;?>" alt="<?= $pageData['page_title']; ?>" class="img-fluid mb-4" style="max-height: 500px;">
					<?php } ?>
          <?= $pageData['content']; ?>
          <p class="my-4">
            <a href="/news" class="btn btn-primary"><i class="fas fa-arrow-left pe-2"></i>Back to all news</a>
          </p>
				</div>
			</div>
		</div>
		
	</div>
</section>
<?php 
$timestamp = new DateTime($pageData['updated_at']);
$updated_at = $timestamp->format('c'); // Returns ISO8601 in proper format
// $updated_at = $timestamp->format(DateTime::ISO8601); // Works the same since const ISO8601 = "Y-m-d\TH:i:sO"
$timestamp = new DateTime($pageData['published_at']);
$published_at = $timestamp->format('c'); // Returns ISO8601 in proper format
// $published_at = $timestamp->format(DateTime::ISO8601); // Works the same since const ISO8601 = "Y-m-d\TH:i:sO"
?>
<?php if (strlen($image) > 0) {
      	$imageurl =rtrim('/',BASE_URL).$image;
	     
 } else {
 	$imageurl = SITE_URL.'uploads/settings/1-image.png"';
 } ?>
<script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "NewsArticle",
      "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "https://google.com/article"
      },
      "headline": "<?= $pageData['page_title'];?>",
	  "image": [
	        "<?= $imageurl; ?>"
	   ],
      
      
      "datePublished": "<?= $published_at; ?>",
      "dateModified": "<?= $updated_at; ?>",
      "author": {
        "@type": "Organisation",
        "name": "Properties around Italy",
        "url": "<?= SITE_URL; ?>"
      },
      "publisher": {
        "@type": "Organization",
        "name": "Properties around Italy",
        "logo": {
          "@type": "ImageObject",
          "url": "<?= SITE_URL; ?>uploads/settings/1-image.png"
        }
      }
    }
    </script>