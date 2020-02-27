<?php
session_start();
//ON KILL TOUT
session_destroy();
header("Location:login.php");
?>