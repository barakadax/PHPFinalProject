<?php
    class Login_class {
        protected $username;
        protected $password;

        public function getUsername() {
            return $this->username;
        }

        public function setUsername($name) {
            $this->username = $name;
        }

        public function getPassword() {
            return $this->password;
        }

        public function setPassword($pass) {
            $this->password = $pass;
        }
    }
?>