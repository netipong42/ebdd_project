<?php
require_once('../connect.php');


try {


    if (@$_POST['action'] == "insert") {
        $data = [
            'unit_name' => $_POST['unit_name'],
        ];

        $sql = "INSERT INTO product_unit (unit_name) VALUES (:unit_name)";
        $query = $conn->prepare($sql);
        $query->execute($data);
    }

    if (@$_POST['action'] == "show") {
        $sql = "SELECT * FROM product_unit";
        $query = $conn->prepare($sql);
        $query->execute();
        $row = $query->fetchAll();
        echo json_encode($row);
    }

    if (@$_POST['action'] == "delete") {
        $data = [
            'id' => $_POST['id'],
        ];
        $sql = "DELETE FROM product_unit WHERE id = :id";
        $query = $conn->prepare($sql);
        $query->execute($data);
    }

    if (@$_POST['action'] == "edit") {
        $data = [
            'id' => $_POST['id'],
        ];
        $sql = "SELECT * FROM product_unit WHERE id = :id";
        $query = $conn->prepare($sql);
        $query->execute($data);
        $row = $query->fetchAll();
        echo json_encode($row);
    }

    if (@$_POST['action'] == "update") {
        $data = [
            'unit_name' => $_POST['unit_name'],
            'id' => $_POST['unit_id'],
        ];
        $sql = "UPDATE product_unit SET unit_name = :unit_name WHERE id = :id";
        $query = $conn->prepare($sql);
        $query->execute($data);
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
