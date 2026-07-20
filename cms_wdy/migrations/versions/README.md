# Incremental Migrations

Add new database migrations here as ordered `.sql` files.

The runner applies files in natural sort order and records them in `schema_migrations`.

Suggested conventions:

- one change per file
- use descriptive names
- avoid editing an applied migration; add a new migration instead
