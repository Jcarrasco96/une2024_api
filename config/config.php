<?php

return [
    'name' => 'UNE2024',
    'jwt' => [
        'serverkey' => '5f96af12e5224844b3241209fe61ff22',
    ],
    'origins' => [
        'http://localhost',
        'http://127.0.0.1',
        'http://192.168.56.1',
        'https://une2024.jcarrasco96.com',
    ],
    'db' => [
        'host' => 'localhost',
        'user' => 'root',
        'password' => '',
        'dbname' => 'une2024',
        'port' => '3306',
        'charset' => 'utf8',
    ],
    'roles' => [
        'admin' => 3,
        'normal' => 0,
    ],
    'env' => 'dev',
];