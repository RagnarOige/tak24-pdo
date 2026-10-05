<?php
require_once('./connection.php');
$id = $_POST['id'];




$stmt = $pdo->prepare('UPDATE books SET title = :title, release_date = :release_date, price = :price, pages = :pages, language = :language
WHERE id = :id
');
$stmt->execute([
    'title' => $_POST['title'],
    'release_date' => $_POST['release_date'],
    'price' => $_POST['price'],
    'pages' => $_POST['pages'],
    'language' => $_POST['language'],
    'id' => $id
]);


$nameParts = array_filter(explode(' ', $_POST['name'])); 


$stmt = $pdo->prepare('DELETE ba FROM book_authors ba JOIN authors a ON a.id = ba.author_id WHERE ba.book_id = :book_id
AND :name_empty = 1');
$stmt->execute([
    'book_id' => $id,
    'name_empty' => empty($nameParts) ? 1 : 0
]);


$nameParts = array_pad($nameParts, 2, ''); 
$stmt = $pdo->prepare('UPDATE authors a JOIN book_authors ba ON a.id = ba.author_id SET a.first_name = :first, a.last_name = :last
WHERE ba.book_id = :book_id AND :name_not_empty = 1
');
$stmt->execute([
    'first' => $nameParts[0],
    'last'  => $nameParts[1],
    'book_id' => $id,
    'name_not_empty' => !empty($nameParts) ? 1 : 0
]);

header('Location: book.php?id=' . $id);