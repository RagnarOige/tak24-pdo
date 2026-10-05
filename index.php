<?php
require_once('./connection.php');

$search = $_GET['search'] ?? '';

if ($search) {
    $stmt = $pdo->prepare("SELECT id, title FROM books WHERE is_deleted = 0 AND title LIKE :search");

    $stmt->execute(['search' => '%' . $search . '%']);

} else {
    $stmt = $pdo->query("SELECT id, title FROM books WHERE is_deleted = 0");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raamatupood</title>
</head>
<body>

<form method="get">
    <input type="text" name="search" placeholder="Otsi raamatut" value="<?=($search) ?>">
    <button type="submit">Otsi</button>
</form>

    

    <ul>
    <?php while ( $book = $stmt->fetch() ) { ?>

        <li>
            <a href="book.php?id=<?= $book['id']; ?>">
                <?= $book['title']; ?>     
            </a>
        </li>

        
        
<?php } ?>

    </ul>
    

</body>
</html>