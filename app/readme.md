From within this directory:

- Run composer install \
    - Mac
        - `docker run --rm --interactive --tty --volume $PWD:/app composer install`
    - Windows
        - `docker run --rm --interactive --tty --volume ${PWD}:/app composer installl`
    - Other option(for example)
        - `docker run --rm --interactive --tty --volume  C:\mukuru\source\assess-test\app:/app composer install`
