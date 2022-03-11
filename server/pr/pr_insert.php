<?php
require_once('../connect.php');
try {
    // Insert the new purchase
    $data = [
        'supplier_code' => $_POST['supplier_code'],
        'document_no'   => $_POST['document_no'],
        'docCreated'    => $_POST['docCreated'],
        'docWant'       => $_POST['docWant'],
        'docExe'        => $_POST['docExe'],
        'credit'        => $_POST['credit'],
        'sendProduct'   => $_POST['sendProduct'],
        'totalMoney'    => $_POST['totalMoney'],
        'discountPer'   => $_POST['discountPer'],
        'totalDiscount' => $_POST['totalDiscount'],
        'totalVat'      => $_POST['totalVat'],
        'totalFanal'    => $_POST['totalFanal'],
        'status'        => 1,
    ];

    $sql_purchase = "INSERT INTO purchase 
                (
                supplier_code,
                document_no,
                docCreated,
                docWant,
                docExe,
                credit,
                sendProduct,
                totalMoney,
                discountPer,
                totalDiscount,
                totalVat,
                totalFanal,
                status
                )
                VALUES(
                :supplier_code,
                :document_no,
                :docCreated,
                :docWant,
                :docExe,
                :credit,
                :sendProduct,
                :totalMoney,
                :discountPer,
                :totalDiscount,
                :totalVat,
                :totalFanal,
                :status
                )
                ";
    $query_purchase = $conn->prepare($sql_purchase);
    $query_purchase->execute($data);


    // Insert the new purchase_detail
    $purchase_id = $conn->lastInsertId();
    foreach ($_POST['qty'] as $key => $item) {

        $data_detail = [
            'document_no'   => $purchase_id,
            'product_code'  => $_POST['product_code'][$key],
            'qty'           => $_POST['qty'][$key],
            'price'         => $_POST['price'][$key],
            'discount'      => $_POST['discount'][$key],
            'total'         => $_POST['total'][$key],
        ];

        $sql_detail = "INSERT INTO purchase_detail 
                (
                document_no,
                product_code,
                qty,
                price,
                discount,
                total
                )
                VALUES(
                :document_no,
                :product_code,
                :qty,
                :price,
                :discount,
                :total
                )
                ";
        $query_detail = $conn->prepare($sql_detail);
        $query_detail->execute($data_detail);
    }


    header("Location: ../../view/pr/index.php");
} catch (Exception $e) {
    echo $e->getMessage();
}
