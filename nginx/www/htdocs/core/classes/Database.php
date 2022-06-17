<?php
    class Database
    {
        protected $pdo;
        protected static $instance;

        protected function __construct() 
        {
            try {
                $this->pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";", DB_USER, DB_PASSWORD);
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        public static function instance()
        {
            if (self::$instance === null) {
                self::$instance = new self;
            }
            return self::$instance;
        }

        public function __call($method, $arguments)
        {
            return call_user_func_array(array($this->pdo, $method), $arguments);
        }
    }
?>
