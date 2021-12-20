<?php
/**
 * @var array $books
 */
?>

<table class="table">
    <tr>
        <th>Author</th>
        <th>Title</th>
        <th>Description</th>
        <th>Amounts</th>

    </tr>
    <?php foreach ($books as $book): ?>
        <tr>
            <td><?= $book->name ?> <?= $book->surname ?></td>
            <td><?= $book->book_title ?></td>
            <td><?= $book->book_description ?></td>
            <td><?= $book->currency ?> <?= $book->amount ?></td>

        </tr>
    <?php endforeach; ?>
</table>

<a href="/books/create">Create New Book</a>
