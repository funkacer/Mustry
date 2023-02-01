<?php
    function getListOfColumns($od, $do) {
        $listOfColumns = [];
        $zapisuj = 0;
        for ($c = 'A'; $c <= 'ZZ'; $c++) {
            $c == $od ? $zapisuj = 1 : '';
            //nesmi se pouzivat <
            $zapisuj ? $listOfColumns[] = $c : '';
            if ($c == $do) {
                break;
            }
        }
        //bdump($listOfColumns);
        return $listOfColumns;
    }

    array_key_exists("submit", $_GET) ? $output = getListOfColumns($_GET['od'], $_GET['do']) : $output = [];

    /*
    $od = "B";
    $do = "AC";
    var_dump(getListOfColumns($od, $do));
    */
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

<form action="" method="get">
    <label for="od">Od: </label>
    <input type="text" name="od" id="od">
    <label for="do">Do: </label>
    <input type="text" name="do" id="do">
    <input type="submit" name="submit" value="Vypsat">
</form>

<?php var_dump($output); ?>
    
</body>
</html>