<?php
    include_once "login_first.htm";
    require_once("dbClass.php");
    $db = new dbClass();

    if (isset($_POST['username']) && isset($_POST['password'])) {   //Checks if username & password were entered
        if ((strlen(trim($_POST['username'])) > 0) && (strlen(trim($_POST['password'])) > 0)) { //Values were entered
            if ($db->login_check($_POST['username'], password_hash($_POST['password'], PASSWORD_BCRYPT, ["cost" => 8]))) {  //Crypt password & send for validation
                header("Location: useDbClass.php"); //Verified and moved to other page
                die();
            }
            else
                echo "Invalid input, insufficient permissions.";    //Incorrect username or password
        }
        else {
            echo "Username or password weren't entered correctly.<br>Please try again.";    //Missing information
        }
    }
    $db = null;
    gc_collect_cycles();
    include_once "login_last.htm";
?>