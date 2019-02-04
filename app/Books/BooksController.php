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

    public function create(Request $request, Response $response)
    {
        // Check if form data has been sent
        if ($params = $request->getQueryParams()) {
            // Create the new book
            $data = $params['data'];
            $this->db->exec('INSERT INTO books (title, author_id) VALUES ("'.$data['title'].'", "'.$data['author_id'].'")');

            // Redirect back to book listing
            return $response->withStatus(302)->withHeader('Location', '/books');
        }

        $authors = $this->db->query('SELECT * FROM authors')
            ->fetchAll();

        return $this->renderer->render($response, 'Books/templates/create.php', [
            'authors' => $authors,
        ]);
    }
}
