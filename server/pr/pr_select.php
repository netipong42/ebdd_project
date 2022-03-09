<?php
require_once('../connect.php');
$data = [
    'product_id' => $_POST['product_id']
];

$in = '(' . implode(',', $data['product_id']) . ')';

$sql = "SELECT 
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
        WHERE p.id IN $in
        ";
$query = $conn->prepare($sql);
$query->execute();
$row = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($row);
