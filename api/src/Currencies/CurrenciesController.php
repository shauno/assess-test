<?php

namespace Api\Currencies;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Api\Database\Database;

class CurrenciesController
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function index(Request $request, Response $response)
    {
        $stmt = $this->db->prepare('SELECT * FROM currencies');
        $stmt->execute();
        $currencies = $stmt->fetchAll();
        
        return $response->getBody()->write(json_encode($currencies));
    }
    
}
