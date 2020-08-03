<?php
    class Gardes {
        protected $id;
        protected $linear_math;
        protected $boolean;
        protected $infinitesimal;

        public function setId($id) {
            $this->id = $id;
        }

        public function getId() {
            return $this->id;
        }

        public function setLinear($score) {
            $this->linear_math = $score;
        }

        public function getLinear() {
            return $this->linear_math;
        }

        public function setBoolean($score) {
            $this->boolean = $score;
        }

        public function getBoolean() {
            return $this->boolean;
        }

        public function setInfi($score) {
            $this->infinitesimal = $score;
        }

        public function getInfi() {
            return $this->infinitesimal;
        }
    }
?>