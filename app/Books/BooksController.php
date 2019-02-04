<?php

namespace Mukuru\Books;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer;

class BooksController
{
    public function __construct()
    {
        $this->renderer = new PhpRenderer('../app/');
    }

    public function index(Request $request, Response $response)
    {
        return $this->renderer->render($response, 'Books/templates/list.php', []);
    }
}