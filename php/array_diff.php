<?php

//$kody1 = array_column(array_column($data, 'cenik'), 'kod');
$kody1 = ["kod1", "kod2", "kod1", "kod3"];

/*
$allPrefix = $this->flexibee->get('cenik', ['kod' => ['@begins' => $prefix]], [
    'detail' => ['kod', 'nazev'], "limit" => 0
]);
*/

//$kody2 = array_column($allPrefix, 'kod');
$kody2 = ["kod1", "kod4"];
//bdump(count($kody2), "kody2");

$diffPrefix = array_diff($kody2, array_unique($kody1));
//bdump($diffPrefix);

$countPrefix = count($diffPrefix);

var_dump($diffPrefix);
var_dump($countPrefix);

?>