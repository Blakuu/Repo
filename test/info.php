<?php
//echo date('Y-m-d');
echo date('i, ');

$i = date('i');
if ($i % 2 == 0) {

	echo "minuta parzysta";

} else {
	echo "minuta nieparzysta";
}
echo "<br>";
?>

<?php

$integer = ('04322808919 ');
echo ($integer);
echo array_sum(str_split($integer));
echo "<br>";	
echo (' str_split rodziela na cyfry, a array_sum je sumuje')
?>
<pre>
Zadanie 3:
Odbierz wartość z pola input ($_POST['variable']).
- Jeśli będzie to tekst krótszy niż 10 znaków - wyświetl taki komunikat.
- W przeciwnym wypadku zamień go na duże litery (strtoupper) i wyświetl.


</pre>
<form method="post">
    <input type="number" name="variable" >
    <input type="submit" value="dalej" >
</form>

<?php
 $text = $_POST['variable'];
 echo($text)
?>
