<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Start</h1>
    <?php
        $start_time = microtime(TRUE);

        $r = 1;
        for ($i = 1; $i < 4; $i++) {
            for ($polozka = 1; $polozka < 50000; $polozka++) {
                $polozky[$r] = "polozka: " . $polozka;
                $kody[$r] = "P" . $polozka;
                $r++;
            }
        }

        $duplicity = array_diff_assoc($kody, array_unique($kody));
        foreach($duplicity AS $r => $kod) {
            unset($polozky[$r]);
            $duplicity[$r] = "$r, $kod, duplicita se řádkem " . array_search($kod, $kody);
        }
        file_put_contents('duplicity.txt', implode("\n", $duplicity));
        file_put_contents('polozky.txt', implode("\n", $polozky));

        $this_work = microtime(true) - $start_time;

    ?>

    <h2>Hotovo za <?php echo round($this_work, 1)?>s!</h2>
    
</body>
</html>