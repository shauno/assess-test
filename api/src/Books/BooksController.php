<?php

namespace Api\Books;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BooksController
{

    private $connection;

    public function __construct()
    {

        $this->connection = new \PDO('mysql:host=database;dbname=assess_db', 'root', 'secret');
        $this->connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
    }


    public function books(Request $request, Response $response)
    {
        $books = $this->connection->query('SELECT * FROM books')
            ->fetchAll();
        return $response->getBody()->write(json_encode($books));
    }

    public function index(Request $request, Response $response)
    {
        $query = $this->connection->query('
                    SELECT 
                        b.id, 
                        a.first_name as name, 
                        a.last_name as surname,
                        b.title as book_title,
                        b.description as book_description,
                        c.iso as currency,
                        c.name as currency_name,
                        p.price as amount
                    FROM
                          authors a
                        LEFT JOIN books b
                          ON 
                            a.id = b.author_id
                        LEFT JOIN book_pricing p
                          ON 
                            p.book_id =  b.id
                        LEFT JOIN currencies c
                          ON 
                            p.currency_id =  c.id
                    ORDER BY b.title ASC
                      ')->fetchAll();

        return $response->getBody()->write(json_encode($query));


    }


    public function create(Request $request, Response $response)
    {
        $params = $request->getQueryParams();

        // Create the new book
        /*
         * sanitize inputs
         * validate amounts
         * return errors else pass test
         */
        //****/
        $title = htmlspecialchars($params['title']);
        $author_id = $params['author_id'];
        $description = htmlspecialchars($params['description']);
        $iso = $params['currency'];
        $amount = $params['price'];

        //***/

        /***Prepared statement needs to be used to avoid SQL Injections*/

        $this->connection->exec('INSERT INTO books (title, description ,author_id) VALUES ("' . $title . '", "' . $description . '  ", "' . $author_id . '  ") ');
        $book_id = $this->connection->lastInsertId();


        // Create the ALL price for the book
        $currency = $this->connection->query('SELECT * FROM currencies WHERE iso = "' . $iso . '"')->fetch();
        $this->connection->exec('INSERT INTO book_pricing (book_id, currency_id, price) VALUES (' . $book_id . ', ' . $currency['id'] . ', ' . $amount . ')');

        // Fetch the book we just created so we can return it in the response
        $return = $this->connection->query('SELECT * FROM books WHERE id = ' . $book_id)
            ->fetchAll();

        return $response->getBody()->write(json_encode($return));
    }
}
