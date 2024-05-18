<?php
/**
 * @var array $books
 */
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/fonts/icomoon/style.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Books Listing</title>
  </head>
  <body>
    <div class="content">
      <div class="container">

        <div class="table-responsive">
          <table class="table table-striped_ custom-table"><tr>
                <th scope="col"><h2 class="mb-5" >Books Listing</h2></th>
                <th scope="col">
                  <span class="mb-5" style="float: right;">
                    <a href="/books/create" style="border: 1px solid #2a272b; padding: 10px; background: #2a272b; border-radius: 8px; color: #959595;">Create New Book</a>
                  </span>
                </th>
              </tr></table>
        </div>
      
        <div class="table-responsive">
          <table class="table table-striped custom-table">
            <thead>
              <tr>
                <th scope="col">Title & Author</th>
                <th scope="col">Currency</th>
                <th scope="col">Price</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($books as $book): ?>
                  <tr>
                      <td> <?= $book->title ?> <small class="d-block"> <?= $book->first_name ?> <?= $book->last_name ?> </small></td>
                      <td><?= $book->pricing->name ?></td>
                      <td><?= $book->pricing->iso ?> <?= $book->pricing->price ?></td>
                      <td><a href="#" class="more">Details</a></td>
                  </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>
  </body>
</html>