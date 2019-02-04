## Quickstart

- Run composer install \
`docker run --rm --interactive --tty --volume $PWD:/app composer install`
  
- Bring up the docker containers \
`docker-compose up --build`

- Run database migrations \
`docker-compose exec app php vendor/bin/phinx migrate`

- Insert seed data \
`docker-compose exec app php vendor/bin/phinx seed:run`

- Open [http://127.0.0.1:8080](http://127.0.0.1:8080) in your browser

## Idea

_Obviously we would need to create a new repo from this to remove the commit history and this description. I'm just hosting this here to get feedback for the time being_

---

The app that has been created is trying to mimic something similar everyday Valtari work. I would also like to incorporate an API component in someway as that is a large part of the dev role, but for now this is more focused on a Valtari type setup until I have any ideas (suggestions welcome).

I wanted to create this without a depedency on a fullstack framework as that would give a disadvantage to candidates who have not used that framework. I chose to use Slim for pretty much just routing, as I believe a senior developer should be able to pick up it's implementation quickly by skimming the code even if they've never used it specifically.

Basically all requests are passed through `public/index.php` which requires composer's autoloader and a `app/routes.php` file. The routes file bootstraps Slim as a router (without DI) and defines 2 basic routes:
- List books page
- Create book page

The routes call methods on the `BooksController`. As there is no DI by default I feel the code is very simple to grok and understand on first glance.

My plan is to give the developer a few minutes to go through it with me, and ask what code smells and issues they see. I don't think we could takle everything in 45min - 1 hour so I will guide the process somewhat trying to addresses at least the following:

- DI into controller for template engine and DB connection
- Environment vars for the DB connection detials
- Not passing the DB connection to the template in the BooksController::index() method, and getting the author data in the initial query
- Not selecting * in all the queries
- Output sanitation of variables in listing template
- Change form action to POST when creating new book
- Input sanitation in query to insert new book and price
- Validation and error handling
- Perhaps suggest bringing in an ORM to clean up the raw selects and inserts
- Possibly suggest unquie key on (book_id, currency_id) in book_pricing table

The create screen currently only allows a ZAR price to be entered, although the db schema and seed data has multiple prices associated with each book. It would be good to chat through (and implement if time allows) adding the ability to capture all possible prices on creation.
Another task could be to allow updating the create screen to allow editing existing books, and hadling the multiple currencies that way

Another area I have seen developers struggle is SQL. The simple db schema allows me to ask them to write a few simple queries such as:
- Find all books by author X
- Find the number of books each author has that have a USD price
