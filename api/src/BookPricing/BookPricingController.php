<?php

namespace Api\BookPricing;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Api\Database\Database;

class BookPricingController
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function index(Request $request, Response $response)
    {
        $stmt = $this->db->prepare('SELECT bp.*, c.* 
                FROM book_pricing bp 
                LEFT JOIN currencies c ON bp.currency_id = c.id');

        $stmt->execute();
        $book_pricing = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $response->getBody()->write(json_encode($book_pricing));
    }
}
