<?php
$evidence = "strom";
$poleUzlu = [];
$maxHladina = 0;
$hladinaMaxCount = [];

//$odpoved = $this->model->getAllData($evidence);
$odpovedJson = file_get_contents("StromJson.json");
$odpoved = json_decode($odpovedJson, $associative = true);
//dumpe($odpoved);
//bdump($odpoved);

foreach($odpoved as $odpUzel) {
    //$odpUzel = $this->model->getData($evidence, (int)$odp["id"])[0];
    //$poleUzlu[$odpUzel["cesta"]] =  $odpUzel; //pro zobrazeni stromu po sort, ale nefungovalo tak spravim nize
    $poleIds[(int)$odpUzel["id"]] =  $odpUzel; //pro nalezeni hodnot podle id
    if ($odpUzel["hladina"] > $maxHladina) {
        $maxHladina = $odpUzel["hladina"];
    }
    //new
    $levels = explode("/", rtrim($odpUzel["cesta"], "/"));
    $lev = 1;
    foreach ($levels as $level) {
        if (isset($hladinaMaxCount[$lev])) {
            if (strlen($level) > $hladinaMaxCount[$lev]) {
                $hladinaMaxCount[$lev] = strlen($level);
            }
        } else {
            $hladinaMaxCount[$lev] = strlen($level);
        }
        $lev++;
    }
    //bdump($odpUzel);
}

//pro zobrazeni stromu po sort, ale spravim zde
foreach($odpoved as $odpUzel) {
    $cesta = "";
    $levels = explode("/", rtrim($odpUzel["cesta"], "/"));
    $lev = 1;
    foreach ($levels as $level) {
        for ($i = 0; $i < $hladinaMaxCount[$lev] - strlen($level); $i++) {
            $cesta .= "0";
        }
        $cesta .= $level."/";
        $lev++;
    }
    $poleUzlu[$cesta] =  $odpUzel; //pro zobrazení stromu po sort
}

ksort($poleUzlu);

if(isset($_POST["strom-submit"])) {
    //bdump($_POST);

    //kontrola že vybráno
    if (isset($_POST["od"]) && isset($_POST["do"])) {

        $idOd = (int)$_POST["od"];
        $idDo = (int)$_POST["do"];

        $uzelOd = $poleIds[$idOd];
        $uzelDo = $poleIds[$idDo];

        //bdump($uzelOd);
        //bdump($uzelDo);

        //kontroly - do nesmí být v rámci vybrané a nižších položek
        $seznamPolozekPod = [];
        $seznamOtcuIds = [$poleIds[$idOd]["id"]];
        $seznamOtcuKody = [$poleIds[$idOd]["kod"]];
        for ($i = $uzelOd["hladina"]; $i <= $maxHladina; $i++) {
            foreach($poleIds AS $uzel) {
                if (substr($uzel["otec"], 0, 5)  == "code:") {
                    //bdump(substr($uzel["otec"], 5));
                    //bdump($seznamOtcuKody);
                    if (in_array(substr($uzel["otec"], 5), $seznamOtcuKody)) {
                        if (!in_array($uzel["id"],  $seznamPolozekPod)) {
                            $seznamPolozekPod[] = $uzel["id"];
                        }
                        if (!in_array($uzel["id"],  $seznamOtcuIds)) {
                            $seznamOtcuIds[] = $uzel["id"];
                        }
                        if (!in_array($uzel["kod"],  $seznamOtcuKody)) {
                            $seznamOtcuKody[] = $uzel["kod"];
                        }
                    }
                } else {
                    if (in_array($uzel["otec"], $seznamOtcuIds)) {
                        if (!in_array($uzel["id"],  $seznamPolozekPod)) {
                            $seznamPolozekPod[] = $uzel["id"];
                        }
                        if (!in_array($uzel["id"],  $seznamOtcuIds)) {
                            $seznamOtcuIds[] = $uzel["id"];
                        }
                        if (!in_array($uzel["kod"],  $seznamOtcuKody)) {
                            $seznamOtcuKody[] = $uzel["kod"];
                        }
                    }
                }
            } 
        }

        //bdump($seznamPolozekPod);

        if (in_array($idDo, $seznamPolozekPod) || $idDo == $idOd) {
            $this->flashMessage("Nelze přesunout položky pod sebe", "danger");
        } else {
            //$result = $this->model->putNovyOtec($idOd, $idDo, $evidence);
            //$this->flashMessage("Uzel stromu {$uzelOd["nazev"]} byl přesunut pod {$uzelDo["nazev"]}.", "success");
            //neudelam hned, ale pridam potvrzovaci tlacitko (potvrzeni.latte)
            $this->template->idOd = $idOd;
            $this->template->idDo = $idDo;
            $this->template->nazevOd = $uzelOd["nazev"];
            $this->template->nazevDo = $uzelDo["nazev"];
            $this->setView('potvrzeni');
            //bdump($result);
            
        }

    } else {
        $this->flashMessage("Musíte vybrat, co se má přesunout a kam", "danger");
    }
    
    //$this->redirect("this");

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

        <?php
            $textPoleUzlu = [];
            foreach ($poleUzlu as $cesta => $odpUzel) {
                $textUzlu = "id: ".$odpUzel["id"];
                $textUzlu .= ", kod: ".$odpUzel["kod"];
                $textUzlu .= ", nazev: ".$odpUzel["nazev"];
                $textUzlu .= ", hladina: ".$odpUzel["hladina"];
                $textUzlu .= ", poradi: ".$odpUzel["poradi"];
                $textUzlu .= ", cesta: ".$odpUzel["cesta"];
                $textUzlu .= ", mojecesta: ".$cesta;
                $textUzlu .= ", otec: ".$odpUzel["otec"];
                $textPoleUzlu[] = $textUzlu;
            }
            $text = implode("\n", $textPoleUzlu);
        ?>

    <textarea name="" id="" cols="100" rows="10">
        <?php echo $text;?>
    </textarea>
    
</body>
</html>