<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Controllers\AuthController;

// Home route
$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write(file_get_contents('public/index.html'));
    return $response;
});

// Login route
$app->get('/login', function (Request $request, Response $response) {
    $response->getBody()->write(file_get_contents('public/login.html'));
    return $response;
});

// Login API route
$app->post('/api/login', [AuthController::class, 'login']);

// Verify JWT token route
$app->get('/api/verify/{token}', [AuthController::class, 'verify']);