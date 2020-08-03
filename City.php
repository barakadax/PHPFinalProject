<?php
    class City {
        protected $cityCode;
        protected $cityName;

        public function getCityId() {
            return $this->cityCode;
        }

        public function setCityId($id) {
            $this->cityCode = $id;
        }

        public function getCityName() {
            return $this->cityName;
        }

        public function setCityName($name) {
            $this->cityName = $name;
        }
    }
?>