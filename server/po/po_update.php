<?php
require_once('../connect.php');
try {

    $dataUpdatePo = [
        'purchase_id'   => $_POST['purchase_id'],
    ];
    if ($_POST['btnstatus'] == "success") {
        $dataUpdatePo['status'] = 4;
    }
    if ($_POST['btnstatus'] == "cancel") {
        $dataUpdatePo['status'] = 5;
    }
    // Update the purchase
    $sqlUpdatePo = "UPDATE purchase SET status = :status WHERE id = :purchase_id";
    $queryUpdatePo = $conn->prepare($sqlUpdatePo);
    $queryUpdatePo->execute($dataUpdatePo);

    // Update the Product
    if ($_POST['btnstatus'] == "success") {
        foreach ($_POST['product_code'] as $key => $item) {

            $dataProduct = [
                'id' => $_POST['product_code'][$key],
                'product_stock' => $_POST['qty'][$key],
            ];

            $sqlUpdateStock = "UPDATE product SET 
                            product_stock =product_stock+ :product_stock 
                            WHERE id = :id";
            $queryUpdateStock = $conn->prepare($sqlUpdateStock);
            $queryUpdateStock->execute($dataProduct);
        }
    }
    if ($queryUpdatePo) {
        $_SESSION["myalert"] = "success";
    } else {
        $_SESSION["myalert"] = "error";
    }
    header("Location: ../../view/po/index.php");
} catch (Exception $e) {
    echo $e->getMessage();
}
