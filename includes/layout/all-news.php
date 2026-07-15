 <?php include('includes/template-parts/sections/basic-page-title.php'); ?>
 <?php $news = table_fetch_rows('news','','published_at DESC'); ?>
    <main>
        <section class="article">
            <div class="container">
                <div class="row">
                    <div class="col text-center">
                        <article class="article__content">
                            <div class="row">
                                <div class="col">
                                    <?php foreach($news as $news) {
                                        ?>
                                        <a href="<?= getRewriteUrl('news', $news['id']);?>"><?= $news['title']; ?> - Published (<?= date('jS F Y',strtotime($news['published_at'])) ; ?>)</a><br>
                                        <?php
                                    } ?>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </section>
    </main>
