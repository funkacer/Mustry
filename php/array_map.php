<?php
    $result = ["ext:BOW:1", "ext:BOW:2", "ext:BOW:3"];
    $inFb = array_map(function($item) { return explode('ext:BOW:', $item)[1]; }, $result);
    for ($i = 0; $i < count($result); $i++) {
        echo $result[$i] . " - " . $inFb[$i] . "\n";
    }
?>