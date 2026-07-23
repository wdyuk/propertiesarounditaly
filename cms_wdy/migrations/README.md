# Migrations

This folder keeps the database change history for the CMS.

Legacy SQL dumps such as `base.sql`, `latest.sql`, and `whitehill.sql` are kept here for reference, but the live migration runner only reads incremental files from `versions/`.

Use the runner with:

```bash
php cms_wdy/scripts/migrate.php up
```

Other useful commands:

```bash
php cms_wdy/scripts/migrate.php status
php cms_wdy/scripts/migrate.php list
```

Recommended filename format for new migrations:

```text
YYYYMMDD_HHMMSS_description.sql
```

Keep each migration focused and repeatable.
