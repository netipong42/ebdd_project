<?php
date_default_timezone_set('Asia/Bangkok');
session_start();
// server
// $host = "localhost";
// $user = "ineedgam_find";
// $password = "findfind";
// $dbname = "ineedgam_find";

// localhost
$host = "localhost";
$user = "root";
$password = "";
$dbname = "game";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $error) {
    echo $error->getMessage();
}

function show($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}
