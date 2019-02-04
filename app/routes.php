<?php

// Bootstrap Slim Framework
$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true, // you would want this false in production
    ],
]);

// Routes
$app->get('/books', '\Mukuru\Books\BooksController:index');
$app->get('/books/create', '\Mukuru\Books\BooksController:create');

// We don't have a homepage so just head to the books listing on first load
$app->redirect('/', '/books');

$app->run();