<?php

    /**
     * Import class
     */
    class Import
    {  
        private $bd;

        public function __construct(Database $connection = null)
        {
            $this->db = $connection;
        }

        public function validate()
        {

        }

        public function insertFile($name = 'unknown')
        {

            $query  = "INSERT INTO data_file (name) VALUES(?)"; 
            $result = $this->db->prepare($query);

            if ($result->execute([$name])) {
               echo 'Added record!';
            }
        
        }

        public function insertHead()
        {

        }

        public function insertContent()
        {

        }

        public function insertAll()
        {

        }
            
    }