<?php
$rows = table_fetch_rows('sites', '', 'is_default DESC, website_name ASC');
?>
<div class="card mb-4">
    <div class="card-header">
        <h1>Sites</h1>
    </div>
    <div class="card-body">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Site</th>
                    <th>Domain</th>
                    <th>Aliases</th>
                    <th>Base URL</th>
                    <th>Default</th>
                    <th>Status</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row) { ?>
                    <tr>
                        <td><?= htmlentities($row['website_name']); ?></td>
                        <td><?= htmlentities($row['domain']); ?></td>
                        <td><?= isset($row['domain_aliases']) ? nl2br(htmlentities($row['domain_aliases'])) : ''; ?></td>
                        <td><?= htmlentities($row['base_url']); ?></td>
                        <td><?= ((int) $row['is_default'] === 1) ? 'Yes' : 'No'; ?></td>
                        <td><?= ((int) $row['status'] === 1) ? 'Enabled' : 'Disabled'; ?></td>
                        <td><a class="btn btn-sm btn-outline-primary" href="?module=sites&action=form&id=<?= (int) $row['id']; ?>">Edit</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
