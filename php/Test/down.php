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

    $output = curl_exec($ch);
    $info = curl_getinfo($ch);
    if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200 && curl_getinfo($ch, CURLINFO_HTTP_CODE) != 201) { 
        printf ("Při operaci nastala chyba (HTTP %d): %s\n", curl_getinfo($ch, CURLINFO_HTTP_CODE), $output); } 
    // close curl resource to free up system resources 
    //curl_close($ch);

    //objednavka-prijata faktura-vydana
    // Požadavek odešleme ve formátu XML 
    //curl_setopt($ch, CURLOPT_URL, $host."/c/".$firma."/objednavka-prijata.xml");
    // Nastavení samotné operace 
    //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); 
    // Nastavení parametrů pro založení jednoduché faktury 
    //curl_setopt($ch, CURLOPT_POSTFIELDS, '   code:FAKTURA code:WINSTROM Moje faktura v PHP1000.0 true   ');

    //$output = file_get_contents ($host."/c/".$firma."/objednavka-prijata.xml");
    curl_setopt($ch, CURLOPT_URL, $host."/c/".$firma."/objednavka-prijata.xml");
    $output = curl_exec($ch);
    $info = curl_getinfo($ch);
    //var_dump($info);
    printf ("Výsledek operace: HTTP %d.", $info['http_code']);
    curl_close($ch);

    //echo $output;

    $xmlFile = new SimpleXMLElement($output);

    //echo var_dump($xmlFile);
    //echo var_dump($xmlFile->{"objednavka-prijata"}[0]);
    $suma = 0;
    foreach($xmlFile->{"objednavka-prijata"} AS $obj) {
        //echo $obj->{"sumCelkem"};
        $suma += $obj->{"sumCelkem"};
    }

    echo "\n";
    $pocet = count($xmlFile->{"objednavka-prijata"});
    echo "Celkem je suma přijatých objednávek: $suma pro $pocet objednávek";

 
    
?>