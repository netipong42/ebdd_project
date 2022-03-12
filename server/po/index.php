<?php
require_once('../connect.php');
try {

    if (@$_POST['action'] == "show") {
        $sql = "SELECT 
                p.*,
                s.company_name 
                FROM purchase AS p
                INNER JOIN supplier AS s
                ON p.supplier_code = s.id
                WHERE p.status >=3
                ORDER BY id DESC";
        $query = $conn->prepare($sql);
        $query->execute();
        $row = $query->fetchAll();
        echo json_encode($row);
    }

    if (@$_POST['action'] == "delete") {
        $data = [
            'id' => $_POST['id'],
        ];
        $sql = "DELETE FROM purchase WHERE id = :id";
        $query = $conn->prepare($sql);
        $query->execute($data);
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
