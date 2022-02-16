<?php
    include('database_connection.php');

    if(!isset($_SESSION['type'])){
        header('location:login.php');
    }

    include('header.php');
?>



















<?php
include 'footer.php';
?>