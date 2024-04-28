<?php

require_once 'vendor/autoload.php';

$config = require_once 'config/config.php';

date_default_timezone_set('America/Havana');

ignore_user_abort(true);
ini_set('display_errors', 0);
ini_set('error_log', 'error/error_' . date('Ymd') . '.log');

require_once 'exception_handler.php';
set_exception_handler('exception_handler');

$requestHeaders = array_change_key_case(getallheaders());
if (isset($requestHeaders['Origin']) && in_array($requestHeaders['Origin'], $config['origins'], true)) {
    header('Access-Control-Allow-Origin: ' . $requestHeaders['Origin']);
}

header("Access-Control-Allow-Headers: Origin, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

if (strtolower($_SERVER['REQUEST_METHOD']) == 'options') die();

$app = new app\core\App($config);

$app->get('/^backup\/[a-zA-Z0-9]+$/', 'view');
$app->post('/^backup\/save$/', 'save');

$app->run();