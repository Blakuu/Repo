<?php

var_dump($_POST);

// uzupełniamy dane: date...
$record = $_POST;
$record['created_at'] = time();

$record['content'] = strip_tags($record['content']);//tagi

$record['content'] = addslashes($record['content']);// slesze

$record['content'] = trim($record['content']);//białe spacje na początku

//zastąpienie wyrazów z "czarnej listy"
$bad_words = [

	'dupa',
	'pierd',
	'kurw',


];
$replacement = '***';
$record['content'] = str_replace($bad_words, $replacement, $record['content']);


var_dump($record);

//dostajemy sie do bazy
$db = new mysqli('localhost', 'root', '', 'lokalny12',3307);
//budujemy query: INSERT INTO...
$query = "INSERT INTO comment (id, movie_id, content, created_at, author) VALUES (NULL, {$record['movie_id']}, '{$record['content']}' ,
{$record['created_at']},
'{$record['author']}'
)";

//wysyłamy zapytanie
$resource = $db->query($query);

// disconnect z bazą
$db->close();
// wracamy do strony
header('Location: '.$_SERVER['HTTP_REFERER']);
exit;