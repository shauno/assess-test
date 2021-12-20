<?php

namespace Api\Currencies;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CurrenciesController
{
    public function index(Request $request, Response $response)
    {
        $db = new \PDO('mysql:host=database;dbname=assess_db', 'root', 'secret');
        $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

        $books = $db->query('SELECT * FROM currencies')
            ->fetchAll();

        return $response->getBody()->write(json_encode($books));
    }


}
