<?php

$fn = 'https://www.lekarskyemail.cz/googlemap/data.js';
$content = file_get_contents($fn);
$convertToString = iconv($in_charset = 'UTF-16LE', $out_charset = 'UTF-8', $content);
$convertToString = str_replace("var data=", "", $convertToString);
$convertToString = preg_replace('/,fromTo.*/s', '', $convertToString)."}";
$convertToString = str_replace("nazev1", "\"nazev1\"", $convertToString);

$convertToString = str_replace("nazev2", "\"nazev2\"", $convertToString);
$convertToString = str_replace("{date:", "{\"date\":", $convertToString);
$convertToString = str_replace("uzivatele", "\"uzivatele\"", $convertToString);
$convertToString = preg_replace("/'/s", "xAPSx", $convertToString);
$convertToString = str_replace(array("{id:", "loc:", "{lat:", "lng", "title", "odb:", "ulice", "mesto", "osoba", "psc", "odb_kod", "domena", "datumAktivace"),
	array("{\"id\":", "\"loc\":", "{\"lat\":", "\"lng\"", "\"title\"", "\"odb\":", "\"ulice\"", "\"mesto\"", "\"osoba\"", "\"psc\"", "\"odb_kod\"", "\"domena\"", "\"datumAktivace\""), $convertToString);

$convertToString = preg_replace("/]}/s", "{\"end\":\"end\"}]}", $convertToString);

for ($i = 0; $i <= 31; ++$i) {
	$convertToString = str_replace(chr($i), "", $convertToString);
}
$convertToString = str_replace(chr(127), "", $convertToString);

if (0 === strpos(bin2hex($convertToString), 'efbbbf')) {
	$convertToString = substr($convertToString, 3);
}
$convertToString = json_decode($convertToString, true);
//print_r($convertToString);
//echo $convertToString;

foreach ($convertToString['uzivatele'] as $uzivatel) {



	if (substr($uzivatel['id'], -3) == 000 && $uzivatel['id']) {
		for ($i = 1; $i <= 999; $i++) {


			echo substr($uzivatel['id'], 0, 5).sprintf('%03d', $i).";".$uzivatel['title']."<br>";
		}

	} else
	{
		echo $uzivatel['id'].";".$uzivatel['title']."<br>";
	}
}







?>