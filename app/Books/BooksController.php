<?php

namespace Mukuru\Books;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer;

class BooksController
{
    /**
     * @var PhpRenderer
     */
    protected $renderer;

    /**
     * @var \PDO
     */
    protected $db;

    public function __construct()
    {
        $this->renderer = new PhpRenderer('../app/');
        $this->db = new \PDO('mysql:host=database;dbname=assess_db', 'root', 'secret');
        $this->db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
    }

    public function index(Request $request, Response $response)
    {
        $books = $this->db->query('SELECT * FROM books')
            ->fetchAll();

        return $this->renderer->render($response, 'Books/templates/list.php', [
            'books' => $books,
            'db' => $this->db,
        ]);
    }
}
