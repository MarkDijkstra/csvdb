<?php
 
/**
 * API
 */
class Api
{  
    private $bd;
    public const TABLEFILE    = 'csvdb_file';
    public const TABLECOLUMNS = 'csvdb_columns';
    public const TABLEFIELDS  = 'csvdb_fields';

    /**
     * Method __construct
     *
     * @param instance $connection Database connection
     * @return void
     */
    public function __construct(Database $connection = null)
    {
        $this->db = $connection;
    }

    // public function validate()
    // {
    //  TODO
    // }
    
    /**
     * Method insertFile
     *
     * @param string $name CSV file name
     * @param int $delmiter CSV delimiter
     * @return void
     */
    private function insertFileTable(string $name, int $delmiter)
    {
        $query  = "INSERT INTO ".self::TABLEFILE." (name, delimiter) VALUES(?,?)"; 
        $result = $this->db->prepare($query);

        if ($result->execute([$name, $delimiter])) {
            return $this->db->lastInsertId();           
        }  
        
        return false;
    }

    /**
     * Method insertTableColumns
     *
     * @param bool $id Last id of the file table insert
     * @param array $data CSV data
     * @return void
     */
    private function insertTableColumns(int $id, array $data)
    {
        $data   = serialize($data[0]);
        $query  = "INSERT INTO ".self::TABLECOLUMNS." (file_id, data) VALUES(?, ?)"; 
        $result = $this->db->prepare($query);

        if ($result->execute([$id, $data])) {
            return;
        }
    }

    /**
     * Method insertTableFields
     *
     * @param bool $id Last id of the file table insert
     * @param array $data CSV data
     * @return void
     */
    private function insertTableFields(int $id, array $data)
    {
        $shiftData[] = array_shift($data);
        $shiftData   = serialize($data);
        $query       = "INSERT INTO ".self::TABLEFIELDS." (file_id, data) VALUES(?, ?)"; 
        $result      = $this->db->prepare($query);

        if ($result->execute([$id, $shiftData])) {
            return;
        }
    }

    /**
     * Method insert
     *
     * @param string $name CSV file name
     * @param array $data CSV file data
     * @param int $delmiter CSV delimiter
     * @return void
     */
    public function insert(string $name, array $data, int $delimiter)
    {
        $last_id = self::insertFileTable($name, $delimiter);

        if ($data && $last_id) {
            $colunms = self::insertTableColumns($last_id, $data);  

            if (count($data) > 1) {          
                $fields = self::insertTableFields($last_id, $data);
            }

            return ['id' => $last_id];
        }
    }
    
    /**
     * Method find
     *
     * @param int $id The id of the file
     * @return void
     */
    public function find(int $id = null)
    {
        if ($id && is_int($id)) {         
            $query  = "SELECT fl.id, fl.name, cm.data as columns, fd.data as fields FROM 
            ".self::TABLEFILE." as fl, 
            ".self::TABLECOLUMNS." as cm,
            ".self::TABLEFIELDS." as fd
            WHERE fl.id = ?
            AND cm.file_id = fl.id
            AND fd.file_id = fl.id"; 

            $result = $this->db->prepare($query);
            if ($result->execute([$id])) {
                $data = $result->fetch(PDO::FETCH_ASSOC);
                return self::unserializeData($data);
            }            
        }
    }

    /**
     * Method findAll
     * 
     * @param string $table The selected table
     * @return void
     */
    public function findAll(string $table = null)
    {
        if ($table) {
            $query  = "SELECT * FROM ".$table." ORDER BY id DESC"; 
            $result = $this->db->prepare($query);
            if ($result->execute()) {
              return $result->fetchAll(PDO::FETCH_ASSOC);
            }
        }   
    }
    
    /**
     * Method unserializeData
     *
     * @param array $data Data to clean
     * @return void
     */
    private function unserializeData(array $data)
    {
        if (isset($data['columns'])) {
            $data['columns'] = unserialize($data['columns']);
        } else {
            $data['columns'] = [];
        }
        if (isset($data['fields'])) {
            $data['fields'] = unserialize($data['fields']);
        } else {
            $data['fields'] = [];
        }

        return $data;
    }
}