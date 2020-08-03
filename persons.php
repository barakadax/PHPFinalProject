<?php
    class persons {
        protected $Id;
        protected $firstName;
        protected $lastName;
        protected $cityCode;
        protected $username;
        protected $userPassword;

        public function getId() {
            return $this->Id;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function getFirstName() {
            return $this->firstName;
        }

        public function setFirstName($name) {
            $this->firstName = $name;
        }

        public function getLastName() {
            return $this->lastName;
        }

        public function setLastName($name) {
            $this->lastName = $name;
        }

        public function getCityCode() {
            return $this->cityCode;
        }

        public function setCityCode($number) {
            $this->cityCode = $number;
        }

        public function getUserName() {
            return $this->username;
        }

        public function setUserName($text) {
            $this->username = $text;
        }

        public function getUserPassword() {
            return $this->userPassword;
        }

        public function setUserPassword($secret) {
            $this->userPassword = $secret;
        }
    }
?>