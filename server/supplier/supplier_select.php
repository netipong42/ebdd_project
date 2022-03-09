<?php
require_once("../connect.php");

$data = [
    "supplier_no" => $_POST['supplier_no'],
];
$sql = "SELECT 
        s.*,
        t.title_name
        FROM supplier AS s
        INNER JOIN title_name AS t 
        ON s.title = t.id
        WHERE s.id = :supplier_no
        ";
$query = $conn->prepare($sql);
$query->execute($data);
$row = $query->fetch(PDO::FETCH_ASSOC);


$sql_i = "SELECT 
        p.*,
        t.type_name,
        s.company_name,
        u.unit_name 
        FROM product AS p
        LEFT JOIN product_type AS t
        ON p.product_type = t.id 
        LEFT JOIN supplier AS s
        ON p.product_supplier = s.id 
        LEFT JOIN product_unit AS u
        ON p.product_unit = u.id
        WHERE p.product_supplier = :supplier_no
        ";
$query_i = $conn->prepare($sql_i);
$query_i->execute($data);
$row_i = $query_i->fetchAll(PDO::FETCH_ASSOC);

$data_send = [
    'supplier' => $row,
    'inventory' => $row_i
];

echo json_encode($data_send);
