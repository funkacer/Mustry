<?php

//$kody[$r] = $polozka['cenik']['kod'];

$kody[1] = "Kod na radku 1";
$kody[2] = "Kod na radku 2";
$kody[3] = "Kod na radku 1";
$polozky = $kody;
$duplicity = array_diff_assoc($kody, array_unique($kody));
foreach($duplicity as $r => $kod) {
    unset($polozky[$r]);
    $duplicity[$r] = "duplicita se řádkem " . array_search($kod, $kody);
}
var_dump($kody);
var_dump($polozky);
var_dump($duplicity);
?>