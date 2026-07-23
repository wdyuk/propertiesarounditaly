<?php
$desktop_banner = get_image('page/' . $pageData['id'] . '-header-image');
$mobile_banner = get_image('page/' . $pageData['id'] . '-mobile-header-image');

if (strlen($desktop_banner)) { ?>
    <div class="container">
        <div class="banner">
            <div class="hero-banner hero-banner-inner position-relative">
                <img src="<?= $desktop_banner; ?>" class="d-none d-sm-block w-100" />
                <img src="<?= $mobile_banner; ?>" class="d-block d-sm-none w-100" />
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
$section_one_image = get_image('page/' . $pageData['id'] . '-static-image-1');
$section_two_image = get_image('page/' . $pageData['id'] . '-static-image-2');
$section_three_image = get_image('page/' . $pageData['id'] . '-static-image-3');

if (!function_exists('render_page_story_sections')) {
    function get_page_story_sections($html)
    {
        $html = trim((string) $html);

        if ($html === '') {
            return array();
        }

        $parts = preg_split('/(<h2\b[^>]*>.*?<\/h2>)/is', $html, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

        if ($parts === false || count($parts) <= 1) {
            return array(
                array(
                    'heading' => '',
                    'body' => $html,
                ),
            );
        }

        $sections = array();
        $current_heading = '';
        $current_body = '';

        foreach ($parts as $part) {
            if (preg_match('/^<h2\b/i', $part)) {
                if (strlen(trim($current_heading . $current_body)) > 0) {
                    $sections[] = array(
                        'heading' => $current_heading,
                        'body' => $current_body,
                    );
                }

                $current_heading = $part;
                $current_body = '';
            } else {
                $current_body .= $part;
            }
        }

        if (strlen(trim($current_heading . $current_body)) > 0) {
            $sections[] = array(
                'heading' => $current_heading,
                'body' => $current_body,
            );
        }

        return $sections;
    }

    function render_page_story_sections($html)
    {
        $sections = get_page_story_sections($html);

        if (empty($sections)) {
            return;
        }

        foreach ($sections as $section) {
            echo '<div class="page-story-layout__content-block">';
            if (strlen(trim($section['heading'])) > 0) {
                echo $section['heading'];
            }
            if (strlen(trim($section['body'])) > 0) {
                echo $section['body'];
            }
            echo '</div>';
        }
    }

    function render_page_story_section_block(array $section)
    {
        echo '<div class="page-story-layout__content-block">';
        if (strlen(trim($section['heading'])) > 0) {
            echo $section['heading'];
        }
        if (strlen(trim($section['body'])) > 0) {
            echo $section['body'];
        }
        echo '</div>';
    }
}
?>

<main class="page-story-layout">
    <section class="page-story-layout__section page-story-layout__section--beige">
        <div class="container">
            <div class="row align-items-start">
                <div class="col-12 col-lg-6">
                    <div class="page-story-layout__section-copy">
                        <div class="page-story-layout__content">
                            <?php
                            $page_story_sections = get_page_story_sections($pageData['content']);
                            $inline_sections = array_slice($page_story_sections, 0, 2);
                            if (!empty($inline_sections)) {
                                foreach ($inline_sections as $section) {
                                    render_page_story_section_block($section);
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="page-story-layout__section-media page-story-layout__section-media--right">
                        <div class="page-story-layout__image page-story-layout__image--wide">
                            <?php if (strlen($section_one_image)) { ?>
                                <img src="<?= $section_one_image; ?>" alt="<?= htmlentities($pageData['page_title']); ?>" class="img-fluid w-100" />
                            <?php } ?>
                        </div>
                        <div class="contact-us page-story-layout__contact text-center">
                            <h3 class="text-left">CONTACT US TODAY</h3>
                            <h3 class="contact-us_number">
                                <a href="tel:<?= $site_settings['mobile_contact_number_html']; ?>"><?= $site_settings['mobile_contact_number']; ?></a>
                            </h3>
                            <p class="contact-us_email">
                                <a href="mailto:<?= $site_settings['contact_mail']; ?>"><?= $site_settings['contact_mail']; ?></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <?php $full_width_sections = array_slice($page_story_sections, 2); ?>
            <?php if (!empty($full_width_sections)) { ?>
                <div class="row">
                    <div class="col-12">
                        <div class="page-story-layout__content page-story-layout__content--full-width">
                            <?php foreach ($full_width_sections as $section) { ?>
                                <?php render_page_story_section_block($section); ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>

    <section class="page-story-layout__section page-story-layout__section--white">
        <div class="container">
            <div class="row align-items-start">
                <div class="col-12 col-lg-6">
                    <div class="page-story-layout__section-media">
                        <div class="page-story-layout__image page-story-layout__image--wide">
                            <?php if (strlen($section_two_image)) { ?>
                                <img src="<?= $section_two_image; ?>" alt="<?= htmlentities($pageData['page_title']); ?>" class="img-fluid w-100" />
                            <?php } ?>
                        </div>
                        <div class="contact-us page-story-layout__contact text-center">
                            <h3 class="text-left">CONTACT US TODAY</h3>
                            <h3 class="contact-us_number">
                                <a href="tel:<?= $site_settings['mobile_contact_number_html']; ?>"><?= $site_settings['mobile_contact_number']; ?></a>
                            </h3>
                            <p class="contact-us_email">
                                <a href="mailto:<?= $site_settings['contact_mail']; ?>"><?= $site_settings['contact_mail']; ?></a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="page-story-layout__section-copy">
                        <div class="page-story-layout__content">
                            <?php
                            $page_story_sections = get_page_story_sections($pageData['content_2']);
                            $inline_sections = array_slice($page_story_sections, 0, 2);
                            if (!empty($inline_sections)) {
                                foreach ($inline_sections as $section) {
                                    echo '<div class="page-story-layout__content-block">';
                                    if (strlen(trim($section['heading'])) > 0) {
                                        echo $section['heading'];
                                    }
                                    if (strlen(trim($section['body'])) > 0) {
                                        echo $section['body'];
                                    }
                                    echo '</div>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php $full_width_sections = array_slice($page_story_sections, 2); ?>
            <?php if (!empty($full_width_sections)) { ?>
                <div class="row">
                    <div class="col-12">
                        <div class="page-story-layout__content page-story-layout__content--full-width">
                            <?php foreach ($full_width_sections as $section) { ?>
                                <div class="page-story-layout__content-block">
                                    <?php if (strlen(trim($section['heading'])) > 0) { ?>
                                        <?= $section['heading']; ?>
                                    <?php } ?>
                                    <?php if (strlen(trim($section['body'])) > 0) { ?>
                                        <?= $section['body']; ?>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>

    <section class="page-story-layout__section page-story-layout__section--beige page-story-layout__section--last">
        <div class="container">
            <div class="row align-items-start">
                <div class="col-12 col-lg-6">
                    <div class="page-story-layout__section-copy">
                        <div class="page-story-layout__content">
                            <?php
                            $page_story_sections = get_page_story_sections($pageData['content_3']);
                            $inline_sections = array_slice($page_story_sections, 0, 2);
                            if (!empty($inline_sections)) {
                                foreach ($inline_sections as $section) {
                                    render_page_story_section_block($section);
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="page-story-layout__section-media page-story-layout__section-media--right">
                        <div class="page-story-layout__image page-story-layout__image--wide">
                            <?php if (strlen($section_three_image)) { ?>
                                <img src="<?= $section_three_image; ?>" alt="<?= htmlentities($pageData['page_title']); ?>" class="img-fluid w-100" />
                            <?php } ?>
                        </div>
                        <div class="contact-us page-story-layout__contact text-center">
                            <h3 class="text-left">CONTACT US TODAY</h3>
                            <h3 class="contact-us_number">
                                <a href="tel:<?= $site_settings['mobile_contact_number_html']; ?>"><?= $site_settings['mobile_contact_number']; ?></a>
                            </h3>
                            <p class="contact-us_email">
                                <a href="mailto:<?= $site_settings['contact_mail']; ?>"><?= $site_settings['contact_mail']; ?></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <?php $full_width_sections = array_slice($page_story_sections, 2); ?>
            <?php if (!empty($full_width_sections)) { ?>
                <div class="row">
                    <div class="col-12">
                        <div class="page-story-layout__content page-story-layout__content--full-width">
                            <?php foreach ($full_width_sections as $section) { ?>
                                <?php render_page_story_section_block($section); ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>
</main>

<style>
.page-story-layout {
    padding: 2rem 0 4rem;
    background: #ffffff;
}

.page-story-layout__section {
    padding: 0 0 1.5rem;
}

.page-story-layout__section--last {
    padding-bottom: 0;
}

.page-story-layout__section--beige {
    background: #ffffff;
}

.page-story-layout__section--white {
    background: #cbcbcb;
}

.page-story-layout__intro {
    padding-top: 1.5rem;
}

.page-story-layout__lead {
    position: relative;
}

.page-story-layout__lead-media {
    float: right;
    width: 38%;
    margin: 1.5rem 0 1rem 2rem;
}

.page-story-layout__lead-copy {
    width: auto;
}

.page-story-layout__content {
    padding: 1.5rem 0 0;
}

.page-story-layout__content > :last-child {
    margin-bottom: 0;
}

.page-story-layout__content-block {
    margin-bottom: 1.5rem;
}

.page-story-layout__content-block > :last-child {
    margin-bottom: 0;
}

.page-story-layout__content h2,
.page-story-layout__content h3,
.page-story-layout__content h4 {
    clear: none;
}

.page-story-layout__media-stack {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.page-story-layout__image {
    background: #ece8df;
}

.page-story-layout__image img {
    display: block;
    width: 100%;
    object-fit: cover;
}

.page-story-layout__image--wide img {
    height: auto;
}

.page-story-layout__section-media {
    margin-top: 1.5rem;
}

.page-story-layout__section-copy {
    padding-top: 1.5rem;
}

.page-story-layout__contact {
    padding: 1.5rem 0;
    background: #94372f;
    color: #ffffff;
}

.page-story-layout__contact .contact-us_number a,
.page-story-layout__contact .contact-us_email a {
    color: #ffffff;
    text-decoration: none;
}

.page-story-layout__contact h3,
.page-story-layout__contact p {
    color: #ffffff;
}

@media (max-width: 991.98px) {
    .page-story-layout__content {
        padding-top: 1rem;
    }

    .page-story-layout__intro {
        padding-top: 1rem;
    }

    .page-story-layout__lead-media {
        float: none;
        width: 100%;
        margin: 0 0 1rem 0;
    }

    .page-story-layout__section-media {
        margin-top: 0;
    }

    .page-story-layout__section-copy {
        padding-top: 1rem;
    }
}
</style>
