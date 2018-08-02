<?php
    class job_with_database {
        private $host_bd = '';
        private $login_bd = '';
        private $password_bd = '';
        private $name_bd = '';

        public function __construct($name_bd, $host_bd, $login_bd, $password_bd)
        {
            $this->name_bd = $name_bd;
            $this->host_bd= $host_bd;
            $this->login_bd = $login_bd;
            $this->password_bd = $password_bd;
        }

        public function create_token_bd() {
            $token = mysqli_connect($this->host_bd, $this->login_bd, $this->password_bd);
            return $token;
        }
        public function close_token_bd($token) {
            mysqli_close($token);
        }
        public function get_last_update_id($token) {
            mysqli_select_db($token, $this->name_bd);
            $query = mysqli_query($token, "SELECT * FROM `messages_from_users`");
            $update_id = 0;
            while ($row = mysqli_fetch_array($query)) {
                $update_id = $row['update_id'];
            }
            return $update_id;
        }
        public function write_message_to_bd($token, $params = []) {
            mysqli_select_db($token, $this->name_bd);
            $query = mysqli_query($token, "INSERT INTO `messages_from_users` (`chat_id`, `username`, `first_name`, `last_name`, `update_id`, `date`) 
            VALUES ({$params['chat_id']}, {$params['username']}, {$params['first_name']}, {$params['last_name']}, {$params['update_id']}, {$params['date']})");
        }
        public function sendAccount($token, $params = []) {
            mysqli_select_db($token, $this->name_bd);
            mysqli_query($token, "INSERT INTO `account_table` (`login`, `email`, `first_name`, `last_name`, `password`) VALUE ({$params['login']}, {$params['email']}, 
            {$params['first_name']}, {$params['last_name']}, {$params['password']})");
        }
        public function getAccountTable($token) {
            $arr = [];
            $i = 0;
            mysqli_select_db($token, $this->name_bd);
            $data = mysqli_query($token, "SELECT * FROM `account_table`");
            while ($row = mysqli_fetch_array($data)) {
                $arr[$i]['login'] = $row['login'];
                $i++;
            }
            return $arr;
        }
        public function getAccount($token, $login) {
            mysqli_select_db($token, $this->name_bd);
            $data = mysqli_query($token, "SELECT * FROM `account_table` WHERE `login` = '{$login}'");
            $arr = mysqli_fetch_array($data);
            return $arr;
        }

    }
?>