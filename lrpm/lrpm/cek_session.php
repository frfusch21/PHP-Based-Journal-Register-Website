<?php 
//
session_start();
if(isset($_SESSION['id_number']) && isset($_SESSION['tipe'])){
    if($_SESSION['tipe']=="admin"){
        header("Location: home-admin.php");
        exit();
    }else{
        header("Location: home-creator.php");
        exit();
    }
}