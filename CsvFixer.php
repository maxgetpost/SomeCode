<?php
/**
 * * * * * * * * * * * * * * * * * * *
 * @see http://github.com/maxgetpost
 * * * * * * * * * * * * * * * * * * *
 * @link http://localhost/CsvFixer.php
 * @example databaseFilePath:
 * @link C:\b\wc-product-export-6-9-2021-1630915181803.csv
 * @link https://www.convertcsv.com/csv-viewer-editor.htm
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
     * 
     */
    function fixCell(string $cell):string
    {
        return $cell === '' ? '' : 1;
    }


    /**
     * Глобальный атрибут 4: 54
     * Глобальный атрибут 5: 58 
     */
    function fixRow(array $row):array
    {
        $columnsNubmersToFix = [54, 58];

        foreach ($columnsNubmersToFix as $number) {

            if (!isset($row[$number])) {
                return $row;
            }

            $row[$number] = $this->fixCell($row[$number]);
        }

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

            $fileContent    = file_get_contents($file);


            $clearedContent = nl2br($fileContent);


            $originalCsv    = array_map(
                'str_getcsv', 
                explode("\n", $clearedContent)
            );


            $fixedCsv       = $this->fixCsv($originalCsv);


            $fp             = fopen($file, 'w');
  

            foreach ($fixedCsv as $fields) {
                
                fputcsv($fp, $fields);
            }
  
            fclose($fp);
        }
    }
}

new CsvFixer();
