<?php
date_default_timezone_set('Asia/Bangkok');
session_start();

// localhost
$host = "localhost";
$user = "ebdd_project";
$password = "ebdd_project";
$dbname = "ebdd_project";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $error) {
    echo $error->getMessage();
}

function show($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}
