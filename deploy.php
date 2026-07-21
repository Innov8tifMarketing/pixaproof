<?php

namespace Deployer;

require 'recipe/laravel.php';

// ═══════════════════════════════════════════════════════════════════════════
// TEMPLATE VARIABLES - Replace these for your project
// ═══════════════════════════════════════════════════════════════════════════
//
// Search and replace the following placeholders:
//   {{APP_NAME}}        -> Your application name (e.g., 'My Laravel App')
//   {{REPOSITORY}}      -> Your Git repository URL (e.g., 'git@github.com:user/repo.git')
//   {{SERVER_IP}}       -> Your server IP or hostname (e.g., '192.168.1.100')
//   {{DEPLOY_PATH}}     -> Production deploy path (e.g., '/home/deployer/myapp')
//   {{STAGING_PATH}}    -> Staging deploy path (e.g., '/home/deployer/myapp-staging')
//   {{PROD_URL}}        -> Production URL (e.g., 'https://myapp.com')
//   {{STAGING_URL}}     -> Staging URL (e.g., 'https://staging.myapp.com')
//   {{WORKER_PREFIX}}   -> Queue worker prefix (e.g., 'myapp')
//
// ═══════════════════════════════════════════════════════════════════════════

set('application', 'Pixaproof');
set('repository', 'git@github.com:cothinking-dev/pixaproof.git');
set('keep_releases', 5);
set('php_version', '8.4');

// Default timeout for commands (5 minutes)
set('default_timeout', 300);

// Use ACL for writable directories - works with shared dirs owned by different users
set('writable_mode', 'acl');
set('writable_use_sudo', false);

set('forward_agent', false);

// Use clone strategy for git-lfs; skip smudge during clone (LFS pulled separately)
set('update_code_strategy', 'clone');
set('env', ['GIT_LFS_SKIP_SMUDGE' => '1']);

// ═══════════════════════════════════════════════════════════════════════════
// HOSTS
// ═══════════════════════════════════════════════════════════════════════════

host('prod')
    ->setHostname('47.237.191.213')
    ->set('remote_user', 'deployer')
    ->set('deploy_path', '/home/deployer/pixaproof')
    ->set('branch', 'main')
    ->set('labels', ['stage' => 'prod'])
    ->set('url', 'https://pixaproof.com');

// ═══════════════════════════════════════════════════════════════════════════
// SHARED RESOURCES
// ═══════════════════════════════════════════════════════════════════════════

// Laravel recipe sets: storage, .env
// Project-specific shared directories with organized structure
add('shared_dirs', [
    'data/sqlite',
    'data/media',
    'data/backups',
    'cache/npm',
]);

add('writable_dirs', [
    'data/sqlite',
    'data/media',
]);

// Custom storage links (public/ -> shared/)
set('storage_links', [
    'storage' => 'storage/app/public',
    'media' => 'data/media',
]);

// Queue worker name for Supervisor
set('queue_worker_name', fn () => 'pixaproof-'.getStage().'-worker');

// ═══════════════════════════════════════════════════════════════════════════
// DATABASE PATHS
// ═══════════════════════════════════════════════════════════════════════════

set('sqlite_path', '{{deploy_path}}/shared/data/sqlite/database.sqlite');
set('migrate_backup_path', '{{deploy_path}}/shared/data/backups');

// ═══════════════════════════════════════════════════════════════════════════
// MIGRATION & BACKUP SETTINGS
// ═══════════════════════════════════════════════════════════════════════════

set('migrate_backup_keep', 5);

// ═══════════════════════════════════════════════════════════════════════════
// OFFSITE BACKUP SETTINGS (Backblaze B2 via rclone)
// ═══════════════════════════════════════════════════════════════════════════

// rclone is installed as a no-sudo static binary (shared with the innov8tif
// deploy on this box); the `b2` remote lives in deployer's
// ~/.config/rclone/rclone.conf (chmod 600). Backups land under a pixaproof/
// prefix in the shared bucket.
set('rclone_bin', '/home/deployer/bin/rclone');
set('rclone_remote', 'b2');
set('offsite_bucket', 'doom-innov8tif-backup');
set('offsite_prefix', 'pixaproof');

// Rolling GFS retention for the offsite DB snapshots: keep the last 7 daily
// snapshots + the last 8 weekly snapshots (one per ISO week) = max 15
// point-in-time copies. Pruned copies are hard-deleted so the total is capped.
set('offsite_keep_daily', 7);
set('offsite_keep_weekly', 8);

// Server-only, non-git paths mirrored offsite (relative to {{deploy_path}}/shared).
set('offsite_media_paths', [
    'data/media',           // runtime uploads served at /media
    'storage/app/public',   // public disk (served at /storage)
    'storage/app/private',  // private disk
]);

// ═══════════════════════════════════════════════════════════════════════════
// HEALTH CHECK SETTINGS
// ═══════════════════════════════════════════════════════════════════════════

set('verify_timeout', 15);
set('verify_retries', 5);
set('verify_retry_delay', 2);

// ═══════════════════════════════════════════════════════════════════════════
// HELPERS
// ═══════════════════════════════════════════════════════════════════════════

function getStage(): string
{
    $labels = get('labels', []);

    return $labels['stage'] ?? 'unknown';
}

/**
 * Keep only the newest $keep files in an rclone remote dir (filenames carry a
 * sortable timestamp), hard-deleting the rest so no B2 hidden versions linger.
 */
function offsitePruneKeep(string $rclone, string $path, int $keep): void
{
    $out = run("{$rclone} lsf {$path} --files-only 2>/dev/null || echo ''");
    $files = array_values(array_filter(explode("\n", trim($out))));
    sort($files);
    $excess = count($files) - $keep;
    for ($i = 0; $i < $excess; $i++) {
        run("{$rclone} deletefile --b2-hard-delete {$path}/{$files[$i]}");
    }
}

// ═══════════════════════════════════════════════════════════════════════════
// TASKS
// ═══════════════════════════════════════════════════════════════════════════

desc('Ensure SQLite database file exists');
task('db:ensure-sqlite', function () {
    $sqlitePath = get('sqlite_path');
    $sqliteDir = dirname($sqlitePath);

    if (test("[ -f {$sqlitePath} ]")) {
        info('SQLite database exists');

        return;
    }

    info('Creating SQLite database file...');
    run("mkdir -p {$sqliteDir}");
    run("touch {$sqlitePath}");
    run("chmod 664 {$sqlitePath}");
    info('SQLite database created');
});

desc('Backup SQLite database before migrations');
task('db:backup', function () {
    $sqlitePath = get('sqlite_path');
    $backupPath = get('migrate_backup_path');
    $keepBackups = get('migrate_backup_keep', 5);
    $timestamp = date('Y-m-d-His');
    $stage = getStage();

    // Skip if database doesn't exist or is empty
    if (! test("[ -f {$sqlitePath} ]")) {
        info('No database to backup');

        return;
    }

    $fileSize = run("stat -f%z {$sqlitePath} 2>/dev/null || stat -c%s {$sqlitePath} 2>/dev/null || echo '0'");
    if ((int) trim($fileSize) === 0) {
        info('Database is empty, skipping backup');

        return;
    }

    // Create backup
    run("mkdir -p {$backupPath}");
    $backupFile = "{$backupPath}/database_{$stage}_{$timestamp}.sqlite";

    run("cp {$sqlitePath} {$backupFile}");
    $sizeKb = round((int) $fileSize / 1024, 2);
    info("Backup created: {$backupFile} ({$sizeKb} KB)");

    // Clean up old backups
    $backups = run("ls -1t {$backupPath}/database_{$stage}_*.sqlite 2>/dev/null || echo ''");
    $backupFiles = array_filter(explode("\n", trim($backups)));

    if (count($backupFiles) > $keepBackups) {
        $toRemove = array_slice($backupFiles, $keepBackups);
        foreach ($toRemove as $file) {
            run("rm -f {$file}");
        }
        info('Cleaned up '.count($toRemove).' old backup(s)');
    }
});

desc('List available database backups');
task('db:backups', function () {
    $backupPath = get('migrate_backup_path');
    $backups = run("ls -lh {$backupPath}/*.sqlite 2>/dev/null || echo 'No backups found'");
    writeln($backups);
});

desc('Restore database from backup');
task('db:restore', function () {
    $backupPath = get('migrate_backup_path');
    $stage = getStage();
    $sqlitePath = get('sqlite_path');

    $backups = run("ls -1t {$backupPath}/database_{$stage}_*.sqlite 2>/dev/null || echo ''");
    $backupFiles = array_filter(explode("\n", trim($backups)));

    if (empty($backupFiles)) {
        warning('No backups found');

        return;
    }

    writeln('Available backups:');
    foreach ($backupFiles as $i => $file) {
        $size = run("ls -lh {$file} | awk '{print \$5}'");
        writeln("  [{$i}] ".basename($file)." ({$size})");
    }

    $choice = ask('Enter backup number to restore:', '0');
    $selectedBackup = $backupFiles[(int) $choice] ?? null;

    if (! $selectedBackup) {
        warning('Invalid selection');

        return;
    }

    if (! askConfirmation('This will OVERWRITE the current database. Continue?', false)) {
        info('Restore cancelled');

        return;
    }

    // Put app in maintenance mode
    if (test('[ -f {{deploy_path}}/current/artisan ]')) {
        run('cd {{deploy_path}}/current && {{bin/php}} artisan down --retry=60');
    }

    info('Restoring from: '.basename($selectedBackup));
    run("cp {$selectedBackup} {$sqlitePath}");
    info('Database restored');

    // Bring app back up
    if (test('[ -f {{deploy_path}}/current/artisan ]')) {
        run('cd {{deploy_path}}/current && {{bin/php}} artisan up');
    }
});

// ═══════════════════════════════════════════════════════════════════════════
// TASKS: OFFSITE BACKUP (Backblaze B2)
// ═══════════════════════════════════════════════════════════════════════════

desc('Back up SQLite DB + media + .env offsite to Backblaze B2');
task('backup:offsite', function () {
    $stage = getStage();
    $rclone = get('rclone_bin');
    $remote = get('rclone_remote');
    $bucket = get('offsite_bucket');
    $prefix = get('offsite_prefix');
    $keepDaily = get('offsite_keep_daily', 7);
    $keepWeekly = get('offsite_keep_weekly', 8);
    $mediaPaths = get('offsite_media_paths', []);
    $keepLocal = get('migrate_backup_keep', 5);
    $timestamp = date('Y-m-d-His');
    $sqlitePath = get('sqlite_path');

    $shared = '{{deploy_path}}/shared';
    $base = "{$remote}:{$bucket}/{$prefix}";

    // Preflight: rclone present + remote/bucket reachable.
    if (! test("[ -x {$rclone} ]")) {
        throw new \RuntimeException("rclone not found at {$rclone} — run the offsite tooling install first");
    }
    run("{$rclone} lsd {$remote}:{$bucket} > /dev/null");

    // 1. SQLite — consistent online snapshot via .backup (handles WAL), then
    //    integrity-checked, gzipped, atomic. `cp` would miss in-flight writes.
    if (! test("[ -f {$sqlitePath} ]")) {
        throw new \RuntimeException("SQLite db not found at {$sqlitePath}");
    }
    $localDbDir = "{$shared}/data/backups";
    $dbFile = "{$localDbDir}/database_{$stage}_{$timestamp}.sqlite.gz";
    $tmpSnap = "{$localDbDir}/.snap_{$timestamp}.sqlite";

    $dumpCmd = <<<BASH
        set -eo pipefail
        mkdir -p {$localDbDir}
        rm -f {$tmpSnap} {$dbFile}.tmp
        sqlite3 {$sqlitePath} ".backup '{$tmpSnap}'"
        [ "\$(sqlite3 {$tmpSnap} 'PRAGMA integrity_check;')" = "ok" ]
        gzip -c {$tmpSnap} > {$dbFile}.tmp
        gzip -t {$dbFile}.tmp
        mv {$dbFile}.tmp {$dbFile}
        rm -f {$tmpSnap}
        BASH;
    run($dumpCmd);
    $dbName = basename($dbFile);
    info("SQLite snapshot created: {$dbName}");

    run("{$rclone} copy {$dbFile} {$base}/db/daily/ --transfers 4");
    run("{$rclone} check {$localDbDir} {$base}/db/daily --include {$dbName} --one-way");
    info("Daily SQLite snapshot uploaded + verified → {$base}/db/daily/{$dbName}");

    // Promote to a WEEKLY snapshot once per ISO week (first run of the week).
    $isoWeek = date('o-\WW'); // e.g. 2026-W28
    $weeklyHas = (int) trim(run("{$rclone} lsf {$base}/db/weekly/ 2>/dev/null | grep -c '_{$isoWeek}_' || true"));
    if ($weeklyHas === 0) {
        run("{$rclone} copyto {$dbFile} {$base}/db/weekly/database_{$stage}_{$isoWeek}_{$timestamp}.sqlite.gz");
        info("Weekly SQLite snapshot created for {$isoWeek}");
    }

    // 2. Media dirs — incremental mirror.
    foreach ($mediaPaths as $rel) {
        $src = "{$shared}/{$rel}";
        $dst = "{$base}/files/{$rel}";
        if (! test("[ -d {$src} ]")) {
            warning("Skipping missing media path: {$rel}");

            continue;
        }
        run("{$rclone} sync {$src} {$dst} --fast-list --transfers 8 --checkers 16 --exclude 'livewire-tmp/**'", timeout: 1800);
        info("Mirrored: {$rel}");
    }

    // 3. Secrets — .env to the private bucket (B2 encrypts server-side at rest).
    // Fixed name, overwritten each run; prior versions are retained 30d by the
    // bucket's B2 versioning lifecycle. Dated + age-pruned would NOT work here:
    // copyto preserves the source .env's mtime, which B2 reports back verbatim,
    // so --min-age deletes a freshly-uploaded but long-unchanged .env at once.
    run("{$rclone} copyto {$shared}/.env {$base}/config/env_{$stage}.env");
    info('.env uploaded');

    // 4. Retention — rolling GFS: keep the last N daily + M weekly snapshots.
    offsitePruneKeep($rclone, "{$base}/db/daily", $keepDaily);
    offsitePruneKeep($rclone, "{$base}/db/weekly", $keepWeekly);
    info("Offsite retention applied (keep {$keepDaily} daily + {$keepWeekly} weekly)");

    $backups = run("ls -1t {$localDbDir}/database_{$stage}_*.sqlite.gz 2>/dev/null || echo ''");
    $files = array_filter(explode("\n", trim($backups)));
    if (count($files) > $keepLocal) {
        foreach (array_slice($files, $keepLocal) as $old) {
            run("rm -f {$old}");
        }
    }

    info("Offsite backup complete — stage={$stage} @ {$timestamp}");
});

desc('List offsite backups on Backblaze B2');
task('backup:offsite:list', function () {
    $rclone = get('rclone_bin');
    $base = get('rclone_remote').':'.get('offsite_bucket').'/'.get('offsite_prefix');

    writeln('── DB snapshots: daily ──');
    writeln(run("{$rclone} lsl {$base}/db/daily 2>/dev/null || echo '(none)'"));
    writeln('── DB snapshots: weekly ──');
    writeln(run("{$rclone} lsl {$base}/db/weekly 2>/dev/null || echo '(none)'"));
    writeln('── Media mirror (top level) ──');
    writeln(run("{$rclone} lsd {$base}/files 2>/dev/null || echo '(none)'"));
    writeln('── Config (.env) ──');
    writeln(run("{$rclone} lsl {$base}/config 2>/dev/null || echo '(none)'"));
});

desc('Run migrations safely with backup');
task('migrate:safe', function () {
    // Check for pending migrations
    $status = run('cd {{release_path}} && {{bin/php}} artisan migrate:status --pending 2>&1 || echo "NO_PENDING"');

    if (str_contains($status, 'NO_PENDING') || str_contains($status, 'Nothing to migrate') || str_contains($status, 'No pending migrations')) {
        info('No pending migrations');

        return;
    }

    info('Pending migrations detected');

    // Backup before migrating
    try {
        invoke('db:backup');
    } catch (\Throwable $e) {
        warning('Backup failed: '.$e->getMessage());
        if (! askConfirmation('Continue without backup?', false)) {
            throw new \RuntimeException('Migration aborted: backup failed');
        }
    }

    // Run migrations
    info('Running migrations...');
    $output = run('cd {{release_path}} && {{bin/php}} artisan migrate --force 2>&1', timeout: 300);
    writeln($output);
    info('Migrations completed');
});

desc('Restart PHP-FPM');
task('php-fpm:restart', function () {
    $version = get('php_version', '8.4');

    run("sudo systemctl restart php{$version}-fpm");

    // Wait for FPM to be ready
    $maxAttempts = 10;
    for ($attempt = 0; $attempt < $maxAttempts; $attempt++) {
        $status = run("systemctl is-active php{$version}-fpm 2>/dev/null || echo 'inactive'");
        if (trim($status) === 'active') {
            info("PHP {$version}-FPM restarted");

            return;
        }
        run('sleep 0.5');
    }

    throw new \RuntimeException('PHP-FPM failed to restart');
});

desc('Restart queue workers via Supervisor');
task('queue:restart', function () {
    $workerName = get('queue_worker_name', '');

    if (empty($workerName)) {
        return;
    }

    // Check if worker exists
    $status = run("sudo supervisorctl status {$workerName}:* 2>&1 || echo 'NOT_FOUND'");

    if (str_contains($status, 'NOT_FOUND') || str_contains($status, 'no such')) {
        info("Queue worker {$workerName} not configured, reloading supervisor...");
        run('sudo supervisorctl reread');
        run('sudo supervisorctl update');

        return;
    }

    run("sudo supervisorctl restart {$workerName}:*");
    info('Queue workers restarted');
});

desc('Show queue worker status');
task('queue:status', function () {
    $workerName = get('queue_worker_name', '');

    if (empty($workerName)) {
        warning('queue_worker_name not set');

        return;
    }

    $status = run("sudo supervisorctl status {$workerName}:* 2>&1 || echo 'Not configured'");
    writeln($status);
});

desc('Verify deployment health via HTTP check');
task('deploy:verify', function () {
    $url = get('url');
    $timeout = get('verify_timeout', 15);
    $retries = get('verify_retries', 5);
    $retryDelay = get('verify_retry_delay', 2);

    if (empty($url)) {
        warning('No URL configured for verification');

        return;
    }

    info('Verifying deployment health...');
    run('sleep 2'); // Wait for services to stabilize

    $passed = false;
    $lastStatusCode = '000';

    for ($attempt = 1; $attempt <= $retries; $attempt++) {
        info("Health check attempt {$attempt}/{$retries}...");

        $result = runLocally(
            "curl -s -o /dev/null -w '%{http_code}' -L --max-time {$timeout} --insecure {$url} 2>/dev/null || echo '000'"
        );
        $lastStatusCode = trim($result);

        if (in_array($lastStatusCode, ['200', '301', '302', '303', '307', '308'])) {
            $passed = true;
            break;
        }

        warning("Attempt {$attempt}: HTTP {$lastStatusCode}");
        if ($attempt < $retries) {
            run("sleep {$retryDelay}");
        }
    }

    if (! $passed) {
        warning("Health check failed (HTTP {$lastStatusCode})");

        // Show recent logs
        writeln('Recent Laravel logs:');
        run('tail -30 {{deploy_path}}/shared/storage/logs/laravel.log 2>/dev/null || echo "No logs"');

        set('health_check_failed', true);
        throw new \RuntimeException("Deployment verification failed: HTTP {$lastStatusCode}");
    }

    info("Health check passed (HTTP {$lastStatusCode})");
});

desc('Rollback to previous release');
task('rollback', function () {
    $releases = get('releases_list');

    if (count($releases) < 2) {
        warning('No previous release available');

        return;
    }

    $currentRelease = $releases[0];
    $previousRelease = $releases[1];

    info("Rolling back from {$currentRelease} to {$previousRelease}...");

    // Maintenance mode
    if (test('[ -f {{deploy_path}}/current/artisan ]')) {
        run('cd {{deploy_path}}/current && {{bin/php}} artisan down --retry=60 2>/dev/null || true');
    }

    // Update symlink
    run('cd {{deploy_path}} && {{bin/symlink}} releases/'.$previousRelease.' current');

    // Restart services
    invoke('php-fpm:restart');
    invoke('queue:restart');

    // Bring app up
    run('cd {{deploy_path}}/current && {{bin/php}} artisan up');

    info("Rolled back to: {$previousRelease}");
});

desc('Automatic rollback on deploy failure');
task('deploy:rollback-on-failure', function () {
    $releases = get('releases_list');

    if (count($releases) < 2) {
        return;
    }

    $healthCheckFailed = has('health_check_failed') && get('health_check_failed');

    if ($healthCheckFailed) {
        warning('Health check failed, initiating rollback...');
        invoke('rollback');
    }
});

desc('Show last 50 lines of Laravel log');
task('artisan:log', function () {
    run('tail -50 {{deploy_path}}/current/storage/logs/laravel.log 2>/dev/null || echo "No log file"');
});

desc('Put application in maintenance mode');
task('artisan:down', function () {
    if (! test('[ -f {{deploy_path}}/current/artisan ]')) {
        return;
    }

    $secret = bin2hex(random_bytes(16));
    run("cd {{deploy_path}}/current && {{bin/php}} artisan down --secret={$secret} --retry=60");
    info("Maintenance mode enabled (secret: {$secret})");
});

desc('Bring application out of maintenance mode');
task('artisan:up', function () {
    run('cd {{release_path}} && {{bin/php}} artisan up');
    info('Application is live');
});

desc('Clear and rebuild caches');
task('artisan:cache:refresh', function () {
    within('{{release_path}}', function () {
        // Cache clear may fail if Redis not installed - continue anyway
        run('{{bin/php}} artisan cache:clear 2>/dev/null || true');
        run('{{bin/php}} artisan config:clear');
        run('{{bin/php}} artisan route:clear');
        run('{{bin/php}} artisan view:clear');
        run('{{bin/php}} artisan config:cache');
        run('{{bin/php}} artisan route:cache');
        run('{{bin/php}} artisan view:cache');
    });
    info('Caches refreshed');
});

desc('NPM install');
task('npm:install', function () {
    run('cd {{release_path}} && npm ci --cache={{deploy_path}}/shared/cache/npm --prefer-offline');
});

desc('NPM build');
task('npm:build', function () {
    run('cd {{release_path}} && npm run build');
});

desc('Create custom storage symlinks');
task('storage:link-custom', function () {
    $links = get('storage_links', []);

    foreach ($links as $link => $target) {
        $linkPath = "{{release_path}}/public/{$link}";
        $targetPath = "{{deploy_path}}/shared/{$target}";

        // Ensure target directory exists
        run("mkdir -p {$targetPath}");

        // Skip if link already exists and points to correct target
        if (test("[ -L {$linkPath} ]")) {
            continue;
        }

        // Remove if exists but not a symlink (e.g., directory from git)
        if (test("[ -e {$linkPath} ]")) {
            info("Removing existing {$link} directory to create symlink");
            run("rm -rf {$linkPath}");
        }

        run("ln -s {$targetPath} {$linkPath}");
        info("Created symlink: {$link} -> shared/{$target}");
    }
});

// ═══════════════════════════════════════════════════════════════════════════
// TASKS: GIT LFS
// ═══════════════════════════════════════════════════════════════════════════

desc('Pull git-lfs objects from remote after code checkout');
task('lfs:pull', function () {
    $repo = get('repository');
    run("cd {{release_path}} && git remote set-url origin {$repo}");

    try {
        run('cd {{release_path}} && git lfs pull', timeout: 600);
        info('LFS objects pulled from remote');

        return;
    } catch (\Throwable $e) {
        warning('git lfs pull failed: '.trim($e->getMessage()));
    }

    // GitHub LFS bandwidth/budget can be exhausted. The video assets under
    // public/videos rarely change, so fall back to reusing the objects the
    // previous release already materialised instead of blocking the deploy.
    if (! has('previous_release')) {
        throw new \RuntimeException('git lfs pull failed and there is no previous release to reuse LFS objects from');
    }

    $prev = get('previous_release');
    if (! test("[ -d {$prev}/public/videos ]")) {
        throw new \RuntimeException("git lfs pull failed and previous release has no public/videos to reuse ({$prev})");
    }

    run("cp -a {$prev}/public/videos/. {{release_path}}/public/videos/");
    info('git lfs pull failed — reused video assets from previous release ('.basename($prev).')');
});

// ═══════════════════════════════════════════════════════════════════════════
// DEPLOYMENT HOOKS
// ═══════════════════════════════════════════════════════════════════════════

// After code checkout, pull LFS objects from GitHub
after('deploy:update_code', 'lfs:pull');

// After vendors installed, rebuild config cache
after('deploy:vendors', 'artisan:config:cache');

// NPM install and build
after('artisan:config:cache', 'npm:install');
after('npm:install', 'npm:build');

// Ensure SQLite exists
after('npm:build', 'db:ensure-sqlite');

// Backup and migrate
after('db:ensure-sqlite', 'db:backup');
after('db:backup', 'migrate:safe');

// Before symlink switch - maintenance mode
before('deploy:symlink', 'artisan:down');

// After symlink - restart services
after('deploy:symlink', 'php-fpm:restart');
after('deploy:symlink', 'artisan:up');
after('deploy:symlink', 'queue:restart');
after('deploy:symlink', 'artisan:cache:refresh');

// Custom storage links
after('artisan:storage:link', 'storage:link-custom');

// Disable default Laravel recipe migration (we use migrate:safe instead)
task('artisan:migrate', function () {
    // Disabled - migrations handled by migrate:safe task
})->hidden();

// Verify deployment
after('deploy:symlink', 'deploy:verify');

// On failure
fail('deploy', 'deploy:rollback-on-failure');
fail('deploy', 'deploy:unlock');
