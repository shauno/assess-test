<?php

// Bootstrap Slim Framework
$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true, // you would want this false in production
    ],
]);

$app->get('/authors', '\Api\Authors\AuthorsController:index');

$app->get('/books', '\Api\Books\BooksController:index');
//change this to a post request
$app->get('/books/create', '\Api\Books\BooksController:create');
$app->get('/books/pricing', '\Api\Books\BooksController:bookPricing');

$app->run();
