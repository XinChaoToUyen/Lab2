<?php 
//Kết nối CSDL
$conn=new PDO('mysql:host=localhost;dbname=lab_2','root','');
$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$conn->exec('set names utf8');
?>
