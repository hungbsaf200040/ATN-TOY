<?php

$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'atn-toy';


$conn = mysqli_connect($hostname, $username, $password, $database);

// Kiem tra ket noi
if(!$conn){
    die('Loi lien ket den MySQL: ' . mysqli_connect_error);
}

// echo 'Ket noi thanh cong den MySQL!';