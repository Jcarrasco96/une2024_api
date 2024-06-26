<?php

namespace app\core;

use app\exceptions\MethodNotAllowedException;
use app\exceptions\NotFoundException;
use Exception;

class App
{

    public static array $config = [];

    private array $routes = [];

    public function __construct($config = [])
    {
        self::$config = array_merge(self::$config, $config);

        define('ROOT', getcwd() . DIRECTORY_SEPARATOR);
        define('APP_PATH', ROOT . 'app' . DIRECTORY_SEPARATOR);
    }

    /**
     * @throws Exception
     */
    private function dispatch(): void
    {
        $pathInfo = $_SERVER['PATH_INFO'] ?? '/';
        $url = trim($pathInfo, '/');
        $method = strtolower($_SERVER['REQUEST_METHOD']);

        if (!isset($this->routes[$method])) {
            throw new MethodNotAllowedException();
        }

        foreach ($this->routes[$method] as $regex => $action) {
            if (preg_match($regex, $url)) {
                $urlParts = explode('/', $url);
                $requestedController = ucfirst(array_shift($urlParts)) . 'Controller';
                $requestedParams = $urlParts;

                $controllerName = 'app\\controllers\\' . $requestedController;
                $controller = new $controllerName;
                $controller->createAction($action, $requestedParams);

                exit;
            }
        }

        throw new NotFoundException();
    }

    public function run(): void
    {
        try {
            self::dispatch();
        } catch (Exception $e) {
            http_response_code($e->getCode());
            echo json_encode(['status' => $e->getCode(), 'message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    }

    public function get($regex, $action): void
    {
        $this->addRoute('get', $regex, $action);
    }

    public function post($regex, $action): void
    {
        $this->addRoute('post', $regex, $action);
    }

    public function put($regex, $action): void
    {
        $this->addRoute('put', $regex, $action);
    }

    public function delete($regex, $action): void
    {
        $this->addRoute('delete', $regex, $action);
    }

    private function addRoute($method, $regex, $action): void
    {
        $this->routes[$method][$regex] = $action;
    }

}