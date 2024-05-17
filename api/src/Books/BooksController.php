<?php

namespace Api\Books;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use GuzzleHttp\Client;
use Respect\Validation\Validator;

class BooksController
{
    private $db;

    public function __construct()
    {
        // Establish database connection
        $this->db = new \PDO('mysql:host=database;dbname=assess_db', 'root', 'secret');
        $this->db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
    }

    public function index(Request $request, Response $response)
    {
        try {
            // Fetch all books from the database
            $statement = $this->db->query('SELECT * FROM books');
            $books = $statement->fetchAll();

            // Return JSON response with books data
            return $response->withJson($books);
        } catch (\PDOException $e) {
            // Handle database connection error
            return $response->withStatus(500)->getBody()->write('Database connection error');
        }
    }

    public function _create(Request $request, Response $response)
    {
        $db = new \PDO('mysql:host=database;dbname=assess_db', 'root', 'secret');
        $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

        $params = $request->getQueryParams();

        // Create the new book
        $db->exec('INSERT INTO books (title, author_id) VALUES ("'.$params['title'].'", "'.$params['author_id'].'")');
        $book_id = $db->lastInsertId();

        // Create the ZAR price for the book
        $zar = $db->query('SELECT * FROM currencies')->fetch();
        $db->exec('INSERT INTO book_pricing (book_id, currency_id, price) VALUES ('.$book_id.', '.$params['currency_symbol'].', '.$params['price'].')');

        // Fetch the book we just created so we can return it in the response
        $return = $db->query('SELECT * FROM books WHERE id = '.$book_id)
            ->fetchAll();

        return $response->getBody()->write(json_encode($return));
    }

    public function create(Request $request, Response $response)
    {
        try {
            // Validate request inputs
            $input = $request->getQueryParams();
            // $validator = new Validator();
            // $validator->required('title')->string()->lengthBetween(1, 255)->assert($input);
            // $validator->required('price')->float()->assert($input);

            // Create the new book
            $stmt = $this->db->prepare('INSERT INTO books (title, author_id) VALUES (:title, :author_id)');
            $stmt->execute(['title' => $input['title'], 'author_id' => $input['author_id']]);
            $book_id = $this->db->lastInsertId();

            // Create the ZAR price for the book
            $stmt = $this->db->prepare('INSERT INTO book_pricing (book_id, currency_id, price) VALUES (:book_id, :currency_id, :price)');
            $stmt->execute(['book_id' => $book_id, 'currency_id' => $input['currency_symbol'], 'price' => $input['price']]);

            // // Fetch the book we just created
            // $stmt = $this->db->prepare('SELECT * FROM book_pricing');
            // $stmt->execute();
            // $book_pricing = $stmt->fetchAll();

            // Return the newly created book as JSON response
            return $response->withJson($book);
        } catch (\PDOException $e) {
            // Handle database connection error
            return $response->withStatus(500)->getBody()->write('Database connection error');
        } catch (\Respect\Validation\Exceptions\ValidationException $e) {
            // Handle input validation error
            echo $e->getMessage();
            exit;

            return $response->withStatus(400)->getBody()->write($e->getMessage());
        }
    }

    public function pricing(Request $request, Response $response)
    {
        try {
            // Fetch all pricing from the database
            $statement = $this->db->query('SELECT * FROM book_pricing');
            $pricing = $statement->fetchAll();

            // Fetch all books from the database
            $statement = $this->db->query('SELECT * FROM currencies');
            $currencies = $statement->fetch();

            // Return JSON response with books data
            return $response->withJson([
                'currencies' => $currencies,
                'pricing' => $pricing
            ]);
        } catch (\PDOException $e) {
            // Handle database connection error
            return $response->withStatus(500)->getBody()->write('Database connection error');
        }
    }
}
