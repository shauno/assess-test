<?php
/**
 * @var array $books
 * @var PDO $db
 */
?>

<table>
    <tr>
        <th>Title</th>
        <th>Author</th>
    </tr>
    <?php foreach ($books as $book): ?>
        <tr>
            <td><?= $book['title'] ?></td>
            <?php
            $author = $db->query('SELECT * FROM authors WHERE id = '.$book['author_id'])->fetch();
            ?>
            <td><?= $author['first_name'] ?> <?= $author['last_name'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<a href="/books/create">Create New Book</a>
