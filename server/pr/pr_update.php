<?php
require_once('../connect.php');
try {
    // Insert the new purchase
    $data = [
        'purchase_id'   => $_POST['purchase_id'],
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
    show($data);
    $sql_purchase = "UPDATE  purchase  SET
                supplier_code   = :supplier_code,
                document_no     = :document_no,
                docCreated      = :docCreated,
                docWant         = :docWant,
                docExe          = :docExe,
                credit          = :credit,
                sendProduct     = :sendProduct,
                totalMoney      = :totalMoney,
                discountPer     = :discountPer,
                totalDiscount   = :totalDiscount,
                totalVat        = :totalVat,
                totalFanal      = :totalFanal,
                status          = :status
                WHERE id = :purchase_id
                ";
    $query_purchase = $conn->prepare($sql_purchase);
    $query_purchase->execute($data);


    // Insert the new purchase_detail
    $purchase_id = $conn->lastInsertId();
    foreach ($_POST['qty'] as $key => $item) {

        $data_detail = [
            'document_no'   => $_POST['purchase_id'],
            'product_code'  => $_POST['product_code'][$key],
            'qty'           => $_POST['qty'][$key],
            'price'         => $_POST['price'][$key],
            'discount'      => $_POST['discount'][$key],
            'total'         => $_POST['total'][$key],
        ];
        show($data_detail);

        $sql_detail = "UPDATE  purchase_detail SET
                qty             = :qty,
                price           = :price,
                discount        = :discount,
                total           = :total
                WHERE document_no = :document_no
                AND  product_code = :product_code
                ";
        $query_detail = $conn->prepare($sql_detail);
        $query_detail->execute($data_detail);
    }


    header("Location: ../../view/pr/index.php");
} catch (Exception $e) {
    echo $e->getMessage();
}
