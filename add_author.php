<?php
require_once('./connection.php');

$first = $_POST['first_name'];
$last = $_POST['last_name'];
$book_id = $_POST['book_id'];
$author_id = $_POST['author_id'];

//lisab autori
$stmt = $pdo->prepare("INSERT INTO authors (first_name, last_name) VALUES (:first, :last)");

$stmt->execute([
    'first' => $first,
    'last' => $last
]);

$author_id = $pdo->lastInsertId();

//seob raamatuga
$stmt = $pdo->prepare("INSERT INTO book_authors (book_id, author_id) VALUES (:book_id, :author_id)");

$stmt->execute([
    'book_id' => $book_id,
    'author_id' => $author_id
]);



header("Location: edit.php?id=" . $book_id);
exit;