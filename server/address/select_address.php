<?php
require_once("../connect.php");
try {


    if ($_POST['action'] == "district") {
        $data = [
            'ProvinceID' => $_POST['ProvinceID']
        ];
        $sql = "SELECT * FROM address_district WHERE ProvinceID = :ProvinceID";
        $query = $conn->prepare($sql);
        $query->execute($data);
        $row = $query->fetchAll();
        echo json_encode($row);
    }

    if ($_POST['action'] == "tambon") {
        $data = [
            'DistrictID' => $_POST['DistrictID']
        ];
        $sql = "SELECT * FROM address_tambon WHERE DistrictID = :DistrictID";
        $query = $conn->prepare($sql);
        $query->execute($data);
        $row = $query->fetchAll();
        echo json_encode($row);
    }

    if ($_POST['action'] == "zipcode") {
        $data = [
            'TambonID' => $_POST['TambonID']
        ];
        $sql = "SELECT * FROM address_tambon WHERE TambonID = :TambonID";
        $query = $conn->prepare($sql);
        $query->execute($data);
        $row = $query->fetch();
        echo json_encode($row);
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
