<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

class DeployCommand extends Command
{
    protected $signature = 'deploy {--m=Deploy automático : Mensagem do commit}';

    protected $description = 'Builda os assets, envia para o Git e atualiza o servidor via SSH';

    public function handle(): int
    {
        $config = config('services.deploy');

        $missing = collect($config)
            ->except('php_bin')
            ->filter(fn ($value) => blank($value))
            ->keys();

        if ($missing->isNotEmpty()) {
            $this->error('Configuração de deploy incompleta. Defina no .env: '.
                $missing->map(fn ($key) => match ($key) {
                    'host' => 'DEPLOY_SSH_HOST',
                    'user' => 'DEPLOY_SSH_USER',
                    'port' => 'DEPLOY_SSH_PORT',
                    'key' => 'DEPLOY_SSH_KEY',
                    'path' => 'DEPLOY_SERVER_PATH',
                    'branch' => 'DEPLOY_BRANCH',
                    'composer_path' => 'DEPLOY_COMPOSER_PATH',
                })->implode(', '));

            return self::FAILURE;
        }

        $steps = [
            'npm run build' => ['npm', 'run', 'build'],
            'git add' => ['git', 'add', '-A'],
        ];

        foreach ($steps as $label => $command) {
            $this->info("→ {$label}");

            $result = Process::path(base_path())
                ->timeout(0)
                ->tty(false)
                ->run($command, function (string $type, string $output) {
                    $this->output->write($output);
                });

            if ($result->failed()) {
                $this->error("Falhou em: {$label}");

                return self::FAILURE;
            }
        }

        $hasStagedChanges = Process::path(base_path())
            ->run(['git', 'diff', '--cached', '--quiet'])
            ->failed();

        if ($hasStagedChanges) {
            $this->info('→ git commit');

            $result = Process::path(base_path())
                ->timeout(0)
                ->run(['git', 'commit', '-m', $this->option('m')], function (string $type, string $output) {
                    $this->output->write($output);
                });

            if ($result->failed()) {
                $this->error('Falhou em: git commit');

                return self::FAILURE;
            }
        } else {
            $this->info('→ git commit (nada para commitar, pulando)');
        }

        $this->info('→ git push');

        $result = Process::path(base_path())
            ->timeout(0)
            ->run(['git', 'push', 'origin', $config['branch']], function (string $type, string $output) {
                $this->output->write($output);
            });

        if ($result->failed()) {
            $this->error('Falhou em: git push');

            return self::FAILURE;
        }

        $this->info('→ Atualizando servidor via SSH');

        $phpBin = $config['php_bin'];

        // `git reset --hard` em vez de `git pull`: o diretório no servidor às
        // vezes recebe edições manuais (ex.: substituição de imagem via FTP)
        // que não vêm do Git, e isso faz o pull normal falhar com conflito.
        // Como esse diretório é só o alvo do deploy (não um lugar de
        // trabalho), sempre alinhar exatamente com o que está no branch é o
        // comportamento certo.
        $remoteCommand = implode(' && ', [
            'cd '.escapeshellarg($config['path']),
            'git fetch origin '.escapeshellarg($config['branch']),
            'git reset --hard '.escapeshellarg('origin/'.$config['branch']),
            $phpBin.' '.escapeshellarg($config['composer_path']).' install --no-dev --optimize-autoloader',
            $phpBin.' artisan config:clear',
            $phpBin.' artisan cache:clear',
            $phpBin.' artisan route:clear',
            $phpBin.' artisan view:clear',
            $phpBin.' artisan migrate --force',
            $phpBin.' artisan config:cache',
            $phpBin.' artisan route:cache',
            $phpBin.' artisan view:cache',
        ]);

        $sshCommand = [
            'ssh',
            '-i', $config['key'],
            '-p', (string) $config['port'],
            '-o', 'IdentitiesOnly=yes',
            $config['user'].'@'.$config['host'],
            $remoteCommand,
        ];

        $result = Process::timeout(0)
            ->tty(false)
            ->run($sshCommand, function (string $type, string $output) {
                $this->output->write($output);
            });

        if ($result->failed()) {
            $this->error('Falhou ao atualizar o servidor via SSH');

            return self::FAILURE;
        }

        $this->info('Deploy concluído.');

        return self::SUCCESS;
    }
}
