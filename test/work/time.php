<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<form action="">
    <input type="number" name="year" required
           placeholder="rok" step="1"
           value="<?= isset($_GET['year']) ? $_GET['year'] : '' ?>"
           min="1" max="3000"
    >
    <input type="number" name="month" required
           placeholder="miesiąc" step="1"
           value="<?= isset($_GET['month']) ? $_GET['month'] : '' ?>"
           min="1" max="12"
    >
    <input type="number" name="day" required
           placeholder="dzień" step="1"
           value="<?= isset($_GET['day']) ? $_GET['day']:'' ?>"
           min="1" max="31"
    >
    <input type="submit" name="sendButton" value="DALEJ">
</form>
<pre>
<strong>Zadanie</strong>
Odbierz dane urodzin użytkownika i wskaż jaki to był dzień tygodnia.
</pre>

<p>
    <?php
        // tu twój kod
        // skrypt zadziałą tylko po wysłaniu formularza lub odebraniu danych z adresu
        // pełna lista warunków (nie zawiera zabezpieczenia ruchu z zewnątrz)
        if (
            !isset($_GET['sendButton'])
            || $_GET['sendButton']!='DALEJ'
            || !isset($_GET['year'])
            || empty($_GET['month'])
            || empty($_GET['day'])
            || !is_numeric($_GET['year'])
            || !is_numeric($_GET['month'])
            || !is_numeric($_GET['day'])
            || $_GET['month'] < 0
            || $_GET['month'] > 12
            || $_GET['day'] < 0
            || $_GET['day'] > 31
        ) {
            return ;
        }
        // buduję datę w formacie: yyyy-mm-dd - dane odebrane z formularza:
        $date = $_GET['year'] .'-'. $_GET['month'] . '-' . $_GET['day'];
        echo 'podano datę: '. $date;
        echo '<BR>';
        $timestamp = strtotime($date);
        echo 'data po zamianie na sek w formacie Unix timestamp: '.$timestamp;
        echo '<BR>';
        echo 'dzien tygodnia odczytany z daty: '. date('N', $timestamp);
    ?>


</p>
</body>
</html>