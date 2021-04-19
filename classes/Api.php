<?php
 
/**
 * API
 */
class Api
{  
    private $bd;            
    
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
     * @return void
     */
    private function insertFileTable($name)
    {
        $query  = "INSERT INTO csvdb_file (name) VALUES(?)"; 
        $result = $this->db->prepare($query);

        if ($result->execute([$name])) {
            return $this->db->lastInsertId();           
        }  
        
        return false;
    }

    /**
     * Method insertColumnsTable
     *
     * @param bool $id Last id of the file table insert
     * @param array $data CSV data
     * @return void
     */
    private function insertColumnsTable($id, $data)
    {
        $data   = serialize($data[0]);
        $query  = "INSERT INTO csvdb_columns (file_id, data) VALUES(?, ?)"; 
        $result = $this->db->prepare($query);

        if ($result->execute([$id, $data])) {
            return;
        }
    }

    /**
     * Method insertFieldsTable
     *
     * @param bool $id Last id of the file table insert
     * @param array $data CSV data
     * @return void
     */
    private function insertFieldsTable($id, $data)
    {
        $data   = array_shift($data);
        $data   = serialize($data);
        $query  = "INSERT INTO csvdb_fields (file_id, data) VALUES(?, ?)"; 
        $result = $this->db->prepare($query);

        if ($result->execute([$id, $data])) {
            return;
        }
    }

    /**
     * Method insert
     *
     * @param string $name CSV file name
     * @param string $data CSV file data
     *
     * @return void
     */
    public function insert($name, $data)
    {
        $last_id = self::insertFileTable($name);

        if ($data && $last_id) {
            $colunms = self::insertColumnsTable($last_id, $data);  

            if (count($data) > 1) {          
                $fields = self::insertFieldsTable($last_id, $data);
            }

            return ['id' => $last_id];
        }
    }
    
    /**
     * Method select
     *
     * @param bool $id The id of the file
     * @return void
     */
    public function select($id = false)
    {
        if ($id) {
           // TODO
        } else {
            $query  = "SELECT * FROM csvdb_file ORDER BY id DESC"; 
            $result = $this->db->prepare($query);
            if ($result->execute()) {
                return $result->fetchAll(\PDO::FETCH_ASSOC);
            }
        }
    }

}