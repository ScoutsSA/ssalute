<?php

namespace App\Sync\Types;

use Illuminate\Contracts\Process\ProcessResult;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;
use Rouxtaccess\Sync\Contracts\SyncType;
use Rouxtaccess\Sync\Field;
use Rouxtaccess\Sync\SyncResult;

use function Laravel\Prompts\spin;

/**
 * Pulls server logs that the stock files-over-ssh type cannot reach: single files,
 * shell globs, and paths readable only by root.
 *
 * It streams a tar over ssh rather than using rsync, because rsync binds the remote
 * stdin to its own protocol, leaving sudo no way to read a password. Here sudo reads
 * the password from stdin before tar begins writing, so the password never appears
 * in an argument list on either machine.
 *
 * The trade-off is that every run transfers the whole source; there is no
 * incremental comparison. That suits log files and would not suit a large tree.
 */
class LogsOverSshSyncType implements SyncType
{
    /**
     * Characters allowed in the final path segment, which is left unquoted so the
     * remote shell can expand a glob. Anything else is refused rather than escaped.
     */
    protected const SAFE_TARGET = '/^[A-Za-z0-9._*?\[\]-]+$/';

    public static function key(): string
    {
        return 'logs-over-ssh';
    }

    public static function label(): string
    {
        return 'Logs — tar over SSH, with optional sudo';
    }

    public function fields(): array
    {
        return [
            new Field('ssh', 'SSH target', placeholder: 'forge@1.2.3.4'),
            new Field(
                'remote_path',
                'Remote path',
                placeholder: '/var/log/php*-fpm.log*',
                hint: 'A file, a shell glob, or a directory. End a directory with / to copy its contents.',
            ),
            new Field('local_path', 'Local path', placeholder: 'storage/logs/production-logs'),
            new Field('sudo', 'Read the logs as root via sudo?', required: false, boolean: true, default: true),
            new Field(
                'sudo_password',
                'Sudo password',
                required: false,
                secret: true,
                hint: 'Stored in plain text in the sync store. Leave empty if the SSH user has passwordless sudo.',
            ),
            new Field(
                'exclude',
                'Exclude patterns, comma separated',
                required: false,
                placeholder: '*access.log*',
                cast: $this->splitPatterns(...),
            ),
        ];
    }

    public function summary(array $job): array
    {
        $config = $job['config'] ?? [];
        $excludes = $this->excludePatterns($config);

        return [
            ['Type', self::label()],
            ['Source', "{$config['ssh']}:{$config['remote_path']}"],
            ['Destination', $config['local_path']],
            ['Read as', $this->describeRemoteUser($config)],
            ['Excludes', $excludes === [] ? 'none' : implode(', ', $excludes)],
        ];
    }

    public function run(array $job, bool $interactive): SyncResult
    {
        $config = $job['config'] ?? [];
        [$directory, $target] = $this->splitRemotePath($config['remote_path']);

        if (! preg_match(self::SAFE_TARGET, $target)) {
            return SyncResult::failure("Refusing to run: '{$target}' contains characters that are unsafe to leave unquoted for the remote shell.");
        }

        $destination = rtrim($config['local_path'], '/') . '/';
        $archive = $this->archivePath($job);
        $source = "{$config['ssh']}:{$config['remote_path']}";

        File::ensureDirectoryExists($destination);
        File::ensureDirectoryExists(dirname($archive));

        try {
            $fetched = spin(
                message: "Fetching {$source}…",
                callback: fn (): ProcessResult => Process::timeout(0)
                    ->input($this->stdin($config))
                    ->run($this->fetchCommand($config, $directory, $target, $archive)),
            );

            if ($fetched->failed()) {
                return SyncResult::failure(trim($fetched->errorOutput()) ?: 'Could not read the remote logs.');
            }

            $extracted = Process::timeout(0)->run(['tar', 'xzf', $archive, '-C', $destination]);

            if ($extracted->failed()) {
                return SyncResult::failure(trim($extracted->errorOutput()) ?: 'Could not unpack the fetched logs.');
            }
        } finally {
            File::delete($archive);
        }

        return SyncResult::success("Synced {$source} → {$destination}.");
    }

    /**
     * The remote tar, wrapped in ssh and redirected into a local archive. The
     * archive is staged on disk rather than piped so that a failure anywhere is
     * reported by its own exit code, and so a large log never sits in memory.
     *
     * @param  array<string, mixed>  $config
     */
    protected function fetchCommand(array $config, string $directory, string $target, string $archive): string
    {
        return sprintf(
            'ssh %s %s > %s',
            escapeshellarg($config['ssh']),
            escapeshellarg($this->remoteCommand($config, $directory, $target)),
            escapeshellarg($archive),
        );
    }

    /**
     * The directory is entered with `cd` inside the remote shell rather than with
     * tar's own `-C`, because a glob has to be expanded by a shell that can read
     * the directory. ssh starts that shell in the login directory, and the log
     * directories are often unreadable to the SSH user, so the shell itself is the
     * one run under sudo.
     *
     * @param  array<string, mixed>  $config
     */
    protected function remoteCommand(array $config, string $directory, string $target): string
    {
        $tar = ['tar', 'czf', '-'];

        foreach ($this->excludePatterns($config) as $pattern) {
            $tar[] = '--exclude=' . escapeshellarg($pattern);
        }

        $tar[] = $target;

        $script = 'cd ' . escapeshellarg($directory) . ' && ' . implode(' ', $tar);

        return $this->sudoPrefix($config) . 'sh -c ' . escapeshellarg($script);
    }

    /**
     * `-S` reads the password from stdin; `-p ''` silences the prompt so it cannot
     * be mistaken for tar output. Without a password configured, `-n` makes sudo
     * fail immediately rather than block on a prompt nobody can answer.
     *
     * @param  array<string, mixed>  $config
     */
    protected function sudoPrefix(array $config): string
    {
        if (! data_get($config, 'sudo')) {
            return '';
        }

        return $this->sudoPassword($config) === '' ? 'sudo -n ' : "sudo -S -p '' ";
    }

    /**
     * @param  array<string, mixed>  $config
     */
    protected function stdin(array $config): string
    {
        $password = $this->sudoPassword($config);

        return data_get($config, 'sudo') && $password !== '' ? "{$password}\n" : '';
    }

    /**
     * @param  array<string, mixed>  $config
     */
    protected function sudoPassword(array $config): string
    {
        return trim((string) data_get($config, 'sudo_password', ''));
    }

    /**
     * @param  array<string, mixed>  $config
     */
    protected function describeRemoteUser(array $config): string
    {
        if (! data_get($config, 'sudo')) {
            return 'the SSH user';
        }

        return $this->sudoPassword($config) === ''
            ? 'root (passwordless sudo)'
            : 'root (sudo, password from the sync store)';
    }

    /**
     * Splits the configured path into the directory tar runs in and the entry it
     * archives, so that a file, a glob and a directory all take the same shape.
     *
     * @return array{0: string, 1: string}
     */
    protected function splitRemotePath(string $path): array
    {
        if (str_ends_with($path, '/')) {
            return [rtrim($path, '/'), '.'];
        }

        return [dirname($path), basename($path)];
    }

    /**
     * @param  array<string, mixed>  $job
     */
    protected function archivePath(array $job): string
    {
        $name = preg_replace('/[^A-Za-z0-9_-]+/', '-', (string) ($job['name'] ?? 'logs'));

        return storage_path("framework/sync-{$name}.tar.gz");
    }

    /**
     * @param  array<string, mixed>  $config
     * @return array<int, string>
     */
    protected function excludePatterns(array $config): array
    {
        return $this->splitPatterns(data_get($config, 'exclude'));
    }

    /**
     * @return array<int, string>
     */
    protected function splitPatterns(mixed $value): array
    {
        $patterns = is_array($value) ? $value : explode(',', (string) $value);

        return array_values(array_filter(array_map(
            fn (mixed $pattern): string => trim((string) $pattern),
            $patterns,
        )));
    }
}
