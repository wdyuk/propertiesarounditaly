<?php

if (PHP_SAPI !== 'cli') {
	fwrite(STDERR, "This migration runner must be executed from the CLI.\n");
	exit(1);
}

$projectRoot = dirname(__DIR__);
$configPath = $projectRoot . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'config.php';
$migrationDir = $projectRoot . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR . 'versions';

if (!is_file($configPath)) {
	fwrite(STDERR, "Unable to locate cms_wdy/includes/config.php.\n");
	exit(1);
}

require_once $configPath;

if (!isset($conn) || !($conn instanceof PDO)) {
	fwrite(STDERR, "Database connection was not initialised by config.php.\n");
	exit(1);
}

if (!is_dir($migrationDir)) {
	fwrite(STDERR, "Migration directory not found: {$migrationDir}\n");
	exit(1);
}

$command = $argv[1] ?? 'up';

ensureMigrationTable($conn);

switch ($command) {
	case 'up':
		runPendingMigrations($conn, $migrationDir);
		break;
	case 'status':
		showMigrationStatus($conn, $migrationDir);
		break;
	case 'list':
		showMigrationList($migrationDir);
		break;
	default:
		fwrite(STDERR, "Usage: php cms_wdy/scripts/migrate.php [up|status|list]\n");
		exit(1);
}

function ensureMigrationTable(PDO $conn): void
{
	$sql = <<<SQL
CREATE TABLE IF NOT EXISTS schema_migrations (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    filename VARCHAR(255) NOT NULL,
    checksum CHAR(64) NOT NULL,
    applied_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_schema_migrations_filename (filename)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
SQL;

	$conn->exec($sql);
}

function runPendingMigrations(PDO $conn, string $migrationDir): void
{
	$migrations = getMigrationFiles($migrationDir);
	$applied = getAppliedMigrations($conn);
	$ran = 0;

	if (empty($migrations)) {
		echo "No migration files found in {$migrationDir}\n";
		return;
	}

	foreach ($migrations as $migration) {
		$filename = $migration['filename'];
		$path = $migration['path'];
		$checksum = hash_file('sha256', $path);

		if (isset($applied[$filename])) {
			if ($applied[$filename]['checksum'] !== $checksum) {
				fwrite(STDERR, "Checksum mismatch for already-applied migration: {$filename}\n");
				fwrite(STDERR, "The file has changed since it was applied. Stop and reconcile the history before continuing.\n");
				exit(1);
			}

			echo "[SKIP]  {$filename}\n";
			continue;
		}

		echo "[RUN]   {$filename}\n";
		$sql = file_get_contents($path);
		if ($sql === false) {
			fwrite(STDERR, "Unable to read migration file: {$path}\n");
			exit(1);
		}

		$statements = parseSqlStatements($sql);
		if (empty($statements)) {
			echo "        No executable SQL found, marking as applied.\n";
		}

		try {
			foreach ($statements as $statement) {
				$conn->exec($statement);
			}

			$stmt = $conn->prepare(
				'INSERT INTO schema_migrations (filename, checksum, applied_at) VALUES (:filename, :checksum, NOW())'
			);
			$stmt->execute([
				':filename' => $filename,
				':checksum' => $checksum,
			]);

			$ran++;
			echo "        Applied successfully.\n";
		} catch (Throwable $e) {
			fwrite(STDERR, "Migration failed: {$filename}\n");
			fwrite(STDERR, $e->getMessage() . "\n");
			exit(1);
		}
	}

	echo "Done. Applied {$ran} migration(s).\n";
}

function showMigrationStatus(PDO $conn, string $migrationDir): void
{
	$migrations = getMigrationFiles($migrationDir);
	$applied = getAppliedMigrations($conn);

	if (empty($migrations)) {
		echo "No migration files found in {$migrationDir}\n";
		return;
	}

	foreach ($migrations as $migration) {
		$filename = $migration['filename'];
		$checksum = hash_file('sha256', $migration['path']);

		if (isset($applied[$filename])) {
			$status = $applied[$filename]['checksum'] === $checksum ? 'applied' : 'modified';
			$appliedAt = $applied[$filename]['applied_at'];
		} else {
			$status = 'pending';
			$appliedAt = '-';
		}

		echo sprintf("%-10s %-45s %s\n", strtoupper($status), $filename, $appliedAt);
	}
}

function showMigrationList(string $migrationDir): void
{
	$migrations = getMigrationFiles($migrationDir);

	if (empty($migrations)) {
		echo "No migration files found in {$migrationDir}\n";
		return;
	}

	foreach ($migrations as $migration) {
		echo $migration['filename'] . PHP_EOL;
	}
}

function getMigrationFiles(string $migrationDir): array
{
	$files = glob($migrationDir . DIRECTORY_SEPARATOR . '*.sql') ?: [];
	natsort($files);

	$migrations = [];
	foreach ($files as $file) {
		$migrations[] = [
			'filename' => basename($file),
			'path' => $file,
		];
	}

	return $migrations;
}

function getAppliedMigrations(PDO $conn): array
{
	$stmt = $conn->query('SELECT filename, checksum, applied_at FROM schema_migrations ORDER BY id ASC');
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$applied = [];
	foreach ($rows as $row) {
		$applied[$row['filename']] = $row;
	}

	return $applied;
}

function parseSqlStatements(string $sql): array
{
	$sql = preg_replace('/^\xEF\xBB\xBF/', '', $sql);
	$sql = preg_replace('/^\s*--.*$/m', '', $sql);
	$sql = preg_replace('/^\s*#.*$/m', '', $sql);
	$sql = preg_replace('/\/\*.*?\*\//s', '', $sql);

	$parts = explode(';', $sql);
	$statements = [];

	foreach ($parts as $part) {
		$statement = trim($part);
		if ($statement !== '') {
			$statements[] = $statement;
		}
	}

	return $statements;
}
