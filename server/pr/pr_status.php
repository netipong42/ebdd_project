<?php
require_once('../connect.php');

$data = [
    'id' => $_GET['id'],
    'status' => $_GET['status'],
];

$sql = "UPDATE purchase SET 
        status      = :status 
        WHERE id    = :id
        ";
$query = $conn->prepare($sql);
$query->execute($data);
if ($query) {
    $_SESSION["myalert"] = "success";
} else {
    $_SESSION["myalert"] = "error";
}
header("Location: ../../view/pr/index.php");
