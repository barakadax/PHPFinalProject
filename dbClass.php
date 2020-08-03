<?php
    require_once "City.php";
    require_once "persons.php";
    require_once "Grades.php";
    require_once "Login_class.php";

    class dbClass {
        private $host;
        private $db;
        private $charset;
        private $user;
        private $pass;
        private $opt = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
        private $connection;

        //connection & constructor:
        public function __construct(string $host = "localhost", string $db = "students", string $charset = "utf8", string $user = "root", string $pass = "") {
            $this->host = $host;
            $this->db = $db;
            $this->charset = $charset;
            $this->user = $user;
            $this->pass = $pass;
        }//O(1)

        private function connect() {
            $dns = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
            $this->connection = new PDO($dns, $this->user, $this->pass, $this->opt);
        }//O(1)

        public function disconnect() {
            $this->connection = null;
        }//O(1)

        //Cities functions:
        public function getCities() {   //Returns object cities array that holds all the cities from the DB
            $this->connect();
            $citiesArray = array();
            $result = $this->connection->query("SELECT * FROM city");
            while($row = $result->fetchObject('City'))
                $citiesArray[] = $row;
            $this->disconnect();
            return $citiesArray;
        }//O(N)

        public function getCityById(int $id) {  //Get id of a city and return that city object
            $this->connect();
            $statement = $this->connection->prepare("SELECT * FROM city WHERE cityCode = :id");
            $statement->execute([':id' => $id]);
            $result = $statement->fetchObject('City');
            $this->disconnect();
            return $result;
        }//O(1)

        public function getCityByName(string $text) {   //Get city name, if city is in the table return city object, none case sensative (mysql)
            $this->connect();
            $statement = $this->connection->prepare("SELECT * FROM city WHERE cityName = :something");
            $statement->execute([':something' => $text]);
            $result = $statement->fetchObject('City');
            $this->disconnect();
            return $result;
        }//O(1)

        public function deleteByCityId(int $id) {   //Get id & delete city with that id
            $this->connect();
            $statement = $this->connection->prepare("DELETE FROM city WHERE cityCode = :something");
            $statement->execute([':something' => $id]);
            $this->disconnect();
        }//O(1)

        //Person functions:
        public function getStudents() {     //Returns object persons array that holds all the people from the DB
            $this->connect();
            $array = array();
            $result = $this->connection->query("SELECT * FROM persons");
            while($row = $result->fetchObject('persons'))
                $array[] = $row;
            $this->disconnect();
            return $array;
        }//O(N)

        public function getStudentById(int $id) {   //Get id of a student and return that student
            $this->connect();
            $statement = $this->connection->prepare("SELECT * FROM persons WHERE id = :id");
            $statement->execute([':id' => $id]);
            $result = $statement->fetchObject('persons');
            $this->disconnect();
            return $result;
        }//O(1)

        public function getStudentByFirstName(string $text) {   //Get student name, if student is in the table return person object, none case sensative (mysql)
            $this->connect();
            $statement = $this->connection->prepare("SELECT * FROM persons WHERE firstName = :fname");
            $statement->execute([':fname' => $text]);
            $result = $statement->fetchObject('persons');
            $this->disconnect();
            return $result;
        }//O(1)

        public function getStudentByFullName(string $first, string $last) { //same function as "getStudentByFirstName" but as full name, none case sensative (mysql)
            $this->connect();
            $statement = $this->connection->prepare("SELECT * FROM persons WHERE firstName = :fname and lastName = :lname");
            $statement->execute([':fname' => $first, ':lname' => $last]);
            $result = $statement->fetchObject('persons');
            $this->disconnect();
            return $result;
        }//O(1)

        public function deleteByStudentId(int $id) {    //Get student id & because relations in the DB deleted first from grades table & then persons table
            $this->connect();
            $statement = $this->connection->prepare("DELETE FROM grades WHERE Id = :something");
            $statement->execute([':something' => $id]);
            $statement = $this->connection->prepare("DELETE FROM persons WHERE Id = :something");
            $statement->execute([':something' => $id]);
            $this->disconnect();
        }//O(1)

        public function addStudent(int $id, string $first, string $last, int $city, int $lin, int $bool, int $infi) {   //Get all information to add into persons & then grades
            $this->connect();
            $statement = $this->connection->prepare("INSERT INTO persons VALUES($id, :first, :last, $city)");
            $statement->execute([':first' => $first, ':last' => $last]);
            $this->connection->exec("INSERT INTO grades VALUES($id, $lin, $bool, $infi)");
            $this->disconnect();
        }//O(1)

        //Grades functions:
        public function getGrades() {   //Returns object Grades array that holds all the grades from the DB
            $this->connect();
            $array = array();
            $result = $this->connection->query("SELECT * FROM grades");
            while($row = $result->fetchObject('Gardes'))
                $array[] = $row;
            $this->disconnect();
            return $array;
        }//O(N)

        public function getGradeById(int $id) { //Get id of a student & return gardes object
            $this->connect();
            $statement = $this->connection->prepare("SELECT * FROM grades WHERE id = :id");
            $statement->execute([':id' => $id]);
            $result = $statement->fetchObject('Gardes');
            $this->disconnect();
            return $result;
        }//O(1)

        //Login function:
        public function login_check($name, $pass) { //Verification with case sensitive & bcrypt hash
            $this->connect();
            $array = array();
            $statement = $this->connection->prepare("SELECT * FROM login WHERE username = :name");
            $statement->execute([':name' => $name]);
            $result = $statement->fetchObject('Login_class');
            $this->disconnect();
            if ($result != null) {
                if (password_verify($result->getPassword(), $pass) && (strcmp($name, $result->getUsername()) == 0))
                    return true;
                else
                    return false;
            }
            else
                return false;
        }//O(1)
    }
?>