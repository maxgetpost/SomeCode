<?php
/**
 * * * * * * * * * * * * * * * * * * *
 * @see http://github.com/maxgetpost
 * * * * * * * * * * * * * * * * * * *
 * @link http://localhost/CsvFixer.php
 * @example databaseFilePath:
 * @link C:\b\wc-product-export-6-9-2021-1630915181803.csv
 */
class CsvFixer
{
    /**
     * @example C:\b\
     */
    public $dir = __DIR__ . '\\';

    /**
     * 
     */
    function __construct()
    {
        $this->findCsvFiles();
    }

    /**
     * Глобальный атрибут 4: 54
     * Глобальный атрибут 5: 58 
     */
    function fixRow(array $row):array
    {
        $row[54] = 1;
        $row[58] = 1;
        return $row;
    }


    /**
     * 
     */
    function fixCsv(array $csv)
    {
        $resultArray = [];

        foreach ($csv as $rowNumber => $row) {

            if ($rowNumber == 0) {
                $resultArray[] = $row;
                continue;
            }

            $resultArray[] = $this->fixRow($row);
        }

        return $resultArray;
    }

    /**
     * 
     */
    function findCsvFiles()
    {
        $files = glob($this->dir . '/*.csv');

        foreach ($files as $file) {

            $originalCsv    = array_map('str_getcsv', file($file));

            $fixedCsv       = $this->fixCsv($originalCsv);

            // Open a file in write mode ('w')
            $fp = fopen($file, 'w');
  
            // Loop through file pointer and a line
            foreach ($fixedCsv as $fields) {
                
                fputcsv($fp, $fields);
            }
  
            fclose($fp);

            
        }
    }
}

new CsvFixer();
