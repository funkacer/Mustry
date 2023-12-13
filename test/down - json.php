<?php

    // konfigurace serveru 
    $host = "https://demo.flexibee.eu";
    $firma = "demo"; 
    $ch = curl_init(); 
    // create curl resource 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    // return content as a string from curl_exec 
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE); 
    // follow redirects (compatibility for future changes in Flexi) 
    curl_setopt($ch, CURLOPT_HTTPAUTH, TRUE); 
    // HTTP authentication 
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
    // Flexi by default uses Self-Signed certificates 
    // curl_setopt($ch, CURLOPT_VERBOSE, TRUE); 
    // For debugging 
    curl_setopt($ch, CURLOPT_USERPWD, "winstrom:winstrom"); // set username and password

    $evidence = "faktura-prijata/6143";
    // Požadavek ve formátu XML 
    curl_setopt($ch, CURLOPT_URL, $host."/c/".$firma."/".$evidence.".xml");
    // Nastavení samotné operace 
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); 
    // Nastavení parametrů pro založení jednoduché faktury 
    $output = curl_exec($ch);

    //var_dump($output);

    $evidence = "faktura-prijata";
    $id = "6143";
    //$evidence = "objednavka-prijata";

    // Požadavek ve formátu JSON 
    //curl_setopt($ch, CURLOPT_URL, $host."/c/".$firma."/".$evidence.".json");
    curl_setopt($ch, CURLOPT_URL, $host."/c/".$firma."/".$evidence."/".$id.".json");
    // Nastavení samotné operace 
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); 
    // Nastavení parametrů pro založení jednoduché faktury 
    $output = curl_exec($ch);

    //$output = file_get_contents ($host."/c/".$firma."/objednavka-prijata.json");

    //var_dump ($output);

    $objectJSON = json_decode($output);
    var_dump ($objectJSON);

    foreach($objectJSON->{"winstrom"}->{$evidence} AS $obj) {
        //var_dump ($obj);
        //$suma += $obj->{"sumCelkem"};
        var_dump($obj);
    }

    //echo $objectJSON->{"winstrom"}->{$evidence}[0]->{"kod"};

    $dokladJson = $objectJSON->{"winstrom"}->{$evidence}[0];

    //dekóduje do pole;
    $doklad = json_decode(json_encode($dokladJson), true);

    $objectJSON = json_decode($output);

    //echo var_dump($object);
    //echo var_dump($xmlFile->{"objednavka-prijata"}[0]);
    $suma = 0;
    foreach($objectJSON->{"winstrom"}->{"objednavka-prijata"} AS $obj) {
        //echo $obj->{"sumCelkem"};
        $suma += $obj->{"sumCelkem"};
    }

    echo "\n";
    $pocet = count($objectJSON->{"winstrom"}->{"objednavka-prijata"});
    echo "Celkem je suma přijatých objednávek: $suma pro $pocet objednávek";

    //var_dump($object->{"winstrom"}->{"objednavka-prijata"});

    $fileName = "export.json";
    file_put_contents($fileName, $output);

    //$fileName = "import.json";
    //$output = file_get_contents($fileName);

    // Požadavek odešleme ve formátu XML 
    //curl_setopt($ch, CURLOPT_URL, $host."/c/".$firma."/objednavka-prijata.xml");
    // Nastavení samotné operace 
    //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); 
    // Nastavení parametrů pro založení jednoduché faktury 
    //curl_setopt($ch, CURLOPT_POSTFIELDS, '   code:FAKTURA code:WINSTROM Moje faktura v PHP1000.0 true   ');
 
    
?>