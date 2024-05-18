<?php

namespace Api\Books;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Api\Database\Database;

class BooksController
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function index(Request $request, Response $response)
    {
        $stmt = $this->db->prepare('SELECT * FROM books left join authors on books.author_id = authors.id');
        $stmt->execute();
        $books = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        return $response->getBody()->write(json_encode($books));
    }


    public function create(Request $request, Response $response)
    {
        $params = $request->getQueryParams();
    
        // Create the new book
        $stmt = $this->db->prepare('INSERT INTO books (title, author_id) VALUES (:title, :author_id)');
        $stmt->bindParam(':title', $params['title']);
        $stmt->bindParam(':author_id', $params['author_id']);
        $stmt->execute();
        $book_id = $this->db->lastInsertId();
    
        // Create the ZAR price for the book
        $stmt = $this->db->prepare('INSERT INTO book_pricing (book_id, currency_id, price) VALUES (:book_id, :currency_id, :price)');
        $stmt->bindParam(':book_id', $book_id);
        $stmt->bindParam(':currency_id', $params['currency_id']);
        $stmt->bindParam(':price', $params['price']);
        $stmt->execute();
    
        // Fetch the book we just created so we can return it in the response
        $stmt = $this->db->prepare('SELECT * FROM books WHERE id = :book_id');
        $stmt->bindParam(':book_id', $book_id);
        $stmt->execute();
        $return = $stmt->fetchAll();
    
        return $response->getBody()->write(json_encode($return));
    }
    
}
