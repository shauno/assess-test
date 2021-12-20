<?php
/**
 * @var array $authors
 */
?>
<form method="get" action="">
    <table>
        <tr>
            <td>Author</td>
            <td>
                <select name="author_id">
                    <?php foreach ($authors as $author): ?>
                        <option value="<?= $author->id ?>"><?= $author->first_name ?> <?= $author->last_name ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>

        <tr>
            <td>Title</td>
            <td><input type="text" name="title" required="true"/> </td>
        </tr>
        <tr>
            <td>Description</td>
            <td><input type="text" name="description" /> </td>
        </tr>

        <tr>
            <td>Price

                <select name="currency">
                    <?php foreach ($currencies as $currency): ?>
                        <option value="<?= $currency->iso ?>">
                            <?= $currency->iso ?>
                        </option>
                    <?php endforeach; ?>

                 </select>

            </td>
            <td><input type="number" name="price" required="true" min="0" step="0.01"/></td>
        </tr>

        <tr>
            <td colspan="2" align="right">
                <input type="submit" value="Create" />
            </td>
            <td colspan="2" align="right">
                <a href="/">Back</a>
            </td>
        </tr>
    </table>
</form>
