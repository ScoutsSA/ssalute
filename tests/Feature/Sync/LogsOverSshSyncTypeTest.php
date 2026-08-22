<?php

namespace Tests\Feature\Sync;

use App\Sync\Types\LogsOverSshSyncType;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;
use PHPUnit\Framework\Attributes\Test;
use Rouxtaccess\Sync\SyncResult;
use Tests\TestCase;

class LogsOverSshSyncTypeTest extends TestCase
{
    protected string $destination = 'storage/framework/testing/logs-over-ssh';

    protected function tearDown(): void
    {
        File::deleteDirectory(base_path($this->destination));

        parent::tearDown();
    }

    #[Test]
    public function it_archives_the_contents_of_a_directory_source(): void
    {
        Process::fake();

        $this->runSync(['remote_path' => '/var/log/nginx/']);

        $this->assertScriptContains("cd '/var/log/nginx' && tar czf - .");
    }

    #[Test]
    public function it_archives_a_single_file_from_its_parent_directory(): void
    {
        Process::fake();

        $this->runSync(['remote_path' => '/var/log/php8.4-fpm.log']);

        $this->assertScriptContains("cd '/var/log' && tar czf - php8.4-fpm.log");
    }

    #[Test]
    public function it_leaves_a_glob_unquoted_so_the_remote_shell_expands_it(): void
    {
        Process::fake();

        $this->runSync(['remote_path' => '/var/log/php*-fpm.log*']);

        $this->assertScriptContains('php*-fpm.log*');
        $this->assertScriptDoesNotContain("'php*-fpm.log*'");
    }

    #[Test]
    public function it_refuses_a_target_carrying_shell_metacharacters(): void
    {
        Process::fake();

        $result = $this->runSync(['remote_path' => '/var/log/nginx/$(id).log']);

        $this->assertFalse($result->ok);
        $this->assertStringContainsString('unsafe to leave unquoted', $result->message);
        Process::assertNothingRan();
    }

    #[Test]
    public function it_feeds_the_sudo_password_on_stdin_and_never_in_the_command(): void
    {
        Process::fake();

        $this->runSync(['sudo' => true, 'sudo_password' => 'hunter2']);

        $this->assertFetchCommandContains("sudo -S -p '' sh -c ");
        $this->assertFetchCommandDoesNotContain('hunter2');
        Process::assertRan(fn ($process): bool => $process->input === "hunter2\n");
    }

    #[Test]
    public function it_uses_non_interactive_sudo_when_no_password_is_configured(): void
    {
        Process::fake();

        $this->runSync(['sudo' => true, 'sudo_password' => '']);

        $this->assertFetchCommandContains('sudo -n ');
    }

    #[Test]
    public function it_omits_sudo_entirely_when_not_asked_for(): void
    {
        Process::fake();

        $this->runSync(['sudo' => false, 'sudo_password' => 'hunter2']);

        $this->assertFetchCommandDoesNotContain('sudo');
        $this->assertFetchCommandDoesNotContain('hunter2');
    }

    #[Test]
    public function it_quotes_each_exclude_pattern(): void
    {
        Process::fake();

        $this->runSync(['exclude' => ['*access.log*', '*.gz']]);

        $this->assertScriptContains("--exclude='*access.log*'");
        $this->assertScriptContains("--exclude='*.gz'");
    }

    #[Test]
    public function it_accepts_a_comma_separated_exclude_string_from_a_hand_edited_store(): void
    {
        Process::fake();

        $this->runSync(['exclude' => '*access.log*, *.gz']);

        $this->assertScriptContains("--exclude='*access.log*'");
        $this->assertScriptContains("--exclude='*.gz'");
    }

    #[Test]
    public function it_unpacks_the_archive_into_the_destination(): void
    {
        Process::fake();

        $this->runSync();

        Process::assertRan(fn ($process): bool => is_array($process->command)
            && $process->command[0] === 'tar'
            && in_array($this->destination . '/', $process->command, true));
    }

    #[Test]
    public function it_creates_the_destination_directory(): void
    {
        Process::fake();

        $this->assertDirectoryDoesNotExist(base_path($this->destination));

        $this->runSync();

        $this->assertDirectoryExists(base_path($this->destination));
    }

    #[Test]
    public function it_reports_the_remote_error_output_on_failure(): void
    {
        Process::fake(['*' => Process::result(errorOutput: 'sudo: a password is required', exitCode: 1)]);

        $result = $this->runSync();

        $this->assertFalse($result->ok);
        $this->assertSame('sudo: a password is required', $result->message);
    }

    #[Test]
    public function it_removes_the_staged_archive_afterwards(): void
    {
        Process::fake();

        File::put(storage_path('framework/sync-logs.tar.gz'), 'stale');

        $this->runSync();

        $this->assertFileDoesNotExist(storage_path('framework/sync-logs.tar.gz'));
    }

    #[Test]
    public function it_reports_success_when_both_steps_exit_cleanly(): void
    {
        Process::fake();

        $this->assertTrue($this->runSync()->ok);
    }

    /**
     * @param  array<string, mixed>  $config
     */
    protected function runSync(array $config = []): SyncResult
    {
        $job = [
            'name' => 'logs',
            'type' => 'logs-over-ssh',
            'config' => array_merge([
                'ssh' => 'forge@1.2.3.4',
                'remote_path' => '/var/log/nginx/',
                'local_path' => $this->destination,
                'sudo' => true,
                'sudo_password' => '',
            ], $config),
        ];

        return (new LogsOverSshSyncType)->run($job, false);
    }

    protected function assertFetchCommandContains(string $fragment): void
    {
        $this->assertCommandHas($this->asEscaped($fragment), true);
    }

    protected function assertFetchCommandDoesNotContain(string $fragment): void
    {
        $this->assertCommandHas($this->asEscaped($fragment), false);
    }

    protected function assertScriptContains(string $fragment): void
    {
        $this->assertCommandHas($this->asEscaped($this->asEscaped($fragment)), true);
    }

    protected function assertScriptDoesNotContain(string $fragment): void
    {
        $this->assertCommandHas($this->asEscaped($this->asEscaped($fragment)), false);
    }

    protected function assertCommandHas(string $fragment, bool $expected): void
    {
        Process::assertRan(fn ($process): bool => is_string($process->command)
            && str_contains($process->command, $fragment) === $expected);
    }

    /**
     * The remote command is handed to ssh through escapeshellarg, so any quote it
     * contains appears in the final string as the '\'' escape sequence.
     */
    protected function asEscaped(string $fragment): string
    {
        return str_replace("'", "'\\''", $fragment);
    }
}
