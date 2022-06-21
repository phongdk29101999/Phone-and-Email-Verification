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
            if ($sqlPrepare = $this->db->prepare($sql)) {
                foreach ($fields as $key => $value) {
                    // bind columns
                    $sqlPrepare->bindValue(":{$key}", $value);
                }
                // excute query
                $sqlPrepare->execute();
                return $sqlPrepare->fetch(PDO::FETCH_OBJ);
            }
        }

        public function update($table, $fields, $conditions)
        {
            $columns = "";
            $where = " WHERE ";
            $i = 1;
            // create columns 
            foreach($fields as $name => $value) {
                $columns .= "`{$name}` = :{$name}";
                if ($i < count($fields)) {
                    $columns .= ", ";
                }
                $i++;
            }
            // create sql query
            $sql = "UPDATE {$table} SET {$columns}";
            // adding where condition to sql query
            foreach ($conditions as $name => $value) {
                $sql .= "{$where} `{$name}` = :{$name}";
                $where = " AND ";
            }
            // check if sql query is prepared
            if ($sqlPrepare = $this->db->prepare($sql)) {
                foreach ($fields as $key => $value) {
                    // bind columns to sql query
                    $sqlPrepare->bindValue(":{$key}", $value);
                    foreach ($conditions as $key => $value) {
                        // bind where conditions to sql query
                        $sqlPrepare->bindValue(":{$key}", $value);
                    }
                }
                // excute the query
                $sqlPrepare->execute();
            }
        }

        public function emailExist($email) 
        {
            $email = $this->get("users", array("email" =>$email));
            return ((!empty($email))) ? $email : false;
        }

        public function usernameExist($username) 
        {
            $username = $this->get("users", array("username" =>$username));
            return ((!empty($username))) ? $username : false;
        }

        public function hash($password)
        {
            return password_hash($password, PASSWORD_BCRYPT);
        }

        public function redirect($location) {
            header("Location: " . BASE_URL . $location);
        }

        public function userData($id)
        {
            return $this->get("users", array("id" => $id));
        }

        public function logout()
        {
            $_SESSION = array();
            session_destroy();
            $this->redirect("index.php");
        }
        
        public function isLoggedIn()
        {
            return ((isset($_SESSION["user_id"]))) ? true : false;
        }
    }
?>
