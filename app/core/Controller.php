<?php

namespace app\core;

use app\exceptions\JsonException;
use Exception;
use ReflectionMethod;

class Controller
{

    public mixed $dataJson = null;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $parameters = file_get_contents('php://input');

        if ($parameters) {
            $this->dataJson = json_decode($parameters, true);

            if (json_last_error() != JSON_ERROR_NONE) {
                throw new JsonException();
            }
        }
    }

    /**
     * @throws Exception
     */
    public function createAction($methodName, $params = []): array
    {
        $method = new ReflectionMethod($this, $this->normalizeAction($methodName));
        if ($method->isPublic()) {
            echo $this->render($method->invokeArgs($this, $params));
        }
        return [];
    }

    /**
     * @throws Exception
     */
    private function render($params = []): false|string
    {
        if (isset($params["status"])) {
            http_response_code($params["status"]);
        }

        header('Content-Type: application/json; charset=utf8');

        $jsonResponse = json_encode($params, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);

        if (json_last_error() != JSON_ERROR_NONE) {
            throw new JsonException();
        }

        return $jsonResponse;
    }

    private function normalizeAction($methodName): ?string
    {
        return lcfirst(str_replace('-', '', ucwords($methodName, '-')));
    }

}


