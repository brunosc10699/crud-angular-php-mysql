<?php

    class Connection {

        private $host;
        private $dbUserName;
        private $dbPassword;
        private $dbName;

        private $active_group;
        private $query_builder;
        
        public function __construct(){

            $this->url =  parse_url(getenv("CLEARDB_DATABASE_URL"));

            if ($this->url["host"]) {
                $this->host = $this->url["host"];
                $this->dbName = substr($this->url["path"], 1);
                $this->dbUserName = $this->url["user"];
                $this->dbPassword = $this->url["pass"];

                $this->active_group = 'default';
                $this->query_builder = TRUE;
            } else {
                $this->host = "localhost";
                $this->dbName = "course_db";
                $this->dbUserName = "root";
                $this->dbPassword = "";
            }
        }

        public function dbConnection() {
            try {
                $connection = new PDO(
                    'mysql:host=' . $this->host . ';dbname=' . $this->dbName , $this->dbUserName, $this->dbPassword
                );
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $connection;
            } catch (PDOException $e) {
                echo "Connection error: " . $e->getMessage();
                exit;
            }
        }
    }

?>
