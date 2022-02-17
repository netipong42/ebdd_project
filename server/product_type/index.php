<?php
require_once('../connect.php');

if (@$_POST['action'] == "insert") {
    $data = [
        'type_name' => $_POST['type_name'],
    ];

    $sql = "INSERT INTO product_type (type_name) VALUES (:type_name)";
    $query = $conn->prepare($sql);
    $query->execute($data);
}

if (@$_POST['action'] == "show") {
    $sql = "SELECT * FROM product_type";
    $query = $conn->prepare($sql);
    $query->execute();
    $row = $query->fetchAll();
    echo json_encode($row);
}

if (@$_POST['action'] == "delete") {
    $data = [
        'id' => $_POST['id'],
    ];
    $sql = "DELETE FROM product_type WHERE id = :id";
    $query = $conn->prepare($sql);
    $query->execute($data);
}
if (@$_POST['action'] == "edit") {
    $data = [
        'id' => $_POST['id'],
    ];
    $sql = "SELECT * FROM product_type WHERE id = :id";
    $query = $conn->prepare($sql);
    $query->execute($data);
    $row = $query->fetchAll();
    echo json_encode($row);
}
if (@$_POST['action'] == "update") {
    $data = [
        'type_name' => $_POST['type_name'],
        'id' => $_POST['type_id'],
    ];
    $sql = "UPDATE product_type SET type_name = :type_name WHERE id = :id";
    $query = $conn->prepare($sql);
    $query->execute($data);
}
