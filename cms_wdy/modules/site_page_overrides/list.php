<?php
$selected_site_id = isset($_GET['site_id']) ? (int) $_GET['site_id'] : 0;
$sites = table_fetch_rows('sites', 'status = 1', 'is_default DESC, website_name ASC');

if ($selected_site_id <= 0 && !empty($sites)) {
    $selected_site_id = (int) $sites[0]['id'];
}

$site = $selected_site_id > 0 ? table_fetch_row('sites', 'id = ' . $selected_site_id) : false;

$where = $selected_site_id > 0 ? 'site_id = ' . $selected_site_id : '1=1';
$rows = table_fetch_rows('site_page_overrides', $where, 'updated_at DESC');
?>
<div class="card mb-4">
    <div class="card-header">
        <h1>Site Page Overrides</h1>
    </div>
    <div class="card-body">
        <form method="get" class="mb-3">
            <input type="hidden" name="module" value="site_page_overrides" />
            <input type="hidden" name="action" value="list" />
            <div class="row align-items-end">
                <div class="col-md-6">
                    <label for="site_id">Site</label>
                    <select name="site_id" id="site_id" class="form-control">
                        <?php foreach ($sites as $option) { ?>
                            <option value="<?= (int) $option['id']; ?>" <?= (int) $option['id'] === $selected_site_id ? 'selected="selected"' : ''; ?>>
                                <?= htmlentities($option['website_name']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-primary" type="submit">Filter</button>
                    <a class="btn btn-outline-primary" href="?module=site_page_overrides&action=form&site_id=<?= (int) $selected_site_id; ?>">Add Override</a>
                </div>
            </div>
        </form>

        <?php if ($site !== false) { ?>
            <p><strong>Current site:</strong> <?= htmlentities($site['website_name']); ?> (<?= htmlentities($site['domain']); ?>)</p>
        <?php } ?>

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Page</th>
                    <th>Menu Title</th>
                    <th>Page Title</th>
                    <th>Meta Title</th>
                    <th>Status</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row) {
                    $page = table_fetch_row('page', 'id = ' . (int) $row['page_id']);
                ?>
                    <tr>
                        <td><?= $page !== false ? htmlentities($page['menu_title']) : 'Unknown'; ?></td>
                        <td><?= htmlentities($row['menu_title']); ?></td>
                        <td><?= htmlentities($row['page_title']); ?></td>
                        <td><?= htmlentities($row['meta_title']); ?></td>
                        <td><?= ((int) $row['status'] === 1) ? 'Enabled' : 'Disabled'; ?></td>
                        <td><a class="btn btn-sm btn-outline-primary" href="?module=site_page_overrides&action=form&id=<?= (int) $row['id']; ?>">Edit</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
