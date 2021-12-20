<?php

// Bootstrap Slim Framework
$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true, // you would want this false in production
    ],
]);

$app->get('/authors', '\Api\Authors\AuthorsController:index');
$app->get('/currencies', '\Api\Currencies\CurrenciesController:index');

$app->get('/books', '\Api\Books\BooksController:books');
$app->get('/books/create', '\Api\Books\BooksController:create');
$app->get('/list', '\Api\Books\BooksController:index');

$app->run();
