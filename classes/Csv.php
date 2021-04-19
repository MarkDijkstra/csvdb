<?php

/**
 * Csv
 */
class Csv
{
    private $fp;
    private $parseheader;
    private $header;
    private $delimiter;
    private $length;
    
    /**
     * Method __construct
     *
     * @param string $file_name CSV file
     * @param bool $parse Iclude header in each row
     * @param int $delimiter Dilimiter CSV file
     * @param int $length Mar rows to show
     * @return void
     */
    function __construct(string $file_name, bool $parseheader = false, string $delimiter, int $length = 8000)
    {

        $this->fp          = fopen($file_name, "r");
        $this->parseHeader = $parseheader;
        $this->delimiter   = self::detectDelimiter($file_name, $delimiter);
        $this->length      = $length;
        //$this->lines        = $lines; 

        if ($this->parseHeader) {
           $this->header = fgetcsv($this->fp, $this->length, $this->delimiter);
        }
    }
    
    /**
     * Method __destruct
     *
     * @return void
     */
    function __destruct()
    {
        if ($this->fp) {
            fclose($this->fp);
        }
    }
    
    /**
     * Method get
     *
     * @param int $max_lines Max rows to show
     * @return void
     */
    function get(int $maxLines = 0)
    {
        $data = [];

        if ($maxLines > 0) {
            $lineCount = 0;
        } else {
            $lineCount = -1;
        }

        while ($lineCount < $maxLines && ($row = fgetcsv($this->fp, $this->length, $this->delimiter)) !== FALSE) {
            if ($this->parseHeader) {
                foreach ($this->header as $i => $hi) {
                    $rowNew[$hi] = trim($row[$i]);
                }
                $data[] = $rowNew;
            } else {
                $data[] = $row;
            }
            if ($maxLines > 0) {
                $lineCount++;
            }
        }
        return $data;
    }
    
    /**
     * Method detectDelimiter
     *
     * @param string $csvFile The CSV file
     * @param int $setDelimiter Set a delimiter
     * @return void
     */
    private function detectDelimiter(string $csvFile, int $setDelimiter) 
    { 
        if ($setDelimiter == 0) {
            $delimiters = array( ',' => 0, ';' => 0, "\t" => 0, '|' => 0, ); 
            $firstLine  = ''; 
            $handle     = fopen($csvFile, 'r'); 
            if ($handle) { 
                $firstLine = fgets($handle); 
                fclose($handle);
            } 
            if ($firstLine) { 
                foreach ($delimiters as $delimiter => &$count) { 
                    $count = count(str_getcsv($firstLine, $delimiter)); 
                } 
                return array_search(max($delimiters), $delimiters); 
            } else { 
                return key($delimiters); 
            } 
        } else {
            $list = array(1 => "\t", 2 => ";", 3 => "|", 4 => ",");
            return $list[$setDelimiter];
        }
    }
}