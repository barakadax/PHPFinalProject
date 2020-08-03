<?php
    include_once "mail.htm";
    if(isset($_POST['mail']) && isset($_POST['subject']) && isset($_POST['info'])) {
        mail($_POST['mail'], $_POST['subject'], $_POST['info']);    //Saves the mail
        unset($_POST['mail']);
        unset($_POST['subject']);
        unset($_POST['info']);
    }
?>

<div>
    <form method="post">
        <label>Mail</label>
        <input type="texbox" class="input" name="mail">
        <label>Subject</label>
        <input type="texbox" class="input" name="subject">
        <label>Text</label>
        <input type="texbox" class="input" name="info">
        <input type="submit" value="SEND">
    </form>
</div>