<?php

namespace App\Books;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Slim\Views\PhpRenderer;
use GuzzleHttp\Client;
use Respect\Validation\Validator as v;
use Symfony\Component\Yaml\Dumper;

class BooksController
{
    public function index(Request $request, Response $response)
    {
        $httpClient = new Client();

        // Retrieve all books
        $booksResponse = $httpClient->get('http://api.localtest.me/books');
        $booksData = json_decode($booksResponse->getBody());

        // Retrieve all authors
        $authorsResponse = $httpClient->get('http://api.localtest.me/authors');
        $authorsData = json_decode($authorsResponse->getBody());

        // Retrieve all authors
        $pricingResponse = $httpClient->get('http://api.localtest.me/pricing');
        $pricingCurrencyData = json_decode($pricingResponse->getBody());

        $currencyResponse = $httpClient->get('http://api.localtest.me/currency');
        $currencyData = json_decode($currencyResponse->getBody());

        // Associate each book with its corresponding author
        foreach ($booksData as $bookKey => $book) {
            foreach ($authorsData as $author) {
                if ($book->author_id == $author->id) {
                    $booksData[$bookKey]->author = $author;
                    break;
                }
            }
        }

        // Associate each book with its corresponding author
        foreach ($pricingCurrencyData->pricing as $key => $price) {
            foreach ($pricingCurrencyData->currencies as $currency) {
                if ($price->currency_id == $currency->id) {
                    $pricingCurrencyData->pricing[$key]->currency = $currency;
                    break;
                }
            }
        }

        // // // $priceCurrencyObject = $pricingCurrencyData->pricing;

        // Associate each book with its corresponding author
        foreach ($booksData as $bookKey => $book) {
            foreach ($book->pricing as $pricing) {
                foreach ($currencyData as $currency)
                if ($pricing->currency_id == $currency->id) {
                    $booksData[$bookKey]->currency = $currency;
                    break;
                }
            }
        
            foreach ($pricingCurrencyData->pricing as $priceCurrency) {
                if ($book->id == $priceCurrency->book_id) {
                    $booksData[$bookKey]->pricing = $priceCurrency;
                    break;
                }
            }

        }

        // Render the list of books
        $renderer = new PhpRenderer('../src/Books/templates/');
        return $renderer->render($response, 'list.php', [
            'books' => $booksData,
            'pricing' => $pricingCurrencyData,
        ]);

    }

    public function create(Request $request, Response $response)
    {
        // Check if form data has been sent
        if ($params = $request->getQueryParams()) {
            // Make the api call to create the book
            $ch = curl_init('http://api.localtest.me/books/create?'.http_build_query($params));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch);
            curl_close($ch);

            // Redirect back to book listing
            return $response->withStatus(302)->withHeader('Location', '/books');
        }

        // Get all the authors
        $ch = curl_init('http://api.localtest.me/authors');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $authors = json_decode(curl_exec($ch));
        curl_close($ch);

        // Get all the authors
        $ch = curl_init('http://api.localtest.me/currency');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $currency = json_decode(curl_exec($ch));
        curl_close($ch);

        $renderer = new PhpRenderer('../src/Books/templates/');

        return $renderer->render($response, 'create.php', [
            'authors' => $authors,
            'currency' => $currency,
        ]);
    }
}
