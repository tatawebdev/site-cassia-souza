<?php

namespace Core;

class Router
{
    private static $routes = [];
    private static $globalMiddleware = [];

    /**
     * Adiciona uma rota GET.
     *
     * @param string|array $uri O URI da rota ou um array de URIs.
     * @param array $controller O controlador e método a serem chamados.
     */
    public static function get($uri, array $controller)
    {
        if (is_array($uri)) {
            foreach ($uri as $route) {
                $route = rtrim($route, '/');

                self::$routes['GET'][$route] = [
                    'controller' => $controller,
                    'middleware' => self::$globalMiddleware
                ];
            }
        } else {
            // $uri = rtrim($uri, '/');
            self::$routes['GET'][$uri] = [
                'controller' => $controller,
                'middleware' => self::$globalMiddleware
            ];
        }
    }

    /**
     * Adiciona uma rota POST.
     *
     * @param string|array $uri O URI da rota ou um array de URIs.
     * @param array $controller O controlador e método a serem chamados.
     */
    public static function post($uri, array $controller)
    {
        if (is_array($uri)) {
            foreach ($uri as $route) {
                $route = rtrim($route, '/');
                self::$routes['POST'][$route] = [
                    'controller' => $controller,
                    'middleware' => self::$globalMiddleware
                ];
            }
        } else {
            $uri = rtrim($uri, '/');    
            self::$routes['POST'][$uri] = [
                'controller' => $controller,
                'middleware' => self::$globalMiddleware
            ];
        }
    }

    /**
     * Adiciona um middleware.
     *
     * @param string|array $middleware Nome do middleware ou um array de middlewares.
     */
    public static function middleware($middleware)
    {
        self::$globalMiddleware = array_merge(self::$globalMiddleware, (array) $middleware);
    }

    /**
     * Remove um middleware.
     *
     * @param string|array $middleware Nome do middleware ou um array de middlewares a serem removidos.
     * @return bool Retorna verdadeiro se algum middleware foi removido.
     */
    public static function removeMiddleware($middleware)
    {
        $middlewareArray = (array) $middleware;
        $removed = false;

        foreach ($middlewareArray as $m) {
            if (($key = array_search($m, self::$globalMiddleware, true)) !== false) {
                unset(self::$globalMiddleware[$key]);
                $removed = true; // Marcar que pelo menos um middleware foi removido
            }
        }

        // Reindexa o array
        self::$globalMiddleware = array_values(self::$globalMiddleware);
        return $removed;
    }

    /**
     * Adiciona rotas com um prefixo.
     *
     * @param string $prefix O prefixo a ser adicionado às rotas.
     * @param callable $callback A função de callback que define as rotas do grupo.
     */
    public static function group($prefix, callable $callback)
    {
        // Salva o conjunto atual de rotas para restauração posterior
        $originalRoutes = self::$routes;

        // Cria um array temporário para armazenar novas rotas
        $newRoutes = [];

        // Executa o callback para registrar as rotas dentro do grupo
        call_user_func($callback);

        // Itera sobre as rotas registradas após a execução do callback
        foreach (self::$routes as $method => $routes) {
            foreach ($routes as $uri => $route) {
                // Readição das rotas com o prefixo, mantendo a rota original no array temporário
                $newRoutes[$method][$prefix . $uri] = $route;
            }
        }

        // Restaura as rotas originais antes de adicionar as novas rotas
        self::$routes = array_merge_recursive($originalRoutes, $newRoutes);
    }

    /**
     * Despacha a rota com base no método de requisição.
     *
     * @param string $request_uri A URI da requisição.
     * @throws \Exception
     */
    public static function dispatch($request_uri)
    {
        $request_method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($request_uri, PHP_URL_PATH);
        $uri = rtrim($uri, '/');

        if (isset(self::$routes[$request_method][$uri])) {
            $route = self::$routes[$request_method][$uri];

            // Verifica se o middleware deve ser executado
            foreach ($route['middleware'] as $m) {
                if (!self::handleMiddleware($m)) {
                    return; // Se o middleware falhar, não continua
                }
            }
            // Obtém o controlador e o método
            $controller = $route['controller'][0]; // Nome da classe do controlador
            $method = $route['controller'][1]; // Nome do método a ser chamado

            if (class_exists($controller) && method_exists($controller, $method)) {
                $controllerInstance = new $controller();
                call_user_func([$controllerInstance, $method]);
            } else {
                throw new \Exception("Método não encontrado: $method em $controller");
            }
        } else {
            throw new \Exception("Rota não encontrada: $uri");
        }
    }

    /**
     * Lida com a execução do middleware.
     *
     * @param string $middleware Nome do middleware.
     * @return bool Retorna true se o middleware passar, false caso contrário.
     */
    private static function handleMiddleware($middleware)
    {
        if (class_exists($middleware)) {
            $middlewareInstance = new $middleware();
            if (!method_exists($middlewareInstance, 'handle')) {
                throw new \Exception("Método handle não encontrado em $middleware");
            }
            return $middlewareInstance->handle(); // Assumindo que o método handle() retorna true/false
        }
        return true; // Se o middleware não existir, permite a execução
    }

    /**
     * Redireciona para uma nova URI.
     *
     * @param string $from A URI original que deve ser redirecionada.
     * @param string $to A nova URI para a qual redirecionar.
     * @param int $status Código de status HTTP (default: 302).
     */
    public static function redirect($from, $to, $status = 302)
    {
        self::$routes['GET'][$from] = function () use ($to, $status) {
            http_response_code($status);
            header("Location: $to");
            exit(); // Encerra o script após o redirecionamento
        };
    }
}
