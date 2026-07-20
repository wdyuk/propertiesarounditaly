<?php
$messages = array();
$errors = array();
$id = (int) get_id();
$data = array();
$existing_data = array();
$logo_path_to_delete = '';
$reverse_logo_path_to_delete = '';
$saved = isset($_GET['saved']) && $_GET['saved'] == 1;

function resolve_site_file_path($path)
{
    if (strlen(trim((string) $path)) === 0) {
        return false;
    }

    $relative = ltrim((string) $path, '/\\');
    $fullPath = rtrim(BASE_DIR, '/\\') . DIRECTORY_SEPARATOR . str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $relative);

    return file_exists($fullPath) ? $fullPath : false;
}

if ($id > 0) {
    $data = table_fetch_row('sites', 'id = ' . $id);
    $existing_data = $data !== false ? $data : array();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($id > 0) {
        $existing_data = table_fetch_row('sites', 'id = ' . $id);
        if ($existing_data === false) {
            $existing_data = array();
        }
    }

    $saveData = array_merge($existing_data, $_POST);
    if ($id > 0) {
        $saveData['domain'] = isset($existing_data['domain']) ? $existing_data['domain'] : '';
        $saveData['base_url'] = isset($existing_data['base_url']) ? $existing_data['base_url'] : '';
    }

    $fields = array(
        'domain',
        'base_url',
        'website_name',
        'company_number',
        'logo_path',
        'reverse_logo_path',
        'seo_title',
        'seo_description',
        'geo_text',
        'contact_mail',
        'contact_mail_cnt_form',
        'contact_number',
        'contact_number_html',
        'mobile_contact_number',
        'mobile_contact_number_html',
        'address',
        'correspondence_address',
        'map_link',
        'facebook_link',
        'youtube_link',
        'twitter_link',
        'snapchat_link',
        'instagram_link',
        'pinterest_link',
        'google_link',
        'linkedin_link',
        'is_default',
        'status',
    );

    $saveData['is_default'] = isset($saveData['is_default']) ? 1 : 0;
    $saveData['status'] = isset($saveData['status']) ? (int) $saveData['status'] : 0;

    if ($id === 0) {
        $id = (int) table_insert('sites', $fields, $saveData);
        $messages[] = 'Site created successfully.';
    } else {
        table_update('sites', $fields, $saveData, 'id=' . $id);
        $messages[] = 'Site updated successfully.';
    }

    $uploadDir = UPLOADS_DIR . 'sites' . DIRECTORY_SEPARATOR;
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0775, true);
    }

    if (isset($_FILES['logo_file']) && !empty($_FILES['logo_file']['tmp_name'])) {
        $imgData = pathinfo($_FILES['logo_file']['name']);
        $targetFile = $uploadDir . $id . '-logo.' . $imgData['extension'];
        move_uploaded_file($_FILES['logo_file']['tmp_name'], $targetFile);
        $logoPath = '/uploads/sites/' . $id . '-logo.' . $imgData['extension'];
        table_update('sites', array('logo_path'), array('logo_path' => $logoPath), 'id=' . $id);
        $data['logo_path'] = $logoPath;
    }

    if (isset($_FILES['reverse_logo_file']) && !empty($_FILES['reverse_logo_file']['tmp_name'])) {
        $imgData = pathinfo($_FILES['reverse_logo_file']['name']);
        $targetFile = $uploadDir . $id . '-reverse-logo.' . $imgData['extension'];
        move_uploaded_file($_FILES['reverse_logo_file']['tmp_name'], $targetFile);
        $reverseLogoPath = '/uploads/sites/' . $id . '-reverse-logo.' . $imgData['extension'];
        table_update('sites', array('reverse_logo_path'), array('reverse_logo_path' => $reverseLogoPath), 'id=' . $id);
        $data['reverse_logo_path'] = $reverseLogoPath;
    }

    if (isset($_POST['delete_logo']) && isset($existing_data['logo_path']) && strlen(trim((string) $existing_data['logo_path'])) > 0) {
        $logo_path_to_delete = $existing_data['logo_path'];
    }

    if (isset($_POST['delete_reverse_logo']) && isset($existing_data['reverse_logo_path']) && strlen(trim((string) $existing_data['reverse_logo_path'])) > 0) {
        $reverse_logo_path_to_delete = $existing_data['reverse_logo_path'];
    }

    if (strlen($logo_path_to_delete) > 0) {
        $fullPath = resolve_site_file_path($logo_path_to_delete);
        if ($fullPath !== false) {
            @unlink($fullPath);
        }
        table_update('sites', array('logo_path'), array('logo_path' => ''), 'id=' . $id);
        $data['logo_path'] = '';
        $messages[] = 'Logo deleted successfully.';
    }

    if (strlen($reverse_logo_path_to_delete) > 0) {
        $fullPath = resolve_site_file_path($reverse_logo_path_to_delete);
        if ($fullPath !== false) {
            @unlink($fullPath);
        }
        table_update('sites', array('reverse_logo_path'), array('reverse_logo_path' => ''), 'id=' . $id);
        $data['reverse_logo_path'] = '';
        $messages[] = 'Reverse logo deleted successfully.';
    }

    $data = table_fetch_row('sites', 'id = ' . $id);
    if ($data !== false) {
        $messages[] = 'Changes saved.';
    }

    $query = array(
        'module=sites',
        'action=form',
        'id=' . $id,
        'saved=1',
    );

    redirect('?' . implode('&', $query));
}
?>
<form class="validate-form" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= (int) $id; ?>" />
    <?php if ($saved) { ?>
        <div class="alert alert-success messages mb-4">
            <div class="row">
                <div class="col-1 alert-icon-col">
                    <span class="fa fa-check fa-fw"></span>
                </div>
                <div class="col">
                    Saved successfully.
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="card mb-4">
        <div class="card-header">
            <h1><?= $id > 0 ? 'Edit Site' : 'Add Site'; ?></h1>
        </div>
        <div class="card-body">
            <?php show_errors($errors); ?>
            <div class="form-group">
                <label for="domain">Domain</label>
                <input class="required form-control" name="domain_display" id="domain" type="text" value="<?= isset($data['domain']) ? htmlentities($data['domain']) : ''; ?>" disabled="disabled" />
                <input type="hidden" name="domain" value="<?= isset($data['domain']) ? htmlentities($data['domain']) : ''; ?>" />
                <small class="form-text text-muted">This is locked because it controls which site profile is loaded for the domain.</small>
            </div>
            <div class="form-group">
                <label for="base_url">Base URL</label>
                <input class="required form-control" name="base_url_display" id="base_url" type="text" value="<?= isset($data['base_url']) ? htmlentities($data['base_url']) : ''; ?>" disabled="disabled" />
                <input type="hidden" name="base_url" value="<?= isset($data['base_url']) ? htmlentities($data['base_url']) : ''; ?>" />
                <small class="form-text text-muted">This is locked because it is used for canonical and Open Graph URLs.</small>
            </div>
            <div class="form-group">
                <label for="website_name">Website Name</label>
                <input class="required form-control" name="website_name" id="website_name" type="text" value="<?= isset($data['website_name']) ? htmlentities($data['website_name']) : ''; ?>" />
            </div>
            <div class="form-group">
                <label for="company_number">Company Number</label>
                <input class="form-control" name="company_number" id="company_number" type="text" value="<?= isset($data['company_number']) ? htmlentities($data['company_number']) : ''; ?>" />
            </div>
            <div class="form-group">
                <label for="logo_file">Main Logo Upload</label>
                <input class="form-control" name="logo_file" id="logo_file" type="file" />
                <small class="form-text text-muted">This is the primary logo used in the header.</small>
            </div>
            <div class="form-group">
                <?php if (isset($data['logo_path']) && strlen(trim((string) $data['logo_path'])) > 0 && resolve_site_file_path($data['logo_path']) !== false) { ?>
                    <div class="mb-2">
                        <img src="<?= htmlentities($data['logo_path']); ?>" alt="Current main logo" style="max-width: 260px; height: auto;" />
                    </div>
                    <label class="form-check-label">
                        <input type="checkbox" name="delete_logo" value="1" />
                        Delete current logo
                    </label>
                <?php } else { ?>
                    <p class="text-muted">No logo uploaded yet.</p>
                <?php } ?>
            </div>
            <div class="form-group">
                <label for="reverse_logo_file">Reverse Logo Upload</label>
                <input class="form-control" name="reverse_logo_file" id="reverse_logo_file" type="file" />
                <small class="form-text text-muted">This is the alternate logo used on dark backgrounds and in the drawer.</small>
            </div>
            <div class="form-group">
                <?php if (isset($data['reverse_logo_path']) && strlen(trim((string) $data['reverse_logo_path'])) > 0 && resolve_site_file_path($data['reverse_logo_path']) !== false) { ?>
                    <div class="mb-2">
                        <img src="<?= htmlentities($data['reverse_logo_path']); ?>" alt="Current reverse logo" style="max-width: 260px; height: auto;" />
                    </div>
                    <label class="form-check-label">
                        <input type="checkbox" name="delete_reverse_logo" value="1" />
                        Delete current reverse logo
                    </label>
                <?php } else { ?>
                    <p class="text-muted">No reverse logo uploaded yet.</p>
                <?php } ?>
            </div>
            <div class="form-group">
                <label for="seo_title">SEO Title</label>
                <input class="form-control" name="seo_title" id="seo_title" type="text" value="<?= isset($data['seo_title']) ? htmlentities($data['seo_title']) : ''; ?>" />
            </div>
            <div class="form-group">
                <label for="seo_description">SEO Description</label>
                <textarea class="form-control" name="seo_description" id="seo_description" rows="3"><?= isset($data['seo_description']) ? htmlentities($data['seo_description']) : ''; ?></textarea>
            </div>
            <div class="form-group">
                <label for="geo_text">GEO Text</label>
                <textarea class="form-control" name="geo_text" id="geo_text" rows="3"><?= isset($data['geo_text']) ? htmlentities($data['geo_text']) : ''; ?></textarea>
            </div>
            <div class="form-group">
                <label for="contact_mail">Contact Email</label>
                <input class="form-control" name="contact_mail" id="contact_mail" type="email" value="<?= isset($data['contact_mail']) ? htmlentities($data['contact_mail']) : ''; ?>" />
            </div>
            <div class="form-group">
                <label for="contact_mail_cnt_form">Contact Email for Forms</label>
                <input class="form-control" name="contact_mail_cnt_form" id="contact_mail_cnt_form" type="email" value="<?= isset($data['contact_mail_cnt_form']) ? htmlentities($data['contact_mail_cnt_form']) : ''; ?>" />
            </div>
            <div class="form-group">
                <label for="contact_number">Contact Number</label>
                <input class="form-control" name="contact_number" id="contact_number" type="text" value="<?= isset($data['contact_number']) ? htmlentities($data['contact_number']) : ''; ?>" />
            </div>
            <div class="form-group">
                <label for="contact_number_html">Contact Number HTML</label>
                <input class="form-control" name="contact_number_html" id="contact_number_html" type="text" value="<?= isset($data['contact_number_html']) ? htmlentities($data['contact_number_html']) : ''; ?>" />
            </div>
            <div class="form-group">
                <label for="mobile_contact_number">Mobile Contact Number</label>
                <input class="form-control" name="mobile_contact_number" id="mobile_contact_number" type="text" value="<?= isset($data['mobile_contact_number']) ? htmlentities($data['mobile_contact_number']) : ''; ?>" />
            </div>
            <div class="form-group">
                <label for="mobile_contact_number_html">Mobile Contact Number HTML</label>
                <input class="form-control" name="mobile_contact_number_html" id="mobile_contact_number_html" type="text" value="<?= isset($data['mobile_contact_number_html']) ? htmlentities($data['mobile_contact_number_html']) : ''; ?>" />
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <textarea class="form-control" name="address" id="address" rows="3"><?= isset($data['address']) ? htmlentities($data['address']) : ''; ?></textarea>
            </div>
            <div class="form-group">
                <label for="correspondence_address">Correspondence Address</label>
                <textarea class="form-control" name="correspondence_address" id="correspondence_address" rows="3"><?= isset($data['correspondence_address']) ? htmlentities($data['correspondence_address']) : ''; ?></textarea>
            </div>
            <div class="form-group">
                <label for="map_link">Map Link</label>
                <input class="form-control" name="map_link" id="map_link" type="text" value="<?= isset($data['map_link']) ? htmlentities($data['map_link']) : ''; ?>" />
            </div>
            <div class="form-group">
                <label for="facebook_link">Facebook Link</label>
                <input class="form-control" name="facebook_link" id="facebook_link" type="text" value="<?= isset($data['facebook_link']) ? htmlentities($data['facebook_link']) : ''; ?>" />
            </div>
            <div class="form-group">
                <label for="instagram_link">Instagram Link</label>
                <input class="form-control" name="instagram_link" id="instagram_link" type="text" value="<?= isset($data['instagram_link']) ? htmlentities($data['instagram_link']) : ''; ?>" />
            </div>
            <div class="form-group">
                <label for="linkedin_link">LinkedIn Link</label>
                <input class="form-control" name="linkedin_link" id="linkedin_link" type="text" value="<?= isset($data['linkedin_link']) ? htmlentities($data['linkedin_link']) : ''; ?>" />
            </div>
            <div class="form-group">
                <label for="pinterest_link">Pinterest Link</label>
                <input class="form-control" name="pinterest_link" id="pinterest_link" type="text" value="<?= isset($data['pinterest_link']) ? htmlentities($data['pinterest_link']) : ''; ?>" />
            </div>
            <div class="form-group">
                <label for="google_link">Google Link</label>
                <input class="form-control" name="google_link" id="google_link" type="text" value="<?= isset($data['google_link']) ? htmlentities($data['google_link']) : ''; ?>" />
            </div>
            <div class="form-group">
                <label for="twitter_link">Twitter Link</label>
                <input class="form-control" name="twitter_link" id="twitter_link" type="text" value="<?= isset($data['twitter_link']) ? htmlentities($data['twitter_link']) : ''; ?>" />
            </div>
            <div class="form-group">
                <label for="youtube_link">YouTube Link</label>
                <input class="form-control" name="youtube_link" id="youtube_link" type="text" value="<?= isset($data['youtube_link']) ? htmlentities($data['youtube_link']) : ''; ?>" />
            </div>
            <div class="form-group">
                <label for="snapchat_link">Snapchat Link</label>
                <input class="form-control" name="snapchat_link" id="snapchat_link" type="text" value="<?= isset($data['snapchat_link']) ? htmlentities($data['snapchat_link']) : ''; ?>" />
            </div>
            <div class="form-group form-check">
                <input class="form-check-input" name="is_default" id="is_default" type="checkbox" value="1" <?= isset($data['is_default']) && (int) $data['is_default'] === 1 ? 'checked="checked"' : ''; ?> />
                <label class="form-check-label" for="is_default">Default Site</label>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" name="status" id="status">
                    <option value="1" <?= isset($data['status']) && (int) $data['status'] === 1 ? 'selected="selected"' : ''; ?>>Enabled</option>
                    <option value="0" <?= isset($data['status']) && (int) $data['status'] === 0 ? 'selected="selected"' : ''; ?>>Disabled</option>
                </select>
            </div>
            <div class="form-group">
                <?php show_big_button('save', 'Save'); ?>
            </div>
        </div>
    </div>
</form>
