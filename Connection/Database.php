<?php
    class DatabaseHandler
    {
        private $Handler;

        public function __construct()
        {
            $dsn = "mysql:dbname=gonano;host=" . $_ENV["DATA_DB_HOST"] . ";port=3306";
            $user = $_ENV["DATA_DB_USER"];
            $password = $_ENV["DATA_DB_PASS"];

            $this->Handler = new PDO($dsn, $user, $password);
            $this->Handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        public function __destruct()
        {
            $this->Handler = null;
        }
        
        public function Query(string $Sql)
        {
            $Statement = $this->Handler->prepare($Sql);
            $Statement->execute();
            return $Statement->fetchAll();
        }
        
        public function Insert(string $TableName, string $Fields, string $Values)
        {
            $Statement = $this->Handler->prepare("INSERT INTO `$TableName` ($Fields) VALUES ($Values);");
            if (!$Statement->execute())
            {
                print_r($Statement->errorInfo());
            }
        }
        
        public function Delete(string $TableName, string $Condition) : bool
        {
            $Statement = $this->Handler->prepare("DELETE FROM `$TableName` $Condition;");
            if (!$Statement->execute())
            {
                print_r($Statement->errorInfo());
            }
        }
                
        public function Prepare(string $Sql) : PDOStatement
        {
            return $this->Handler->prepare($Sql);
        }
        
        public function LastInsertId(string $Name = null) : string
        {
            return $this->Handler->lastInsertId($Name);
        }
        
        public function CreateTable(string $TableName, string $Fields, string $Engine) : int
        {
            return $this->Handler->exec("CREATE TABLE `$TableName` ($Fields) $Engine");
        }
        
        public function TableExists(string $TableName) : bool
        {
            try
            {
                $result = $this->Query("SELECT 1 FROM `$TableName` LIMIT 1");
            }
            catch (Exception $e)
            {
                return FALSE;
            }

            return $result !== FALSE;
        }
    }	
?>
