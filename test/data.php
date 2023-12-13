<?php

    class CsvToAnything {

        //protected $arrayColumnNames;
        protected $arrayData;

        function __construct() {
            //$this->arrayColumnNames = [];
            $this->arrayData = [];
        }

        function readData($argInputFile) {

            //načti data
            if (file_exists($argInputFile)) {
                $fileContent = file_get_contents($argInputFile);
            } else {
                throw new Exception("Soubor neexistuje");
            }
            
        
            //vytvoř řádky
            $rows = explode("\n", $fileContent);
        
            //iteruj řádky
            $rowIndex = -1;
            foreach ($rows AS $row) {
                if ($rowIndex == -1) {
                    //první řádek obsahuje názvy polí
                    //$this->arrayColumnNames = explode(",", $row);
                    $columnNames = explode(",", $row);
                    //$columnCount = count($this->arrayColumnNames);
                    $columnCount = count($columnNames);
                    for ($i = 0; $i < $columnCount; $i++) {
                        //$this->arrayColumnNames[$i] = trim($this->arrayColumnNames[$i]);
                        $columnNames[$i] = trim($columnNames[$i]);
                    }
                
                } else {
                    //další řádky obsahují data
                    $columns = explode(",", $row);
                    if (count($columns) == $columnCount) {
                        //$this->arrayData[$rowIndex] = $columns;
                        $this->arrayData[$rowIndex] = [];
                        for ($i = 0; $i < $columnCount; $i++) {
                            $this->arrayData[$rowIndex][$columnNames[$i]] = $columns[$i];
                        }
                    } else {
                        $rowError = $rowIndex + 2;
                        throw new Exception("Tady na řádku $rowError něco nesedí");
                    }
                }
        
                $rowIndex++;
        
            }

            return "Read csv OK";

        }

        function exportXML ($argOutputFile) {

            $output = "<winstrom>";
            //$columnCount = count($this->arrayColumnNames);

            foreach ($this->arrayData AS $rowIndex => $rowData) {
                //$rowIndex jen kdyby bylo potřeba
                $output .= "<cenik>";
                foreach($rowData AS $tag => $value) {
                    $output .= "<$tag>";
                    $output .= "$value";
                    $output .= "</$tag>";
                }
                /*
                for ($i = 0, $i < $columnCount, $i++) {
                    $output .= "<$this->arrayColumnNames[i]>";
                    $output .= "$rowData[i]";
                    $output .= "</$this->arrayColumnNames[i]>";
                }
                */
                $output .= "</cenik>";
            }

            $output .= "</winstrom>";

            file_put_contents($argOutputFile, $output);

            return "Export xml OK";

        }

    }



$csvToAnything = new CsvToAnything();
//$csvToAnything->readData("data.csv");
//$csvToAnything->exportXML("export.xml");

//echo var_dump($argv);
//já bych to raději nechal zakomentované
echo var_dump($argv);
//toto jsem odkomentoval


$csvFile = "";
$xmlFile = "";

if (isset($argv[1])) {
    $csvFile = $argv[1];
}

if (isset($argv[2])) {
    $xmlFile = $argv[2];
}

if ($csvFile && $xmlFile) {
    echo $csvToAnything->readData($csvFile)."\n";
    echo $csvToAnything->exportXML($xmlFile)."\n";
} else {
    echo "Use data.php csvfile xmlfile";
}


?>
