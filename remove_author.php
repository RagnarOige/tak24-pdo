<?php

require_once('./connection.php');

$book_id = $_GET['book_id'];
$author_id = $_GET['author_id'];

$stmt = $pdo->prepare("DELETE FROM book_authors
WHERE book_id = :book_id AND author_id = :author_id
");

$stmt->execute([
    'book_id' => $book_id,
    'author_id' => $author_id
]);

header("Location: book.php?id=" . $book_id);
exit;