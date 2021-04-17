<?php
 
    /**
     * Import
     */
    class Import
    {  
        private $bd;
        private $csv;
               
        
        /**
         * Method __construct
         *
         * @param instance $connection Database connection
         * @param string $csv CSV file
         *
         * @return void
         */
        public function __construct(Database $connection = null, CSV $csv = null)
        {
            $this->db  = $connection;
            $this->csv = $csv;
        }

        // public function validate()
        // {

        // }
        
        /**
         * Method insertFile
         *
         * @param string $name CSV file name
         *
         * @return void
         */
        public function insertFile($name = 'unknown')
        {

            $query  = "INSERT INTO csvdb_file (name) VALUES(?)"; 
            $result = $this->db->prepare($query);

            if ($result->execute([$name])) {

                $last_id = $this->db->lastInsertId();

                
               

                self::insertColumns($last_id);
           
                self::insertFields($last_id);


               echo 'Added record!';
           
            }
        
        }

        public function insertColumns($id)
        {

          //  $head = $csv->get()[0];
            $data;
            $cols;

            if($cols){
                $query  = "INSERT INTO csvdb_columns (id_file) VALUES(?, ?)"; 
                $result = $this->db->prepare($query);

                if ($result->execute([$id, $data])) {
                   
                }
            }
        }

        public function insertFields($id)
        {

        }
        
        public function insertAll()
        {

        }

    }