<?php

// Bootstrap Slim Framework
$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true, // you would want this false in production
    ],
]);

// Setup dependency injection container
$container = $app->getContainer();

// Register php-view template engine into the container. When rendering templates paths must be relative to the /app dir
$container['renderer'] = new \Slim\Views\PhpRenderer('../app/');

// Make sure the template engine is injected into the BooksController
$container['\Mukuru\Books\BooksController'] = function($container) {
    $renderer = $container->get('renderer');
    return new \Mukuru\Books\BooksController($renderer);
};

// Routes
$app->get('/books', '\Mukuru\Books\BooksController:index');
$app->get('/books/create', '\Mukuru\Books\BooksController:create');

// We don't have a homepage so just head to the books listing on first load
$app->redirect('/', '/books');

$app->run();