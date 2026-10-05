<?php

require_once('./connection.php');

$id = $_GET['id'];


$stmt = $pdo->prepare('
SELECT b.*, a.first_name, a.last_name
FROM books b
LEFT JOIN book_authors ba ON b.id = ba.book_id
LEFT JOIN authors a ON ba.author_id = a.id
WHERE b.id = :id
');

$stmt->execute(['id' => $id]);
$book = $stmt->fetch();


$stmt2 = $pdo->prepare("
SELECT id, first_name, last_name 
FROM authors
WHERE id NOT IN (
    SELECT author_id 
    FROM book_authors 
    WHERE book_id = :book_id
)
");

$stmt2->execute(['book_id' => $id]);
$available_authors = $stmt2->fetchAll();

?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>  

    <form action="update.php" method="post">
        <input type="text" name="id" value="<?=$id;?>" >

        <input type="text" name="title" value="<?= $book['title']; ?>" >

        <input type="text" name="release_date" value="<?= $book['release_date']; ?>" >

        <input type="text" name="name" value="<?= $book['first_name']; ?> <?= $book['last_name']; ?>" >

        <input type="text" name="price" value="<?= $book['price']; ?>" >

        <input type="text" name="pages" value="<?= $book['pages']; ?>" >

        <input type="text" name="language" value="<?= $book['language']; ?>" >

        <button type="submit">Salvesta</button>

    </form>

<h3>Lisa olemasolev autor</h3>

<form method="post" action="attach_author.php">

    <input type="hidden" name="book_id" value="<?= $id ?>">

    <select name="author_id" required>
        <option value="">Vali autor</option>

        <?php foreach ($available_authors as $author) { ?>
            <option value="<?= $author['id'] ?>">
                <?= $author['first_name'] ?> <?= $author['last_name'] ?>
            </option>
        <?php } ?>

    </select>

    <button type="submit">Lisa autor</button>

</form>

    

    <h3>Lisa uus autor</h3>

    <form method="post" action="add_author.php">
        <input type="hidden" name="book_id" value="<?= $id ?>">
        <input type="text" name="first_name" placeholder="Eesnimi" required>
        <input type="text" name="last_name" placeholder="Perenimi" required>
        <button type="submit">Lisa autor</button>
    </form>

</body>
</html>
