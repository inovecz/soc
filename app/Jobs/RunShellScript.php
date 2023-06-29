<?php

namespace App\Jobs;

use phpseclib3\Net\SSH2;
use App\Enums\ScriptStatus;
use Illuminate\Bus\Queueable;
use App\Models\ShellScriptRun;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class RunShellScript implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $sshHost;
    protected int $sshPort;
    protected string $sshAuthUser;
    protected string $sshAuthPass;

    public function __construct(protected ShellScriptRun $shellScriptRun)
    {
        $this->sshHost = config('services.open_vas.ip');
        $this->sshPort = 22;
        $this->sshAuthUser = config('services.open_vas.username');
        $this->sshAuthPass = config('services.open_vas.password');
    }

    public function handle(): void
    {
        $this->shellScriptRun->update([
            'status' => ScriptStatus::RUNNING,
            'started_at' => now(),
        ]);

        try {
            $ssh = new SSH2($this->sshHost);
        } catch (\Exception $exception) {
            $output = 'Connection Failed';
            $this->shellScriptRun->update([
                'state' => ScriptStatus::FAILED,
                'finished_at' => now(),
                'output' => $output,
            ]);
        }

        if (!$ssh->login($this->sshAuthUser, $this->sshAuthPass)) {
            $output = 'Login Failed';
            $this->shellScriptRun->update([
                'state' => ScriptStatus::FAILED,
                'finished_at' => now(),
                'output' => $output,
            ]);
        } else {
            $output = $ssh->exec($this->shellScriptRun->getScript());
            $this->shellScriptRun->update([
                'state' => ScriptStatus::FINISHED,
                'finished_at' => now(),
                'output' => $output,
            ]);
        }
    }
}
