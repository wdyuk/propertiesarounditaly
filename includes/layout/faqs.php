<?php
$desktop_banner = get_image('page/' . $pageData['id'] . '-header-image');
$mobile_banner = get_image('page/' . $pageData['id'] . '-mobile-header-image');

if (strlen($desktop_banner)) { ?>
    <div class="container">
        <div class="banner">
            <div class="hero-banner hero-banner-inner position-relative">
                <img src="<?= $desktop_banner; ?>" class="d-none d-sm-block w-100" alt="<?= htmlentities($pageData['page_title']); ?>" />
                <img src="<?= $mobile_banner; ?>" class="d-block d-sm-none w-100" alt="<?= htmlentities($pageData['page_title']); ?>" />
                <div class="hero-caption-inner">
                    <h1><?= $pageData['h1_title']; ?></h1>
                </div>
            </div>
        </div>
    </div>
<?php } else {
    include('includes/template-parts/sections/basic-page-title.php');
} ?>

<?php
$faq_categories = array(
    'Buying Property in Italy',
    'Viewing Properties',
    'Living in Abruzzo',
    'Renovation & Property Management',
    'Travel & Lifestyle',
    'Our Services',
);

$faqs = table_fetch_rows('faqs', 'status = 1', 'position ASC');
$grouped_faqs = array();

foreach ($faq_categories as $category) {
    $grouped_faqs[$category] = array();
}

$grouped_faqs['Other'] = array();

foreach ($faqs as $faq) {
    $category = isset($faq['category']) ? trim((string) $faq['category']) : '';

    if ($category !== '' && array_key_exists($category, $grouped_faqs)) {
        $grouped_faqs[$category][] = $faq;
    } else {
        $grouped_faqs['Other'][] = $faq;
    }
}

$page_intro = isset($pageData['content']) ? trim((string) $pageData['content']) : '';
?>

<main class="faq-layout">
    <section class="faq-layout__intro">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-10 offset-lg-1">
                    <?php if (strlen($page_intro)) { ?>
                        <div class="faq-layout__intro-copy">
                            <?= $page_intro; ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>

    <section class="faq-layout__sections">
        <div class="container">
            <?php foreach ($grouped_faqs as $category => $items) { ?>
                <?php if (empty($items)) { continue; } ?>

                <?php
                $category_slug = strtolower($category);
                $category_slug = preg_replace('/[^a-z0-9]+/i', '-', $category_slug);
                $category_slug = trim($category_slug, '-');
                if ($category_slug === '') {
                    $category_slug = 'faq';
                }
                ?>

                <div class="faq-layout__category">
                    <div class="row">
                        <div class="col-12 col-lg-10 offset-lg-1">
                            <h2 class="faq-layout__category-title"><?= htmlentities($category); ?></h2>

                            <div class="accordion faq-layout__accordion" id="faqAccordion-<?= htmlentities($category_slug); ?>">
                                <?php foreach ($items as $index => $faq) { ?>
                                    <?php
                                    $faq_id = isset($faq['id']) ? (int) $faq['id'] : $index;
                                    $heading_id = 'faqHeading-' . $category_slug . '-' . $faq_id;
                                    $collapse_id = 'faqCollapse-' . $category_slug . '-' . $faq_id;
                                    $question = isset($faq['question']) ? trim((string) $faq['question']) : '';
                                    $answer = isset($faq['answer']) ? trim((string) $faq['answer']) : '';
                                    ?>
                                    <div class="accordion-item faq-layout__item">
                                        <h3 class="accordion-header faq-layout__item-header" id="<?= htmlentities($heading_id); ?>">
                                            <button class="accordion-button collapsed faq-layout__button" type="button" data-bs-toggle="collapse" data-bs-target="#<?= htmlentities($collapse_id); ?>" aria-expanded="false" aria-controls="<?= htmlentities($collapse_id); ?>">
                                                <?= htmlentities($question); ?>
                                            </button>
                                        </h3>
                                        <div id="<?= htmlentities($collapse_id); ?>" class="accordion-collapse collapse" aria-labelledby="<?= htmlentities($heading_id); ?>" data-bs-parent="#faqAccordion-<?= htmlentities($category_slug); ?>">
                                            <div class="accordion-body faq-layout__body">
                                                <?= nl2br(htmlentities($answer)); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>
</main>

<style>
.faq-layout {
    padding: 0 0 4rem;
    background: #ffffff;
}

.faq-layout__intro {
    padding: 1.5rem 0 0;
}

.faq-layout__intro-copy > :last-child {
    margin-bottom: 0;
}

.faq-layout__sections {
    padding-top: 1rem;
}

.faq-layout__category {
    padding-top: 2rem;
}

.faq-layout__category-title {
    margin-bottom: 1rem;
    color: #94372f;
}

.faq-layout__accordion .accordion-item {
    border: 0;
    margin-bottom: 0.75rem;
    background: transparent;
}

.faq-layout__accordion .accordion-button {
    font-size: 1.05rem;
    font-weight: 500;
    color: #2d2d2d;
    background: #f4f1ea;
    box-shadow: none;
    border-radius: 0;
    padding: 1rem 1.25rem;
}

.faq-layout__accordion .accordion-button:not(.collapsed) {
    color: #94372f;
    background: #ece3db;
}

.faq-layout__accordion .accordion-button:focus {
    border-color: transparent;
    box-shadow: none;
}

.faq-layout__accordion .accordion-body {
    background: #ffffff;
    border: 1px solid #e5e5e5;
    border-top: 0;
    padding: 1.25rem;
}

.faq-layout__body > :last-child {
    margin-bottom: 0;
}

@media (max-width: 991.98px) {
    .faq-layout__intro {
        padding-top: 1rem;
    }

    .faq-layout__category {
        padding-top: 1.5rem;
    }
}
</style>
