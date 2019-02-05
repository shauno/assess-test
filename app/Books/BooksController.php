<?php

namespace App\Books;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer;

class BooksController
{
    public function index(Request $request, Response $response)
    {
        $renderer = new PhpRenderer('../app/');

        // The host "nginx" uses docker's internal DNS to resolve to the web server
        // Get all the books to show
        $ch = curl_init('http://nginx/api/books');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $books = json_decode(curl_exec($ch));
        curl_close($ch);

        // Get all the authors
        $ch = curl_init('http://nginx/api/authors');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $authors = json_decode(curl_exec($ch));
        curl_close($ch);

        // Loop through all books and add the author to each one for use in the listing template
        foreach ($books as $key => $book) {
            foreach ($authors as $author) {
                if ($book->author_id == $author->id) {
                    $books[$key]->author = $author;
                }
            }
        }

        return $renderer->render($response, 'Books/templates/list.php', [
            'books' => $books,
        ]);
    }

    public function create(Request $request, Response $response)
    {
        $renderer = new PhpRenderer('../app/');

        $db = new \PDO('mysql:host=database;dbname=assess_db', 'root', 'secret');
        $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

        // Check if form data has been sent
        if ($params = $request->getQueryParams()) {

            // Make the api call to create the book
            $ch = curl_init('http://nginx/api/books/create?'.http_build_query($params));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch);
            curl_close($ch);

            // Redirect back to book listing
            return $response->withStatus(302)->withHeader('Location', '/books');
        }

        // Get all the authors
        $ch = curl_init('http://nginx/api/authors');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $authors = json_decode(curl_exec($ch));
        curl_close($ch);

        return $renderer->render($response, 'Books/templates/create.php', [
            'authors' => $authors,
        ]);
    }
}
