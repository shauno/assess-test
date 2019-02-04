<?php

namespace Mukuru\Books;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer;

class BooksController
{
    public function index(Request $request, Response $response)
    {
        $renderer = new PhpRenderer('../app/');

        $db = new \PDO('mysql:host=database;dbname=assess_db', 'root', 'secret');
        $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

        $books = $db->query('SELECT * FROM books')
            ->fetchAll();

        return $renderer->render($response, 'Books/templates/list.php', [
            'books' => $books,
            'db' => $db,
        ]);
    }

    public function create(Request $request, Response $response)
    {
        $renderer = new PhpRenderer('../app/');

        $db = new \PDO('mysql:host=database;dbname=assess_db', 'root', 'secret');
        $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

        // Check if form data has been sent
        if ($params = $request->getQueryParams()) {
            // Create the new book
            $db->exec('INSERT INTO books (title, author_id) VALUES ("'.$params['data']['title'].'", "'.$params['data']['author_id'].'")');
            $book_id = $db->lastInsertId();

            // Create the ZAR price for the book
            $zar = $db->query('SELECT * FROM currencies WHERE iso = "ZAR"')->fetch();
            $db->exec('INSERT INTO book_pricing (book_id, currency_id, price) VALUES ('.$book_id.', '.$zar['id'].', '.$params['price']['zar'].')');

            // Redirect back to book listing
            return $response->withStatus(302)->withHeader('Location', '/books');
        }

        $authors = $db->query('SELECT * FROM authors')
            ->fetchAll();

        return $renderer->render($response, 'Books/templates/create.php', [
            'authors' => $authors,
        ]);
    }
}
