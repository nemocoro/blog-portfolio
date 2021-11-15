<?php
    session_start();
    class Database
    {
        private $servername = "localhost";
        private $username = "root";
        private $password = "";
        private $db = "blog";

        public function connect()
        {
            $conn = new mysqli($this->servername,$this->username,$this->password,$this->db);
            if( $conn->connect_error )
            {
                die("ERROR CONNECTING TO THE DATABASE: ".$conn->connect_error);
            }
            else
            {
                return $conn;
            }
        }
    }
?>