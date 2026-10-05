
<?php

require_once('./connection.php');

$id = $_GET['id'];


$stmt = $pdo->prepare('SELECT b.* FROM books b WHERE b.id = :id AND b.is_deleted = 0');
$stmt->execute(['id' => $id]);
$book = $stmt->fetch();

// võtab autorid
$stmt = $pdo->prepare("SELECT authors.id as author_id, first_name, last_name FROM authors 
LEFT JOIN book_authors ON author_id = authors.id WHERE book_id = :id");
$stmt->execute(['id' => $id]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
    <a href="index.php">Tagasi </a>
    <h2><?= $book['title']; ?></h2>
    <p>Release date: <?= $book['release_date']; ?></p>
    <ul>
<?php while ($author = $stmt->fetch()) { ?>

        <li>
            <?= $author['first_name']; ?> <?= $author['last_name']; ?>

            <a href="remove_author.php?book_id=<?= $id ?>&author_id=<?= $author['author_id']; ?>"
            onclick="return confirm('Kas eemaldada autor?')">
            Eemalda
            </a>

        </li>

<?php } ?>
    </ul>
    <p>Price: <?= round($book['price'], 2); ?></p>
    <p>Pages: <?= $book['pages']; ?></p>
    <p>Summary: <?= $book['summary']; ?></p>
    <p>Language: <?= $book['language']; ?></p>
    <p>Stock: <?= $book['stock_saldo']; ?></p>
    <p>Type: <?= $book['type']; ?></p>
    <img src="<?= $book['cover_path']; ?>">

    <br>
    <a href="edit.php?id=<?= $book['id']; ?>">Muuda</a>

    <a href="delete.php?id=<?= $book['id']; ?>"
        onclick="return confirm('Kas oled kindel, et soovid kustutada?')">
        Kustuta
    </a>
    
    
</body>
</html>
