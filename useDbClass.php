<?php
    include_once "tables_first.htm";
    require_once("dbClass.php");
    $db = new dbClass();
    
    //Deletes a person from the the table, runs first after refresh so the person won't be shown in the table after user asked to delete that student
    if(isset($_POST['someone'])) {
        $db->deleteByStudentId((int)$_POST['someone']);
        unset($_POST['someone']);
    }
    
    $arr = $db->getStudents();  //Get all students 

    if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['somecity']) && isset($_POST['lin']) && isset($_POST['bool']) && isset($_POST['infi'])) {
        $flag = true;
        if (strlen(trim($_POST['fname'])) == 0) {   //Nothing was enetered
            echo "No first name was entered.<br>";
            $flag = false;
        }
        if (strlen(trim($_POST['lname'])) == 0) {   //Nothing was enetered
            echo "No last name was entered.<br>";
            $flag = false;
        }
        if (strlen(trim($_POST['lin'])) == 0) {     //Nothing was enetered
            echo "No number for linear was entered.<br>";
            $flag = false;
        }
        else if ((strcmp($_POST['lin'], '0') != 0) && (int)$_POST['lin'] == 0) {    //None numaric value
            echo "Invalid input for linear, please enter only numbers between 0-100.<br>";
            $flag = false;
        }
        else if ((int)$_POST['lin'] < 0 ||(int)$_POST['lin'] > 100) {       //Number that was entered is in none score range
            echo "Invalid input for linear, please enter only numbers between 0-100.<br>";
            $flag = false;
        }
        if (strlen(trim($_POST['bool'])) == 0) {     //Nothing was enetered
            echo "No number for boolean was entered.<br>";
            $flag = false;
        }
        else if ((strcmp($_POST['bool'], '0') != 0) && (int)$_POST['bool'] == 0) {  //None numaric value
            echo "Invalid input for boolean, please enter only numbers between 0-100.<br>";
            $flag = false;
        }
        else if ((int)$_POST['bool'] < 0 ||(int)$_POST['bool'] > 100) {     //Number that was entered is in none score range
            echo "Invalid input for boolean, please enter only numbers between 0-100.<br>";
            $flag = false;
        }
        if (strlen(trim($_POST['infi'])) == 0) {     //Nothing was enetered
            echo "No number for infi was entered.<br>";
            $flag = false;
        }
        else if ((strcmp($_POST['infi'], '0') != 0) && (int)$_POST['infi'] == 0) {  //None numaric value
            echo "Invalid input for infi, please enter only numbers between 0-100.<br>";
            $flag = false;
        }
        else if ((int)$_POST['infi'] < 0 ||(int)$_POST['infi'] > 100) {     //Number that was entered is in none score range
            echo "Invalid input for infi, please enter only numbers between 0-100.<br>";
            $flag = false;
        }
        if ($flag) {    //No issue occurred
            $db->addStudent(count($arr) + 1, $_POST['fname'], $_POST['lname'], (int)$_POST['somecity'], (int)$_POST['lin'], (int)$_POST['bool'], (int)$_POST['infi']);
            unset($_POST['fname']);
            unset($_POST['lname']);
            unset($_POST['somecity']);
            unset($_POST['lin']);
            unset($_POST['bool']);
            unset($_POST['infi']);
            header("Refresh: 0");
        }
        $flag = true;
    }

    //printing a table that shows the table of persons
    $table = "<table><tr><td><u>Name</u></td><td><u>City</u></td><td><u>Linear score</u></td><td><u>Boolean score</u></td><td><u>Infi score</u></td></tr>";
    for ($run = 0; $run < count($arr); $run -= -1) {
        $table .= "<tr><td>".$arr[$run]->getFirstName()." ".$arr[$run]->getLastName()."</td>";
        $table .= "<td>".$db->getCityById($arr[$run]->getCityCode())->getCityName()."</td>";
        $table .= "<td>".$db->getGradeById($arr[$run]->getId())->getLinear()."</td>";
        $table .= "<td>".$db->getGradeById($arr[$run]->getId())->getBoolean()."</td>";
        $table .= "<td>".$db->getGradeById($arr[$run]->getId())->getInfi()."</td></tr>";
    }
    $table .= "</table>";
    echo $table;

    if(isset($_POST['save'])) {     //Save students information in a new file
        $file = fopen("table.txt", "w");    //There is no "wb" in PHP
        $text = "";
        for ($run = 0; $run < count($arr); $run -= -1) {
            $text .= $arr[$run]->getFirstName()." ".$arr[$run]->getLastName()." ";
            $text .= $db->getCityById($arr[$run]->getCityCode())->getCityName()." ";
            $text .= $db->getGradeById($arr[$run]->getId())->getLinear()." ";
            $text .= $db->getGradeById($arr[$run]->getId())->getBoolean()." ";
            $text .= $db->getGradeById($arr[$run]->getId())->getLinear().PHP_EOL;
            fwrite($file, $text);
            $text = "";
        }
        unset($_POST['save']);
    }

    function combo_person($arr) {   //Make comboBox of all students for delete function
        $sentence = "<select class='space_bellow' name=someone>";
        for ($run = 0; $run < count($arr); $run -= -1) {
            $fname = $arr[$run]->getFirstName();
            $lname = $arr[$run]->getLastName();
            $special = $arr[$run]->getId();
            $sentence .= "<option value=$special'>$fname $lname</option>\n";
        }
        $sentence .= "</select>";
        return $sentence;
    }//O(N)

    function combo_city($city) {    //Make comboBox of all cities for add student function
        $sentence = "<select class='space_bellow' name=somecity>";
        for ($run = 0; $run < count($city); $run -= -1) {
            $name = $city[$run]->getCityName();
            $special = $city[$run]->getCityId();
            $sentence .= "<option value=$special'>$name</option>\n";
        }
        $sentence .= "</select>";
        return $sentence;
    }//O(N)

    $db = null;
    gc_collect_cycles();
?>

<!--Window to delete someone, JS for hide & show this window-->
<div id="window">
    <div>
        <input type="image" src="stuff/close.png" alt="close" class="img" onclick="exit_adding_note()">
        <form method="POST">
            <?php
                $db = new dbClass();
                $arr = $db->getStudents();
                echo combo_person($arr);
                $db = null;
                gc_collect_cycles();
            ?>
            <input type="submit" value="DELETE">
        </form>
    </div>
</div>

<!--Open a window for verification you want to leave to contact page-->
<div id="contact">
    <div>
        <input type="image" src="stuff/close.png" alt="close" class="img" onclick="exit_adding_note()">
        <form method="POST" action="mail.php">
            <input type="submit" value="LEAVE" name="leave">
        </form>
    </div>
</div>

<!--Button pressed and it gives value for $_POST['save'] so it will create file & fill-->
<div id="save">
    <div>
        <input type="image" src="stuff/close.png" alt="close" class="img" onclick="exit_adding_note()">
        <form method="post">
            <input type="submit" value="SAVE" name="save">
        </form>
    </div>
</div>

<!--Window for adding a student-->
<div id="adding">
    <div>
        <input type="image" src="stuff/close.png" alt="close" class="img" onclick="exit_adding_note()">
        <form method="POST">
            <div  class="no"><label>First name: </label><input type="textbox" name="fname" class="input"></div>
            <div  class="no"><label>Last name: </label><input type="textbox" name="lname" class="input"></div>
            <div  class="no"><label>city: </label>
            <?php
                $db = new dbClass();
                $cities = $db->getCities();
                echo combo_city($cities);
                $db = null;
                gc_collect_cycles();
            ?></div>
            <div  class="no"><label>Linear score: </label><input type="textbox" name="lin" class="input"></div>
            <div  class="no"><label>Boolean score: </label><input type="textbox" name="bool" class="input"></div>
            <div  class="no"><label>Infi score: </label><input type="textbox" name="infi" class="input"></div>
            <div  class="no"><input type="submit" value="ADD"></div>
        </form>
    </div>
</div>

<?php
    include_once "tables_last.htm";
?>