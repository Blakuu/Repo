<?php

// ustanawiam połączenie z bazy

$db = new mysqli('loclahost','root','','lokalny12'); // serwer, user, hasło, baza





$query = "SELECT * FROM movie WHERE active=1"; // zapytanie do pobierania danych

$resource = $db->query($query); // inicjuję wysyłkę zapytania - do zmiennej resources

$movies = [];

while ( $row = $resource->fetch_assoc() ) { // pobieram do zmiennej $row zawartość jednego rekordu pobranego z $resources

    //print_r($row);

    //echo '<h3>'.$row['title'].'</h3>';

    $movies[] = $row;

}

$resource->free(); // zwalniam zasoby po pobieraniu danych


$query = "SELECT * FROM movie WHERE active=0"; // zapytanie do pobierania danych

$resource = $db->query($query); // inicjuję wysyłkę zapytania - do zmiennej resources

$moviesunactive = [];

while ( $row = $resource->fetch_assoc() ) { // pobieram do zmiennej $row zawartość jednego rekordu pobranego z $resources

    //print_r($row);

    //echo '<h3>'.$row['title'].'</h3>';

    $moviesunactive[] = $row;

}

$resource->free(); // zwalniam zasoby po pobieraniu danych

// tu mogę dokonać więcej operacji pobierania itp

// ...







$db->close(); // zamykam połączenie z bazą

?>



<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>My favourite movies</title>

</head>

<body>



<?php foreach ($movies as $movie): ?>

    <h3><?= $movie['title'] ?>(<?= $movie['date']?>)</h3>
    <p><?= $movie['producers'] ?></p>
    <p><?= $movie['description']?></p>

<?php endforeach; ?>
<p>Do obejrzenia</p>
<?php foreach ($moviesunactive as $moviesunactive): ?>

    <h3><?= $moviesunactive['title'] ?>(<?= $moviesunactive['date']?>)</h3>
    <p><?= $moviesunactive['producers'] ?></p>
    <p><?= $moviesunactive['description']?></p>

<?php endforeach; ?>

</body>

</html>