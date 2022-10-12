From within this directory:

- Run composer install \
`docker run --rm --volume ${PWD}:/app composer install -n --ignore-platform-reqs`

- Run database migrations \
`docker-compose exec api php vendor/bin/phinx migrate`

- Insert seed data \
`docker-compose exec api php vendor/bin/phinx seed:run`
