<?php

namespace App\Books;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Slim\Views\PhpRenderer;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Respect\Validation\Validator as v;

class BooksController
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function index(Request $request, Response $response)
    {
    
        // Get all the books
        $books = $this->getBooks($this->client);

        // Get all the authors
        $authors = $this->getAuthors($this->client);
        
        // Get all the book_pricing
        $books_pricing = $this->getAllBookPricing();

        // Loop through all books and add the pricing to each one for use in the listing template
        foreach ($books as $key => $book) {
            foreach ($books_pricing as $price) {
                if ($price->book_id == $book->id) {
                    $books[$key]->pricing = $price;
                }
            }
        }

        // Get all the currencies
        $currencies = $this->getAllCurrencies();

        // $mergedArray = $this->mergeArrays($books_pricing, $books);

        // foreach ($books as $key => $book) {
        //     foreach ($books_pricing as $price) {
        //         if ($book->id == $price->book_id) {
        //             $books[$key]->price = $price->price;
        //         }
        //     }
        // }

        // foreach ($books_pricing as $key => $book_price) {
        //     foreach ($currencies as $currency) {
        //         if ($currency->id == $books_pricing->currency_id) {
        //             $books_pricing[$key]->price = $books_pricing->price;
        //         }
        //     }
        // }
        
        $renderer = new PhpRenderer('../src/Books/templates/');
        return $renderer->render($response, 'list.php', [
            'books' => $books,
            'books_pricing' => $books_pricing,
        ]);
    }
   
    public function create(Request $request, Response $response)
    {
        // Check if form data has been sent
        $params = $request->getQueryParams();

        if (!empty($params)) {
            // Make the API call to create the book
            $response = $this->client->request('GET', 'http://api.localtest.me/books/create', [
                'query' => $params,
            ]);

            // Check the status code to ensure the request was successful
            if ($response->getStatusCode() === 200) {
                // Redirect back to book listing
                return $response->withStatus(302)->withHeader('Location', '/books');
            } else {
                // Handle unsuccessful API call
                // For example, return an error response
                return $response->withStatus(500)->getBody()->write('Failed to create book.');
            }
        }


        // Get all the authors
        $authors = $this->getAllAuthors();

        // Get all the currencies
        $currencies = $this->getAllCurrencies();

        // Get all the book_pricing
        $book_pricing = $this->getAllBookPricing();

        $renderer = new PhpRenderer('../src/Books/templates/');

        return $renderer->render($response, 'create.php', [
            'authors' => $authors,
            'currencies' => $currencies,
            'book_pricing' => $book_pricing,
        ]);
    }

    private function getBooks()
    {
        $response = $this->client->get('http://api.localtest.me/books');
        return json_decode($response->getBody()->getContents());
    }
    
    private function getAuthors()
    {
        $response = $this->client->get('http://api.localtest.me/authors');
        return json_decode($response->getBody()->getContents());
    }

    private function getAllAuthors()
    {
        
        $response = $this->client->get('http://api.localtest.me/authors');

        if ($response->getStatusCode() === 200) {
            return json_decode($response->getBody()->getContents());
        }

        return null;
    }

    private function getAllCurrencies()
    {
        $response = $this->client->get('http://api.localtest.me/currencies');
    
        if ($response->getStatusCode() === 200) {
            return json_decode($response->getBody()->getContents());
        }
    
        return null;
    }
    
    private function getAllBookPricing()
    {
        $response = $this->client->get('http://api.localtest.me/book_pricing');
    
        if ($response->getStatusCode() === 200) {
            return json_decode($response->getBody()->getContents());
        }
    
        return null;
    }   
    
    private function mergeBooksAndPricing($booksObject, $booksPrice) {
        // Create a mapping of books by their id
        $bookMap = [];
        foreach ($booksPrice as $book) {
            $bookMap[$book['id']] = $book;
        }
    
        // Merge arrays
        $mergedArray = [];
        foreach ($booksObject as $pricing) {
            $bookId = $pricing['book_id'];
            if (isset($bookMap[$bookId])) {
                $mergedEntry = array_merge($pricing, $bookMap[$bookId]);
                $mergedArray[] = $mergedEntry;
            }
        }
    
        return $mergedArray;
    }
}
