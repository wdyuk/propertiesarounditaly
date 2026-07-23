<?php
$messages = array();
$errors = array();
$id = (int) get_id();
$override = array();

$sites = table_fetch_rows('sites', 'status = 1', 'is_default DESC, website_name ASC');
$pages = table_fetch_rows('page', '', 'position ASC');

$selected_site_id = isset($_GET['site_id']) ? (int) $_GET['site_id'] : 0;
$selected_page_id = isset($_GET['page_id']) ? (int) $_GET['page_id'] : 0;

if ($id > 0) {
    $override = table_fetch_row('site_page_overrides', 'id = ' . $id);
    if ($override !== false) {
        $selected_site_id = (int) $override['site_id'];
        $selected_page_id = (int) $override['page_id'];
    }
}

if ($selected_site_id <= 0 && !empty($sites)) {
    $selected_site_id = (int) $sites[0]['id'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected_site_id = (int) ($_POST['site_id'] ?? 0);
    $selected_page_id = (int) ($_POST['page_id'] ?? 0);

    if ($selected_site_id <= 0) {
        $errors[] = 'Please choose a site.';
    }

    if ($selected_page_id <= 0) {
        $errors[] = 'Please choose a page.';
    }

    if (empty($errors)) {
        $fields = array(
            'site_id',
            'page_id',
            'menu_title',
            'page_title',
            'h1_title',
            'content',
            'meta_title',
            'meta_description',
            'geo_text',
            'status',
        );

        $_POST['status'] = isset($_POST['status']) ? (int) $_POST['status'] : 0;
        $_POST['site_id'] = $selected_site_id;
        $_POST['page_id'] = $selected_page_id;

        if ($id > 0) {
            table_update('site_page_overrides', $fields, $_POST, 'id=' . $id);
            $messages[] = 'Override updated successfully.';
        } else {
            $existing = table_fetch_row('site_page_overrides', 'site_id = ' . $selected_site_id . ' AND page_id = ' . $selected_page_id);

            if ($existing !== false) {
                $id = (int) $existing['id'];
                table_update('site_page_overrides', $fields, $_POST, 'id=' . $id);
                $messages[] = 'Override updated successfully.';
            } else {
                $id = (int) table_insert('site_page_overrides', $fields, $_POST);
                $messages[] = 'Override created successfully.';
            }
        }

        if ($id > 0) {
            $override = table_fetch_row('site_page_overrides', 'id = ' . $id);
        }
    }
}

if ($override === false) {
    $override = array(
        'site_id' => $selected_site_id,
        'page_id' => $selected_page_id,
        'menu_title' => '',
        'page_title' => '',
        'h1_title' => '',
        'content' => '',
        'meta_title' => '',
        'meta_description' => '',
        'geo_text' => '',
        'status' => 1,
    );
}

$base_page = $selected_page_id > 0 ? table_fetch_row('page', 'id = ' . $selected_page_id) : false;

if ($base_page !== false && strlen(trim((string) $override['content'])) === 0) {
    $override['menu_title'] = $override['menu_title'] ?: $base_page['menu_title'];
    $override['page_title'] = $override['page_title'] ?: $base_page['page_title'];
    $override['h1_title'] = $override['h1_title'] ?: $base_page['h1_title'];
    $override['content'] = $base_page['content'];
    $override['meta_description'] = $override['meta_description'] ?: $base_page['meta_description'];
}
?>
<form class="validate-form" method="post">
    <input type="hidden" name="id" value="<?= (int) $id; ?>" />
    <div class="card mb-4">
        <div class="card-header">
            <h1><?= $id > 0 ? 'Edit Override' : 'Add Override'; ?></h1>
        </div>
        <div class="card-body">
            <?php show_messages($messages); ?>
            <?php show_errors($errors); ?>

            <div class="form-group">
                <label for="site_id">Site</label>
                <select class="form-control" name="site_id" id="site_id">
                    <?php foreach ($sites as $site) { ?>
                        <option value="<?= (int) $site['id']; ?>" <?= (int) $site['id'] === $selected_site_id ? 'selected="selected"' : ''; ?>>
                            <?= htmlentities($site['website_name']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="page_id">Page</label>
                <select class="form-control" name="page_id" id="page_id">
                    <?php foreach ($pages as $page) { ?>
                        <option value="<?= (int) $page['id']; ?>" <?= (int) $page['id'] === $selected_page_id ? 'selected="selected"' : ''; ?>>
                            <?= htmlentities($page['menu_title']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="menu_title">Menu Title</label>
                <input class="form-control" name="menu_title" id="menu_title" type="text" value="<?= isset($override['menu_title']) ? htmlentities($override['menu_title']) : ''; ?>" />
            </div>

            <div class="form-group">
                <label for="page_title">Page Title</label>
                <input class="form-control" name="page_title" id="page_title" type="text" value="<?= isset($override['page_title']) ? htmlentities($override['page_title']) : ''; ?>" />
            </div>

            <div class="form-group">
                <label for="h1_title">H1 Title</label>
                <input class="form-control" name="h1_title" id="h1_title" type="text" value="<?= isset($override['h1_title']) ? htmlentities($override['h1_title']) : ''; ?>" />
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <?php show_fckeditor('content', isset($override['content']) ? $override['content'] : ''); ?>
            </div>

            <div class="form-group">
                <label for="meta_title">Meta Title</label>
                <input class="form-control" name="meta_title" id="meta_title" type="text" value="<?= isset($override['meta_title']) ? htmlentities($override['meta_title']) : ''; ?>" />
            </div>

            <div class="form-group">
                <label for="meta_description">Meta Description</label>
                <textarea class="form-control" name="meta_description" id="meta_description" rows="3"><?= isset($override['meta_description']) ? htmlentities($override['meta_description']) : ''; ?></textarea>
            </div>

            <div class="form-group">
                <label for="geo_text">GEO Text</label>
                <textarea class="form-control" name="geo_text" id="geo_text" rows="3"><?= isset($override['geo_text']) ? htmlentities($override['geo_text']) : ''; ?></textarea>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" name="status" id="status">
                    <option value="1" <?= isset($override['status']) && (int) $override['status'] === 1 ? 'selected="selected"' : ''; ?>>Enabled</option>
                    <option value="0" <?= isset($override['status']) && (int) $override['status'] === 0 ? 'selected="selected"' : ''; ?>>Disabled</option>
                </select>
            </div>

            <div class="form-group">
                <?php show_big_button('save', 'Save'); ?>
            </div>
        </div>
    </div>
</form>
