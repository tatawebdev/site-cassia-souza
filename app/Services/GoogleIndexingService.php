<?php

namespace App\Services;

use Google\Client;
use Google\Service\Indexing;
use Google\Service\Indexing\UrlNotification;
use Illuminate\Support\Facades\Log;
use Throwable;

class GoogleIndexingService
{
    protected ?Indexing $indexingService = null;

    /** Erro do último envio que falhou (para saber se foi o limite diário) */
    public ?Throwable $ultimoErro = null;

    /**
     * Notifica o Google que uma URL foi criada ou atualizada.
     */
    public function notifyUrlUpdate(string $url): bool
    {
        return $this->publish($url, 'URL_UPDATED');
    }

    /**
     * Notifica o Google que uma URL foi removida.
     */
    public function notifyUrlDeleted(string $url): bool
    {
        return $this->publish($url, 'URL_DELETED');
    }

    protected function publish(string $url, string $type): bool
    {
        if (! config('services.google_indexing.enabled')) {
            return false;
        }

        $service = $this->service();

        if (! $service) {
            return false;
        }

        $notification = new UrlNotification([
            'url' => $this->toProductionUrl($url),
            'type' => $type,
        ]);

        $this->ultimoErro = null;

        try {
            $service->urlNotifications->publish($notification);

            return true;
        } catch (Throwable $e) {
            $this->ultimoErro = $e;
            Log::warning('Falha ao notificar o Google Indexing API.', [
                'url' => $url,
                'type' => $type,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /** O último envio falhou porque a cota diária da API acabou (HTTP 429 / RESOURCE_EXHAUSTED)? */
    public function ultimoErroFoiLimite(): bool
    {
        if (! $this->ultimoErro) {
            return false;
        }

        $mensagem = $this->ultimoErro->getMessage();

        return $this->ultimoErro->getCode() === 429
            || str_contains($mensagem, 'RESOURCE_EXHAUSTED')
            || stripos($mensagem, 'quota') !== false;
    }

    /**
     * Garante que a URL notificada ao Google sempre aponte para o domínio de
     * produção, independente do host em que a aplicação está rodando.
     */
    public function toProductionUrl(string $url): string
    {
        $base = rtrim((string) config('services.google_indexing.base_url'), '/');

        if (! $base) {
            return $url;
        }

        $path = parse_url($url, PHP_URL_PATH) ?? '/';
        $query = parse_url($url, PHP_URL_QUERY);

        return $base.$path.($query ? '?'.$query : '');
    }

    protected function service(): ?Indexing
    {
        if ($this->indexingService) {
            return $this->indexingService;
        }

        $credentialsPath = config('services.google_indexing.credentials_path');

        if (! $credentialsPath || ! is_file($credentialsPath)) {
            Log::warning('Credenciais do Google Indexing API não encontradas.', [
                'path' => $credentialsPath,
            ]);

            return null;
        }

        $client = new Client();
        $client->setAuthConfig($credentialsPath);
        $client->addScope('https://www.googleapis.com/auth/indexing');

        return $this->indexingService = new Indexing($client);
    }
}
