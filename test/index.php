<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">  
    <script src="./js/jquery-3.3.1.js"></script>
    <script src="https://kit.fontawesome.com/85b5d6f521.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">  
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
</head>
<?php
    $polozka = ['kod' => 'A', 'nazev' => 'Ahoj', 'stitky' => 'B', 'objednatK' => 'C',
    'objednanoMj' => 10, 'mnozMj' => 50, 'cenaMj' => 1500, 'sumZklMen' => 1700];
    $dleVyrobcu = [];
    for ($i = 0; $i < 25; $i++) {
        $dleVyrobcu['OLFIN'][] = $polozka;
    }
?>
<body>
    <div class="container">
        <h2 style = "text-align: center; margin: 20px">Objednávky vydané dle výrobců</h2>
        <form method="POST" action="" style="margin-top:5rem;">
            <?php if (isset($dleVyrobcu['OLFIN']) && isset($dleVyrobcu['OLFIN'][0])) {?>
                <h4 style="text-align:center;">OLFIN Car s.r.o.</h4>
                <table id="doklady" class="table table-striped table-bordered" style="width:100%;margin-top:3rem;">
                    <thead>
                        <tr>
                            <th>Kod</th>
                            <th>Název</th>
                            <th>Štítky</th>
                            <th>Objednat</th>
                            <th>Objednáno</th>
                            <th>Množství</th>
                            <th>Cena/ks v Kč</th>
                            <th>Cena celkem v Kč</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php 
                            foreach ($dleVyrobcu['OLFIN'] as $polozky) {
                                echo "<tr>";               
                                echo "<td>".$polozky['kod']."</td>";
                                echo "<td>".$polozky['nazev']."</td>";
                                echo "<td>".$polozky['stitky']."</td>";
                                echo "<td>".substr($polozky['objednatK'], 9)."</td>";
                                echo "<td>".$polozky['objednanoMj']."</td>";
                                echo "<td>".$polozky['mnozMj']."</td>";
                                echo "<td>".$polozky['cenaMj']."</td>";
                                echo "<td>".$polozky['sumZklMen']."</td>";                    
                                echo "</tr>";
                            }
                        ?>
                        
                    </tbody>
                </table>
            <?php }?>
                        
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary" name="submit-potvrdit">Potvrdit</button>
            </div>
        </div>
    </form>
    
</body>
</html>

<script>
    $(document).ready( function () {
        $('#doklady').DataTable( {
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.1/i18n/cs.json'
        }});
    } );

</script>