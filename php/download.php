<?php
    $xmls = ["https://katalog.mav.cz/zbozi2_alt1.xml", "https://katalog.mav.cz/zbozi2_alt2.xml", "https://katalog.mav.cz/zbozi2_alt3.xml"];
    /*
    $xmls = ["https://www.d-a-t.cz/feed-bondhus.xml", "https://www.d-a-t.cz/feed-projahn.xml", "https://www.d-a-t.cz/feed-ptg.xml",
    "https://www.d-a-t.cz/feed-rennsteig.xml", "https://www.d-a-t.cz/feed-scangrip.xml", "https://www.d-a-t.cz/feed-silbertool.xml",
    "https://www.d-a-t.cz/feed-volkel.xml", "https://www.d-a-t.cz/feed-witte.xml", "https://www.d-a-t.cz/feed/knipex/op2zPYtA5utPK6Say6FDWqkSi.xml"];
    */
    foreach ($xmls as $xml) {
        $fileContent = file_get_contents($xml);
        $res = file_put_contents(explode("/", $xml)[substr_count($xml, "/")], $fileContent);
        echo $res;
    }
?>