<?php

use DI\ContainerBuilder;

$builder = new ContainerBuilder();

$builder->addDefinitions([
    'settings' => [
        'displayErrorDetails' => true,
        'db' => [
            'driver' => 'mysql',
            'host' => getenv('DB_HOST'),
            'user' => getenv('DB_USER'),
            'pass' => getenv('DB_PASS'),
            'name' => getenv('DB_NAME'),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
        ],
        'jwt' => [
            'secret' => getenv('JWT_SECRET'),
        ],
    ],
]);

$container = $builder->build();

return $container;
?>