- Run composer install \
`docker run --rm --interactive --tty --volume $PWD:/app composer install`
  
- Bring up the docker containers \
`docker-compose up --build`

- Run database migrations \
`docker-compose exec app php vendor/bin/phinx migrate`

- Insert seed data \
`docker-compose exec app php vendor/bin/phinx seed:run`