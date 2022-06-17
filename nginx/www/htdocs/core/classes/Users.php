<?php
    class Users
    {
        protected $db;

        public function __construct()
        {
            $this->db = Database::instance();
        }

        public function get($table, $fields = array())
        {
            $columns = implode(", ", array_keys($fields));
            // sql query
            $sql = "SELECT * FROM `{$table}` WHERE `{$columns}` = :{$columns}";
            // check if sql query is set
            if ($stmt = $this->db->prepare($sql)) {
                foreach ($fields as $key => $value) {
                    // bind columns
                    $stmt->bindValue(":{$key}", $value);
                }
                // excute query
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_OBJ);
            }
        }

        public function emailExist($email) 
        {
            $email = $this->get("users", array("email" =>$email));
            return ((!empty($email))) ? $email : false;
        }

        public function hash($password)
        {
            return password_hash($password, PASSWORD_BCRYPT);
        }

        public function redirect($location) {
            header("Location: {$location}");
        }
    }
?>
