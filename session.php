<?php
    session_name("ferretradio_cookie");
    if(!isset($_SESSION))
    {
        session_start();
    }

    // Setting local timezone
    if(isset($_GET['set']) AND $_GET['set'] == "timezone")
    {
        if(isset($_POST['tz']) AND $_POST['tz'] != "")
        {
            $_SESSION['timezone'] = $_POST['tz'];
            date_default_timezone_set($_SESSION['timezone']);
        }
    }
    
?>