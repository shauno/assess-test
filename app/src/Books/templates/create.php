<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/fonts/icomoon/style.css">
    <link rel="stylesheet" href="/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <title>Books Listing</title>
  </head>
  <body>
    <div class="content">
      <div class="container">

        <div class="table-responsive">
          <table class="table table-striped_ custom-table"><tr>
                <th scope="col"><h2 class="mb-5" >Add New Book</h2></th>
                <th scope="col">
                  <span class="mb-5" style="float: right;">
                    <a href="/books" style="border: 1px solid #2a272b; padding: 10px; background: #2a272b; border-radius: 8px; color: #959595;">Back to Listings</a>
                  </span>
                </th>
              </tr></table>
        </div>

        <form method="GET" action="">
    <div class="form-group row">
        <div class="col-sm-10  offset-sm-2">
            <select id="author" name="author_id" class="form-control" required>
                <option>Please Select Author</option>
                <?php foreach ($authors as $author): ?>
                    <option value="<?= $author->id ?>"><?= $author->first_name ?> <?= $author->last_name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group row" style="color: whitesmoke;">
                <div class="col-sm-10  offset-sm-2">
                    <input type="text" id="title" name="title" class="form-control" placeholder="Book Title" required>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-10  offset-sm-2">
                    <select id="currency" name="currency_symbol" class="form-control" required>
                    <option>Please Select Currency</option>
                        <?php foreach ($currency as $cur): ?>
                            <option value="<?= $cur->iso ?>"><?= $cur->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <!-- <label for="price" class="col-sm-2 col-form-label">Price</label> -->
                <div class="col-sm-10  offset-sm-2">
                    <input type="text" id="price" name="price" class="form-control" placeholder="Price" required>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </div>
        </form>
    
      </div>
    </div>
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>
  </body>
</html>