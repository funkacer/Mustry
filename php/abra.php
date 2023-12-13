<?php

    //carta pro zjištění stavu skladu dle videa 05CPMINJW3DL342X01C0CX3FCC

    // konfigurace serveru 
    $host = "";
    $firma = "";
    //$credentials = ["", ""];
    $username = "";
    $password = "";

    /*
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
    curl_setopt($ch, CURLOPT_USERPWD, "arit:pos"); // set username and password
    */

    /*
    FlexibeeAuthenticator
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_HTTPAUTH, TRUE);
    curl_setopt($ch, CURLOPT_USERPWD, $credentials[0] . ':' . $credentials[1]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_URL, $companyUrl);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    */

    $evidence = "firms";
    $detail = ["id","bodycode","name","orgidentnumber","vatidentnumber","residenceaddress_id.street","residenceaddress_id.city","residenceaddress_id.postcode","residenceaddress_id.country","residenceaddress_id.email"];
    $start = 0;
    $limit = 99;
    /*
    // Požadavek ve formátu XML
    curl_setopt($ch, CURLOPT_URL, $host."/".$firma."/".$evidence."?select=".implode(",", $detail)."&skip=".$start."&take=".$limit);
    //."&where="."name eq 'ABRA Software a.s.'"
    //curl_setopt($ch, CURLOPT_URL, "http://172.16.100.14:8082/demodata/storeprices?select=*&expand=PriceRows,StoreCard_ID");
    //curl_setopt($ch, CURLOPT_URL, "http://172.16.100.14:8082/demodata/storeprices?select=*&expand=PriceRows,StoreCard_ID&where=PriceList_ID eq '2100000101' and PriceListValidity_ID eq null");
    // Nastavení samotné operace
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    // Nastavení parametrů pro založení jednoduché faktury
    $output = curl_exec($ch);

    //var_dump($output);

    //$objectJSONs = json_decode($output);
    $objects = json_decode($output, true);
    //var_dump($objects);
    //die;
    foreach($objects as $id => $object) {
        //var_dump ("id".$id.":".$objectJSON->{"residenceaddress_id.postcode"});

        //var_dump ("id".$id.": ".$objectJSON["residenceaddress_id.postcode"]);
        //var_dump ("id".$id.": ".$object["name"]);
    }

    //die;

    */

    $moje = new ObjAbraGenImpl($host."/".$firma);
    //$moje->authenticate($credentials);
    //var_dump($moje->camelCase("aritčarit", [""]));
    //die;
    $moje->auth($username, $password);
    /*
    var_dump("Numeric filter");
    //$response = $moje->get($evidence, 3000000101, $detail);
    $response = $moje->get(
        $evidence,
        3000000101,
        [
            'limit' => $limit,
            'start' => $start,
            'detail' => $detail
        ]
    );
    var_dump($response);
    //die;
    var_dump("Null filter no limit");
    $response = $moje->get(
        $evidence,
        null,
        [
            'limit' => null,
            'start' => null,
            'detail' => $detail
        ]
    );
    var_dump($response);
    //die;
    var_dump("Null filter with limit");
    $response = $moje->get(
        $evidence,
        null,
        [
            'limit' => $limit,
            'start' => $start,
            'detail' => $detail
        ]
    );
    var_dump($response);
    //die;
    /*
    var_dump("In filter with limit");
    $response = $moje->get(
        $evidence,
        "id in ('3200000101', '3000000101')",
        [
            'limit' => $limit,
            'start' => $start,
            'detail' => $detail
        ]
    );
    var_dump($response);
    //die;
    var_dump("Select * with expand, No filter with limit");
    $response = $moje->get(
        'storeprices',
        null,
        [
            'limit' => $limit,
            'start' => $start,
            'detail' => ["*&expand=PriceRows,StoreCard_ID"]
        ]
    );
    var_dump($response);
    //die;
    var_dump("Select * with expand, String filter with limit");
    $response = $moje->get(
        'storeprices',
        "PriceList_ID eq '2100000101' and PriceListValidity_ID eq null",
        [
            'limit' => $limit,
            'start' => $start,
            'detail' => ["*&expand=PriceRows,StoreCard_ID"]
        ]
    );
    var_dump($response);
    //die;
    
    $detail=['storecard_id.name', 'storecard_id', 'store_id.name', 'store_id', 'quantity'];
    var_dump("String filter with limit, expand zvlášť");
    $response = $moje->get(
        'storesubcards',
        //"StoreCard_ID.name like 'Panasonic 65*'",
        "StoreCard_ID.name like 'TV Panasonic TX-14B4TP*'",
        [
            'limit' => $limit,
            'start' => $start,
            'detail' => ['*'],
            //'expand' => ["StoreCard_ID"]
        ]
    );
    foreach ($response as $res) {
        var_dump($res);
    }
    die;
    $detail=['storecard_id.name', 'storecard_id.note', 'storecard_id.ean', 'storecard_id.code', 'pricerows.amount', 'storecard_id.vatrate', 'pricerows.qunit'];
    var_dump("String filter with limit, expand zvlášť");
    $response = $moje->get(
        'storeprices',
        "StoreCard_ID.name like 'Panasonic 65*' and PriceList_ID eq '2100000101' and PriceListValidity_ID eq null",
        [
            'limit' => $limit,
            'start' => $start,
            'detail' => ['*'],
            'expand' => ["PriceRows","StoreCard_ID"]
        ]
    );
    foreach ($response as $res) {
        var_dump($res);
    }
    die;
    */

    /*
    json_encode(
        (object)["class" => "storesubcards",
        "select" => ["storecard_id.name", "storecard_id"]
    ]);
    

    $body= ["class" => "storesubcards",
        "select" => ["id",
        "storecard_id.name",
        "storecard_id",
        "store_id.name",
        "store_id",
        "quantity",
        [
            "name" => "orderQTY",
            "value" => [
                "class" => "05CPMINJW3DL342X01C0CX3FCC",
                "select" => [
                    [
                        "name" => "orderQTY",
                        "value" => "sum(quantity) - sum(deliveredQuantity)"
                    ]
                ],
                "where" => "storecard_id eq :storecard_id and store_id eq :store_id and parent_id.closed = false and parent_id.confirmed = true"
            ]
        ]],
        //"where" => "storecard_id.name like 'Case Mini 250W*'",
        "where" => "id eq 'MC10000101' ",
        //"skip" => 0,
        //"take" => 2
    ];
    //var_dump($body);
    var_dump("Metoda GET přes POST");
    $response = $moje->getPost(
        $body
    );
    foreach ($response as $res) {
        var_dump($res['storecard_id']);
        var_dump($res['storecard_id.name']);
        var_dump($res['quantity']);
        var_dump($res['orderQTY'][0]['orderQTY']);
        var_dump($res['id']);
    }
    die;

    $response = $this->flexibee->get(
        'firms',
        $this->filter['adresar'] ?? null,
        [
            'limit' => self::LIMIT,
            'start' => $start,
            'detail' => self::DETAIL
        ]
    );
    */

    /* OK
    $response = $moje->get(
        'firms',
        null,
        [
            'detail' => $detail
        ]
    );
    var_dump($response[0]['residenceaddress_id.email']);
    die;
    */

    /* OK fungovalo
    
    var_dump("Put new");
    $response = $moje->put(
        $evidence,
        null,
        [
            'detail' => ['id', 'name']
        ],
        ['name' => 'Jiří Černý']
    );
    var_dump($response);

    var_dump("Aktualizuj");
    $response = $moje->put(
        $evidence,
        2810000101,
        [
            'detail' => ['id', 'name']
        ],
        ['name' => 'Jiří Černý s.r.o.']
    );
    var_dump($response);
    

    var_dump("Načti");
    $response = $moje->get(
        $evidence,
        2810000101,
        [
            'detail' => ['id', 'name']
        ],
        ['name' => 'Jiří Černý s.r.o.']
    );
    var_dump($response);

    */

    /*
    var_dump("Nový");
    $response = $moje->put(
        $evidence,
        null,
        [
            'detail' => ['id', 'name']
        ],
        ['name' => 'Jiří Černý nový']
    );
    if (is_array(json_decode($response))) {
        $response=json_decode($response, true);
        foreach ($response as $res) {
            var_dump($res);
        }
    } else {
        $response=json_decode($response, true);
        var_dump($response);
    }

    var_dump("Get Stores");
    $response = $moje->get(
        'stores',
        2100000101,
        //2100000105,
        [
            'detail' => ['id', 'name'],
            'limit' => 5,
            'start' => 0
        ]
    );
    foreach ($response as $res) {
        var_dump($res);
    }
    die;

    //kdyz je numeric id, ak vraci jen json bez listu!!!
    var_dump("Aktualizuj");
    $response = $moje->put(
        $evidence,
        2810000101,
        [
            'detail' => ['id', 'name'],
            'limit' => 5,
            'start' => 0
        ],
        ['name' => 'Jiří Černý test']
    );
    foreach ($response as $res) {
        var_dump($res);
    }
    die;

    /*
    var_dump("Načti 1");
    $response = $moje->get(
        $evidence,
        2810000101,
        [
            'detail' => ['id', 'name']
        ]
    );
    if (is_array(json_decode($response))) {
        $response=json_decode($response, true);
        foreach ($response as $res) {
            var_dump($res);
        }
    } else {
        $response=json_decode($response, true);
        var_dump($response);
    }
    

    var_dump("Načti all");
    $response = $moje->get(
        $evidence,
        //"id in ('2810000101', '3810000101')",
        "name like '*černý*'",
        [
            'detail' => ['id', 'name']
        ]
    );
    foreach ($response as $res) {
        var_dump($res);
    }

    */

    /*
    var_dump("OBRAZEK NA CENIKU");
    $pictureId = "X000000101";
    $response = $moje->get(
        'storeprices',
        //"PriceList_ID eq '2100000101' and PriceListValidity_ID eq null and storecard_id.name like 'Case Mini 250W*'",
        "PriceList_ID eq '2100000101' and PriceListValidity_ID eq null and storecard_id.picture_id eq '$pictureId'",
        [
            'limit' => $limit,
            'start' => $start,
            'expand' => ["storecard_id"],
			'detail' => ['*']
        ]
    );

    foreach ($response as $res) {
        var_dump($res);
    }
    die;
    

    var_dump("PICTURE");
    $pictureId = "X000000101";
    $response = $moje->get(
        'pictures',
        //"PriceList_ID eq '2100000101' and PriceListValidity_ID eq null and storecard_id.name like 'Case Mini 250W*'",
        "id eq '$pictureId'",
        [
			'detail' => ['id','picturetitle','picturedata','picturetype']
        ]
    );
    foreach ($response as $res) {
        var_dump($res);
    }
    die;

    //musim najit dokladovou radu pro FV (faktury vydané) a pro DL (dodací listy)
    $response = $moje->get('docqueues', "code eq 'fv'", ['detail' => ['id']]);
    var_dump($response[0]['id']);
    $response = $moje->get('docqueues', "code eq 'dl'", ['detail' => ['id']]);
    var_dump($response[0]['id']);
    */

    /*
    //musim najit dokladovou radu pro FV (faktury vydané) a pro DL (dodací listy)
    //chybi ceny, zatim to jen neco napocita podle toho zbozi
    $id_rady_fv = $moje->get('docqueues', "code eq 'fv'", ['detail' => ['id']])[0]['id'];
    $id_rady_dl = $moje->get('docqueues', "code eq 'dl'", ['detail' => ['id']])[0]['id'];
    $id_period = $moje->get('periods', "code eq '2023'", ['detail' => ['id']])[0]['id'];
    $id_currency = $moje->get('currencies', "code eq 'czk'", ['detail' => ['id']])[0]['id'];
    $id_vatrate = $moje->get('vatrates', "tariff eq '21'", ['detail' => ['id']])[0]['id'];
    $id_storecard = $moje->get('storecards', "name like 'Panasonic 65*'", ['detail' => ['id']])[0]['id'];
    $id_firm = $moje->get('firms', "name eq 'Jiří Černý nový'", ['detail' => ['id']])[0]['id'];
    $id_division = $moje->get('divisions', "name eq 'Centrála'", ['detail' => ['id']])[0]['id'];
    $quantity = 1;
    var_dump($id_rady_fv);
    var_dump($id_rady_dl);
    var_dump($id_period);
    var_dump($id_currency);
    var_dump($id_vatrate);
    var_dump($id_storecard);
    var_dump($id_firm);
    var_dump($id_division);

    $body = ["firm_id" => $id_firm,
    "docqueue_id" => $id_rady_fv, //dokladova rada pro faktury
    "storedocqueue_id" => $id_rady_dl, //dokladova rada pro dodaci listy
    "period_id" => $id_period, //obdobi
    "currency_id" => $id_currency,  //mena
    //"dirty" => true,  //nevim
    "rows" => [[
        "rowtype" => 3,
        "division_id" => $id_division,
        "storecard_id" => $id_storecard, //zbozi
        "store_id" => "2100000101", //hlavni sklad asi
        "vatrate_id" => $id_vatrate,
        "quantity" => $quantity]]];

    $response = $moje->put(
        'issuedinvoices', null, ['detail' => ['id']], $body);
    var_dump($response);
    
    die;
    */

    /*
    //musim najit dokladovou radu pro OP (objednávku přijatou)
    //chybi ceny, zatim to jen neco napocita podle toho zbozi
    $id_rady_op = $moje->get('docqueues', "code eq 'op'", ['detail' => ['id']])[0]['id'];
    //$id_rady_dl = $moje->get('docqueues', "code eq 'dl'", ['detail' => ['id']])[0]['id'];
    $id_period = $moje->get('periods', "code eq '2023'", ['detail' => ['id']])[0]['id'];
    $id_currency = $moje->get('currencies', "code eq 'czk'", ['detail' => ['id']])[0]['id'];
    $id_vatrate = $moje->get('vatrates', "tariff eq '21'", ['detail' => ['id']])[0]['id'];
    $id_storecard = $moje->get('storecards', "name like 'Panasonic 65*'", ['detail' => ['id']])[0]['id'];
    $id_firm = $moje->get('firms', "name eq 'Jiří Černý nový'", ['detail' => ['id']])[0]['id'];
    $id_division = $moje->get('divisions', "name eq 'Centrála'", ['detail' => ['id']])[0]['id'];
    $quantity = 1;
    var_dump($id_rady_op);
    //var_dump($id_rady_dl);
    var_dump($id_period);
    var_dump($id_currency);
    var_dump($id_vatrate);
    var_dump($id_storecard);
    var_dump($id_firm);
    var_dump($id_division);

    $body = ["firm_id" => $id_firm,
    "docqueue_id" => $id_rady_op, //dokladova rada pro faktury
    //"storedocqueue_id" => $id_rady_dl, //dokladova rada pro dodaci listy
    "period_id" => $id_period, //obdobi
    "currency_id" => $id_currency,  //mena
    //"dirty" => true,  //nevim
    "rows" => [[
        "rowtype" => 3,
        "division_id" => $id_division,
        "storecard_id" => $id_storecard, //zbozi
        "store_id" => "2100000101", //hlavni sklad asi
        "vatrate_id" => $id_vatrate,
        "quantity" => $quantity]]];

    $response = $moje->put(
        'receivedorders', null, ['detail' => ['id']], $body);
    var_dump($response);

    */


    /*
    //musim najit dokladovou radu pro PP (pokladní příjem), DL (dodací list) a PR (příjemky)
    //chybi ceny, zatim to jen neco napocita podle toho zbozi
    $id_rady_pp = $moje->get('docqueues', "code eq 'pp'", ['detail' => ['id']])[0]['id'];
    $id_rady_dl = $moje->get('docqueues', "code eq 'dl'", ['detail' => ['id']])[0]['id'];
    $id_rady_pr = $moje->get('docqueues', "code eq 'pr'", ['detail' => ['id']])[0]['id'];
    $id_period = $moje->get('periods', "code eq '2023'", ['detail' => ['id']])[0]['id'];
    $id_cashdesk = $moje->get('cashdesks', "name like 'CZK - hlavní pokladna*'", ['detail' => ['id']])[0]['id'];
    $id_vatrate = $moje->get('vatrates', "tariff eq '21'", ['detail' => ['id']])[0]['id'];
    $id_storecard = $moje->get('storecards', "name like 'Panasonic 65*'", ['detail' => ['id']])[0]['id'];
    $id_firm = $moje->get('firms', "name eq 'Jiří Černý nový'", ['detail' => ['id']])[0]['id'];
    $id_division = $moje->get('divisions', "name eq 'Centrála'", ['detail' => ['id']])[0]['id'];
    $quantity = 1;
    var_dump($id_rady_pp);
    var_dump($id_rady_dl);
    var_dump($id_rady_pr);
    var_dump($id_period);
    var_dump($id_cashdesk);
    var_dump($id_vatrate);
    var_dump($id_storecard);
    var_dump($id_firm);
    var_dump($id_division);

    $body = ["firm_id" => $id_firm,
    "docqueue_id" => $id_rady_pp, //dokladova rada pro pokladní příjem
    "storedocqueue_id" => $id_rady_dl, //dokladova rada pro dodaci listy
    "receiptcarddocqueue_id" => $id_rady_pr, //dokladova rada pro příjemky
    "period_id" => $id_period, //obdobi
    "cashdesk_id" => $id_cashdesk,
    //"dirty" => true,  //nevim
    "rows" => [[
        "rowtype" => 3,
        "division_id" => $id_division,
        "storecard_id" => $id_storecard, //zbozi
        "store_id" => "2100000101", //hlavni sklad asi
        "vatrate_id" => $id_vatrate,
        "quantity" => $quantity]]];

    $response = $moje->put(
        'cashreceiveds', null, ['detail' => ['id']], $body);
    //var_dump($response[0]['id']);
    var_dump($response);

    var_dump(is_numeric($null));
    die;
    */

    //musim najit dokladovou radu pro PV (pokladní výdej)
    //cena se zadava na radek do pole tamountwithoutvat
    $id_rady_pv = $moje->get('docqueues', "code eq 'pv'", ['detail' => ['id']])[0]['id'];
    //$id_rady_dl = $moje->get('docqueues', "code eq 'dl'", ['detail' => ['id']])[0]['id'];
    //$id_rady_pr = $moje->get('docqueues', "code eq 'pr'", ['detail' => ['id']])[0]['id'];
    $id_period = $moje->get('periods', "code eq '2023'", ['detail' => ['id']])[0]['id'];
    $id_cashdesk = $moje->get('cashdesks', "name like 'CZK - hlavní pokladna*'", ['detail' => ['id']])[0]['id'];
    $id_vatrate = $moje->get('vatrates', "tariff eq '21'", ['detail' => ['id']])[0]['id'];
    //$id_storecard = $moje->get('storecards', "name like 'Panasonic 65*'", ['detail' => ['id']])[0]['id'];
    $id_firm = $moje->get('firms', "name eq 'Jiří Černý nový'", ['detail' => ['id']])[0]['id'];
    $id_division = $moje->get('divisions', "name eq 'Centrála'", ['detail' => ['id']])[0]['id'];
    //$dataentrykind = 0;   //způsob zadání číslo (bez dane + DPH -> s daní) //nemusi byt
    $quantity = 1;
    var_dump($id_rady_pv);
    //var_dump($id_rady_dl);
    //var_dump($id_rady_pr);
    var_dump($id_period);
    var_dump($id_cashdesk);
    var_dump($id_vatrate);
    //var_dump($id_storecard);
    var_dump($id_firm);
    var_dump($id_division);

    $body = ["firm_id" => $id_firm,
    "docqueue_id" => $id_rady_pv, //dokladova rada pro faktury
    //"storedocqueue_id" => $id_rady_dl, //dokladova rada pro dodaci listy
    //"receiptcarddocqueue_id" => $id_rady_pr, //dokladova rada pro dodaci listy
    "period_id" => $id_period, //obdobi
    "cashdesk_id" => $id_cashdesk,
    //"dataentrykind" => $dataentrykind,  //způsob zadání číslo
    //"dirty" => true,  //nevim
    "rows" => [[
        //"rowtype" => 3,
        "division_id" => $id_division,
        //"storecard_id" => $id_storecard, //zbozi
        //"store_id" => "2100000101", //hlavni sklad asi
        "vatrate_id" => $id_vatrate,
        //"quantity" => $quantity,
        "tamountwithoutvat" => 1000
        ]]];

    $response = $moje->put(
        'cashpaids', null, ['detail' => ['id']], $body);
    //var_dump($response[0]['id']);
    var_dump($response);


    die;

    $response = $moje->get(
        'storecards',
        "name like 'V-C*'",
        [
			'detail' => ['id','name','picture_id']
        ]
    );

    
    var_dump($response);
    $extId = $response[0]['picture_id'];
    
    //$extId = "X000000101";
    //$extId = "1C30000101";
    $priloha = $moje->get('pictures', "id eq '$extId'", [
					'detail' => ['id','picturetitle','picturedata','picturetype']])[0] ?? null;
    var_dump($priloha);

    //$priloha['picturetype'] = "Tiff";

    switch(strtolower($priloha['picturetype'])) {
        case "gif": $contentType="image/gif"; $nazSoub=$priloha['picturetitle'].".gif"; break;
        case "png": $contentType="image/png"; $nazSoub=$priloha['picturetitle'].".png"; break;
        case "jpeg":
        case "jpg": $contentType="image/jpeg"; $nazSoub=$priloha['picturetitle'].".jpg"; break;
        case "bmp": $contentType="image/bmp"; $nazSoub=$priloha['picturetitle'].".bmp"; break;
        case "ico": $contentType="image/x-icon"; $nazSoub=$priloha['picturetitle'].".ico"; break;
        case "tiff":
        case "tif": $contentType="image/tiff"; $nazSoub=$priloha['picturetitle'].".tif"; break;
        //case "Svg": $contentType="image/svg+xml"; $nazSoub=$priloha['picturetitle'].".svg"; break;
        default:
        $contentType="image"; $nazSoub=$priloha['picturetitle'];
    }

    var_dump($contentType);
    var_dump($nazSoub);

    die;

    $extId = "X000000101";
    $response = $moje->get('pictures', "id eq '$extId'", [
					'detail' => ['id','picturetitle','picturedata','picturetype']])[0] ?? null;
    var_dump($response);

    die;

    var_dump("CENIK PODLE FOTO SOUBOR");
    $extId = "X000000101a";
    $response = $moje->get(
        'storeprices',
        "PriceList_ID eq '2100000101' and PriceListValidity_ID eq null and storecard_id.picture_id eq '$extId'",
        [
            //'expand' => ["pricerows","storecard_id","storecard_id.vatrates"],
			'detail' => ['*']
        ]
    );

    var_dump($response[0]['id'] ?? null);

    die;

    foreach ($response as $res) {
        var_dump($res);
    }

    die;

    var_dump("FOTO SOUBOR");
    $response = $moje->get(
        'storecards',
        "name like 'V-C*'",
        [
			'detail' => ['id','name','picture_id']
        ]
    );

    foreach ($response as $res) {
        var_dump($res);
    }

    var_dump("PICTURE");
    $pictureId = "1C30000101";
    $response = $moje->get(
        'pictures',
        //"PriceList_ID eq '2100000101' and PriceListValidity_ID eq null and storecard_id.name like 'Case Mini 250W*'",
        "id eq '$pictureId'",
        [
			'detail' => ['id','picturetitle','picturedata','picturetype']
        ]
    );
    foreach ($response as $res) {
        var_dump($res);
    }

    die;

    var_dump("CENIK");
    $response = $moje->get(
        'storeprices',
        //"PriceList_ID eq '2100000101' and PriceListValidity_ID eq null and storecard_id.name like 'Case Mini 250W*'",
        "PriceList_ID eq '2100000101' and PriceListValidity_ID eq null and storecard_id.name like 'Cd palety*'",
        [
            'limit' => $limit,
            'start' => $start,
            'expand' => ["pricerows","storecard_id","storecard_id.vatrates"],
			'detail' => ['*']
        ]
    );

    foreach ($response as $res) {
        //var_dump($res['storecard_id']['name']);
        var_dump((int)substr($res['storecard_id']['vatrates'][0]['vatrate_id'],0,3));
        var_dump($res['storecard_id']['picture_id']);
        var_dump(isset($res['storecard_id']['picture_id']));
        //var_dump($res['pricerows'][0]['amount']);
        //var_dump($res['pricerows'][0]['qunit']);
        //var_dump($res['id']);
        //var_dump($res);
        //var_dump($res['storecard_id.note']);
        //var_dump($res['storecard_id.ean']);
        //var_dump($res['storecard_id.code']);
        //var_dump($res['storecard_id.vatrate']);
    }

    die;

    return $this->abraGen->put('faktura-vydana', [
        'winstrom' => [
            'faktura-vydana' => [
                'id' => $inventuraId,
                'uzivatelske-vazby' => [
                    [
                        'evidenceType' => $dokladEvidence,
                        'object' => $dokladId,
                        'vazbaTyp' => $extId
                    ]
                ]

            ]
        ]
    ]);
 
    class ObjAbraGenImpl {

        private $url;
        private $userData;

        public function __construct($url) {
        $this->url_config = $url;
        $this->userData = null;
        }

        public static function camelCase($str, array $noStrip = [])
        {
            // non-alpha and non-numeric characters become spaces
            $str = preg_replace('/[^a-z0-9' . implode('', $noStrip) . ']+/i', ' ', $str);
            $str = trim($str);
            // uppercase the first character of each word
            $str = ucwords($str);
            $str = str_replace(' ', '', $str);

            return $str;
        }

        //public function authenticate(array $credentials): \Nette\Security\IIdentity {                                        
        //public function authenticate(array $credentials) {                                        
        public function auth(string $username, string $password) {          
            /*                              
            $userData = [
                'username' => $credentials[0],
                'password' => $credentials[1]
            ];
            */

            $userData = [
                'username' => $username,
                'password' => $password
            ];
            
            //$authUrl = explode('/c/', $this->url_config)[0] . '/login-logout/login.json';
            //$authUrl = $this->url_config;
            //bdump($authUrl);
            
            //$postFields = http_build_query($userData);
            //bdump($postFields);
            
            /*
            $ch = curl_init();           
            curl_setopt($ch, CURLOPT_URL, $authUrl);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $response = curl_exec($ch);
            curl_close($ch);
            */

            //$companyUrl = explode('/c/', $this->url_config)[0] . '/c.json';

            $companyUrl = $this->url_config;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_HTTPAUTH, TRUE);
            curl_setopt($ch, CURLOPT_USERPWD, $userData['username'] . ':' . $userData['password']);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_URL, $companyUrl);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            $response = curl_exec($ch);
            curl_close($ch);
            
            $results = json_decode($response, true);
            //var_dump($results);
            //die;

            $unauthorized = false;
            if (is_array($results)) {
                foreach($results as $key => $result) {
                    if ($key == 'error' && $result == 'Unauthorized')  {
                        $unauthorized = true;
                    }
                }
            } else {
                $unauthorized = true;
            }
            //var_dump($unauthorized);
            if ($unauthorized == true){
                throw new \Nette\Security\AuthenticationException($result['error']);            
            } else {
                $this->userData = $userData;
            }
            
            // id je vždycky 1...
            //return new \Nette\Security\Identity(1, null, $userData);
            
        }        

        public function getPost(array $data) {
            $wsurl = "query";
            //var_dump(json_encode($data));
            $response = $this->request($wsurl, 'POST', json_encode($data));
            //var_dump($response);
            return $response;

        }
        public function get(string $evidence, $filter = null, $params = null) {
            $wsurl = $this->buildWsurl($evidence, $filter, $params['detail'] ?? null, $params['expand'] ?? null);
            if (isset($params['start'])) {
                $wsurl .= "&skip={$params['start']}";
            }
            if (isset($params['limit'])) {
                $wsurl .= "&take={$params['limit']}";
            }
            $response = $this->request($wsurl, 'GET');
            //var_dump($response);
            return $response;
        }

        public function put(string $evidence, $filter = null, $params = null, $data = null) {
            $wsurl = $this->buildWsurl($evidence, $filter, $params['detail'] ?? null, $params['expand'] ?? null);
            if (isset($params['start'])) {
                $wsurl .= "&skip={$params['start']}";
            }
            if (isset($params['limit'])) {
                $wsurl .= "&take={$params['limit']}";
            }
            if (!isset($filter)) {
                $response = $this->request($wsurl, 'POST', json_encode($data));
            } else {
                $response = $this->request($wsurl, 'PUT', json_encode($data));
            }
            
            //var_dump($response);
            return $response;
        }

        /*
        public function post(string $evidence, $filter = null, $params = null, $data = null) {
            $wsurl = $this->buildWsurl($evidence, $filter, $params['detail'] ?? null, $params['expand'] ?? null);
            if (isset($params['start'])) {
                $wsurl .= "&skip={$params['start']}";
            }
            if (isset($params['limit'])) {
                $wsurl .= "&take={$params['limit']}";
            }
            $response = $this->request($wsurl, 'POST', json_encode($data));
            //var_dump($response);
            return $response;
        }
        */

        private function buildWsurl(string $evidence, $filter = null, $detail = null, $expand = null): string {
            //if ($evidence == 'uzivatelsky-dotaz') {
                //return $evidence . '/' . rawurlencode($filter) . '/call.json' . $this->buildParams($params);
            //} else if (is_numeric($filter)) {
            if (is_numeric($filter) || is_string($filter) && !str_contains(trim($filter), " ")) {
                return $evidence . '/' . $filter . $this->buildDetail($detail) . $this->buildExpand($expand);
            } else if (is_string($filter)) {
                return $evidence . $this->buildDetail($detail) . $this->buildExpand($expand) . '&where=' . rawurlencode($filter);
            } else {
                return $evidence . $this->buildDetail($detail) . $this->buildExpand($expand);
            }
        }

        private function buildDetail($detail = null): string {
            //return ($params != null ? '?' . $this->buildQuery($params) : '');
            return ($detail != null ? '?select=' . implode(",", $detail) : '?select=*');
        }

        private function buildExpand($expand = null): string {
            //return ($params != null ? '?' . $this->buildQuery($params) : '');
            return ($expand != null ? '&expand=' . implode(",", $expand) : '');
        }

        private function request($url, $type, $body = null) {
            //curl

            $address = $this->url_config . "/" . $url;

            var_dump($address);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_HTTPAUTH, TRUE);

            //if ($this->user->loggedIn) {
            if (isset($this->userData)) {
                //bdump($this->user->getIdentity()->data["username"] . ':' .  $this->user->getIdentity()->data["password"]);
                //curl_setopt($ch, CURLOPT_USERPWD, $this->user->getIdentity()->data["username"] . ':' . $this->user->getIdentity()->data["password"]);
                curl_setopt($ch, CURLOPT_USERPWD, $this->userData["username"] . ':' . $this->userData["password"]);
            }
 
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_URL, $address);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);

            /*
            if ($type == 'POST') { //this is wrong
                curl_setopt($ch, CURLOPT_POST, count($post));
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
            }
            */

            if ($type == 'PUT' || $type == 'POST') {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
            }

            $output = curl_exec($ch);
            if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200 && curl_getinfo($ch, CURLINFO_HTTP_CODE) != 201) {
                $error = curl_error($ch);
                $address = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
                error_log(rawurldecode($address) . " nastala chyba (HTTP " . curl_getinfo($ch, CURLINFO_HTTP_CODE) . "): " . $error . "\n" . $output);
            }
            curl_close($ch);

            $response = null;
            //kdyz je jen jeden zaznam pres evidence/id, tak nevraci pole, ale stdClass
            if (is_array(json_decode($output))) {
                $response=json_decode($output, true);
            } else {
                $response[]=json_decode($output, true);
                //kdyz 'title' je "Žádné záznamy", tak vrat prazdne
                if (isset($response[0]['title']) && $response[0]['title'] == "Žádné záznamy") {
                    $response = [];
                }
            }

            return $response;

        }

    }

    
?>