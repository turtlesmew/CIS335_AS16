<?php
// This code was adapted from files on canvas
    session_start();
    session_destroy();
    header("Location: login.php");
?>