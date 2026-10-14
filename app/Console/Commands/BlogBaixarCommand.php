<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;
use ZipArchive;

/**
 * Baixa o blog (WordPress em www/blog no servidor) para a pasta local blog/:
 * compacta no servidor, fora da pasta pública, junto com um dump do banco,
 * baixa o zip pelo SSH do deploy, descompacta e apaga o zip do servidor.
 */
class BlogBaixarCommand extends Command
{
    protected $signature = 'blog:baixar {--sem-banco : Não inclui o dump do banco de dados}';

    protected $description = 'Baixa o blog WordPress do servidor para a pasta blog/ (arquivos + banco)';

    public function handle(): int
    {
        $config = config('services.deploy');
        $www = dirname($config['path']);
        $alvo = $config['user'].'@'.$config['host'];
        $ssh = ['-i', $config['key'], '-o', 'IdentitiesOnly=yes', '-o', 'BatchMode=yes'];

        $this->info('→ Compactando o blog no servidor (pode levar alguns minutos)...');

        $remoto = Process::timeout(1800)
            ->input($this->scriptRemoto($www, ! $this->option('sem-banco')))
            ->run(['ssh', ...$ssh, '-p', (string) $config['port'], $alvo, 'bash -s']);

        $zipRemoto = trim(collect(explode("\n", trim($remoto->output())))->last() ?? '');

        if ($remoto->failed() || ! str_ends_with($zipRemoto, '.zip')) {
            $this->error('Falhou ao compactar no servidor:');
            $this->line($remoto->errorOutput().$remoto->output());

            return self::FAILURE;
        }

        foreach (explode("\n", trim($remoto->output())) as $linha) {
            if ($linha !== $zipRemoto && trim($linha) !== '') {
                $this->line('  '.$linha);
            }
        }

        $pasta = storage_path('app/private/blog-pacotes');
        File::ensureDirectoryExists($pasta);
        $zipLocal = $pasta.'/'.basename($zipRemoto);

        $this->info('→ Baixando '.basename($zipRemoto).'...');

        $download = Process::timeout(3600)->run([
            'scp', ...$ssh, '-P', (string) $config['port'], $alvo.':'.$zipRemoto, $zipLocal,
        ]);

        // O zip no servidor é removido mesmo se o download falhar
        Process::run(['ssh', ...$ssh, '-p', (string) $config['port'], $alvo, 'rm -f '.$zipRemoto]);

        if ($download->failed() || ! is_file($zipLocal)) {
            $this->error('Falhou ao baixar: '.$download->errorOutput());

            return self::FAILURE;
        }

        $this->info(sprintf('→ Descompactando %s MB em blog/...', round(filesize($zipLocal) / 1048576, 1)));

        $zip = new ZipArchive();
        if ($zip->open($zipLocal) !== true) {
            $this->error('Não foi possível abrir o zip baixado.');

            return self::FAILURE;
        }

        // O zip contém a pasta "blog/" e, se houver, "blog-banco.sql" na raiz
        $zip->extractTo(base_path());
        $zip->close();

        if (is_file(base_path('blog-banco.sql'))) {
            File::move(base_path('blog-banco.sql'), base_path('blog/blog-banco.sql'));
        }

        $this->info('Pronto: blog/ atualizado'.(is_file(base_path('blog/blog-banco.sql')) ? ' (banco em blog/blog-banco.sql)' : '').'.');
        $this->line('Pacote guardado em '.str_replace(base_path().DIRECTORY_SEPARATOR, '', $zipLocal));

        return self::SUCCESS;
    }

    /** Script bash executado no servidor; a última linha impressa é o caminho do zip. */
    private function scriptRemoto(string $www, bool $banco): string
    {
        $banco = $banco ? '1' : '0';

        return <<<BASH
        set -e
        cd {$www}
        PACOTE="\$HOME/blog-pacote-\$(date +%Y%m%d-%H%M%S).zip"

        if [ "{$banco}" = "1" ]; then
            # Lê as credenciais do wp-config.php aqui mesmo, sem trafegar a senha.
            # O PHP de linha de comando do servidor é 5.6: nada de "??".
            eval "\$(php -r '
                \$c = file_get_contents("blog/wp-config.php");
                foreach (array("DB_NAME", "DB_USER", "DB_PASSWORD", "DB_HOST") as \$k) {
                    preg_match("/define\\\\(\\\\s*[\\x27\\"]{\$k}[\\x27\\"]\\\\s*,\\\\s*[\\x27\\"](.*?)[\\x27\\"]\\\\s*\\\\)/", \$c, \$m);
                    echo \$k, "=", escapeshellarg(isset(\$m[1]) ? \$m[1] : ""), "\\n";
                }
            ')"
            HOST="\${DB_HOST%%:*}"
            PORTA="\${DB_HOST##*:}"; [ "\$PORTA" = "\$DB_HOST" ] && PORTA=3306
            MYSQL_PWD="\$DB_PASSWORD" mysqldump --single-transaction --no-tablespaces --default-character-set=utf8mb4 \\
                -h "\$HOST" -P "\$PORTA" -u "\$DB_USER" "\$DB_NAME" > "\$HOME/blog-banco.sql"
            echo "Banco: \$(du -h "\$HOME/blog-banco.sql" | cut -f1) (\$DB_NAME)"
        fi

        zip -rq "\$PACOTE" blog -x 'blog/wp-content/cache/*' 'blog/wp-content/upgrade/*'
        if [ -f "\$HOME/blog-banco.sql" ]; then
            (cd "\$HOME" && zip -q "\$PACOTE" blog-banco.sql && rm -f blog-banco.sql)
        fi
        echo "Pacote: \$(du -h "\$PACOTE" | cut -f1)"
        echo "\$PACOTE"
        BASH;
    }
}
