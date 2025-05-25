<?php

//Database configuration
class Database{
    private $host = 'localhost';
    private $db_name = 'furniscape'; //Database name
    private $username = 'root';  //Defualt XAMPP User
    private $password = ''; //Defualt XAMPP password
    public $conn;

    public function connect(){
        $this->conn = null;
        try{
            //Create a PDO Connection
            $this -> conn = new PDO( "mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            //Set the PDO error mode to exception
            $this -> conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e)
        {
            echo "Connection error: " . $e->getMessage();  //If a connection error occurs, shows this
        }
        return $this->conn;
    }

}