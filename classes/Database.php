<?php

/**
 * Database class
 */
class Database extends PDO 
{

    public function __construct($host, $db_name = null, $username = null, $password = null, $options =[])
    {
        $options_default = array(PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                                PDO::ATTR_EMULATE_PREPARES   => false,
                                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);

        $options = array_replace($options_default, $options);

        parent::__construct("mysql:host=".$host.";dbname=".$db_name, $username, $password, $options);

        try {
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}