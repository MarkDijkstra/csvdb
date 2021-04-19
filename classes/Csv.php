<?php

/**
 * Csv
 */
class Csv
{
    private $fp;
    private $parse_header;
    private $header;
    private $delimiter;
    private $length;
    
    /**
     * Method __construct
     *
     * @param string $file_name CSV file
     * @param bool $parse Iclude header in each row
     * @param bool $delimiter Dilimiter CSV file
     * @param int $length Mar rows to show
     * @return void
     */
    function __construct(string $file_name, bool $parse_header = false, bool $delimiter, int $length = 8000)
    {

        $this->fp           = fopen($file_name, "r");
        $this->parse_header = $parse_header;
        $this->delimiter    = self::detectDelimiter($file_name, $delimiter);
        $this->length       = $length;
        //$this->lines        = $lines; 

        if ($this->parse_header) {
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
     * @param bool $max_lines Max rows to show
     * @return void
     */
    function get($max_lines = 0)
    {
        $data = [];

        if ($max_lines > 0) {
            $line_count = 0;
        } else {
            $line_count = -1;
        }

        while ($line_count < $max_lines && ($row = fgetcsv($this->fp, $this->length, $this->delimiter)) !== FALSE) {
            if ($this->parse_header) {
                foreach ($this->header as $i => $heading_i) {
                    $row_new[$heading_i] = trim($row[$i]);
                }
                $data[] = $row_new;
            } else {
                $data[] = $row;
            }
            if ($max_lines > 0) {
                $line_count++;
            }
        }
        return $data;
    }
    
    /**
     * Method detectDelimiter
     *
     * @param string $fh CSV file
     * @return void
     */
    private function detectDelimiter($csvFile, $set_delimiter) 
    { 
        if ($set_delimiter == 0) {
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
            $delim_list = array(1 => "\t", 2 => ";", 3 => "|", 4 => ",");
            return $delim_list[$set_delimiter];
        }
    }

}