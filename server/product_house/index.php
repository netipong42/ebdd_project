<?php
require_once('../connect.php');


try {


    if (@$_POST['action'] == "insert") {
        $data = [
            'house_name' => $_POST['house_name'],
        ];

        $sql = "INSERT INTO product_house (house_name) VALUES (:house_name)";
        $query = $conn->prepare($sql);
        $query->execute($data);
    }

    if (@$_POST['action'] == "show") {
        $sql = "SELECT * FROM product_house";
        $query = $conn->prepare($sql);
        $query->execute();
        $row = $query->fetchAll();
        echo json_encode($row);
    }

    if (@$_POST['action'] == "delete") {
        $data = [
            'id' => $_POST['id'],
        ];
        $sql = "DELETE FROM product_house WHERE id = :id";
        $query = $conn->prepare($sql);
        $query->execute($data);
    }

    if (@$_POST['action'] == "edit") {
        $data = [
            'id' => $_POST['id'],
        ];
        $sql = "SELECT * FROM product_house WHERE id = :id";
        $query = $conn->prepare($sql);
        $query->execute($data);
        $row = $query->fetchAll();
        echo json_encode($row);
    }

    if (@$_POST['action'] == "update") {
        $data = [
            'house_name' => $_POST['house_name'],
            'id' => $_POST['house_id'],
        ];
        $sql = "UPDATE product_house SET house_name = :house_name WHERE id = :id";
        $query = $conn->prepare($sql);
        $query->execute($data);
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
