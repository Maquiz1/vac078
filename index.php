<?php
    include('database_connection.php');
    // $message = ''; 
    if(!isset($_SESSION['type'])){
        header('location:login.php');
    }

    include('header.php');
?>