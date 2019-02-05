<?php

// Bootstrap Slim Framework
$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true, // you would want this false in production
    ],
]);

// API specific routes
$app->group('/api', function(\Slim\App $app) {
    $app->get('/authors', '\Api\Authors\AuthorsController:index');

    $app->get('/books', '\Api\Books\BooksController:index');
    $app->get('/books/create', '\Api\Books\BooksController:create');
});

// Web app frontend routes
$app->get('/books', '\App\Books\BooksController:index');
$app->get('/books/create', '\App\Books\BooksController:create');

// We don't have a homepage for this web app so just head to the books listing on first load
$app->redirect('/', '/books');

$app->run();
