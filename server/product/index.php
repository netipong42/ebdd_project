<?php
require_once('../connect.php');
try {


    if (@$_POST['action'] == "insert") {
        // img
        $name = date("Ymd") . rand();
        $img_type = strrchr($_FILES['product_img']['name'], ".");
        $newname = $name . $img_type;
        $copy = "../image/" . $newname;


        $data = [
            'product_name' => $_POST['product_name'],
            'product_price' => $_POST['product_price'],
            'product_stock' => $_POST['product_stock'],
            'product_info' => $_POST['product_info'],
            'product_type' => $_POST['product_type'],
            'product_unit' => $_POST['product_unit'],
            'product_house' => $_POST['product_house'],
            'product_supplier' => $_POST['product_supplier'],
            'product_img' => $newname,
        ];

        $sql = "INSERT INTO product 
                        (
                        product_name, 
                        product_price, 
                        product_stock, 
                        product_info, 
                        product_type, 
                        product_unit, 
                        product_house, 
                        product_supplier, 
                        product_img
                        ) 
                    VALUES (
                        :product_name, 
                        :product_price, 
                        :product_stock, 
                        :product_info, 
                        :product_type, 
                        :product_unit, 
                        :product_house, 
                        :product_supplier, 
                        :product_img
                        )";
        $query = $conn->prepare($sql);
        $query->execute($data);
        if ($query) {
            move_uploaded_file($_FILES['product_img']['tmp_name'], $copy);
        }
    }

    if (@$_POST['action'] == "show") {
        $sql = "SELECT 
        p.*,
        t.type_name,
        s.company_name,
        u.unit_name ,
        h.house_name
        FROM product AS p
        LEFT JOIN product_type AS t
        ON p.product_type = t.id 
        LEFT JOIN supplier AS s
        ON p.product_supplier = s.id 
        LEFT JOIN product_unit AS u
        ON p.product_unit = u.id
        LEFT JOIN product_house AS h
        ON p.product_house = h.id";
        $query = $conn->prepare($sql);
        $query->execute();
        $row = $query->fetchAll();
        echo json_encode($row);
    }
    if (@$_POST['action'] == "showProductHouse") {
        $data = [
            'house_id' => $_POST['idHouse']
        ];
        $sql = "SELECT 
        p.*,
        t.type_name,
        s.company_name,
        u.unit_name ,
        h.house_name
        FROM product AS p
        LEFT JOIN product_type AS t
        ON p.product_type = t.id 
        LEFT JOIN supplier AS s
        ON p.product_supplier = s.id 
        LEFT JOIN product_unit AS u
        ON p.product_unit = u.id
        LEFT JOIN product_house AS h
        ON p.product_house = h.id
        WHERE p.product_house = :house_id
        ";
        $query = $conn->prepare($sql);
        $query->execute($data);
        $row = $query->fetchAll();
        echo json_encode($row);
    }

    if (@$_POST['action'] == "delete") {
        $data = [
            'id' => $_POST['id'],
        ];
        $sql = "DELETE FROM product WHERE id = :id";
        $query = $conn->prepare($sql);
        $query->execute($data);
    }



    if (@$_POST['action'] == "update") {

        $data = [
            'id' => $_POST['id'],
            'product_name' => $_POST['product_name'],
            'product_price' => $_POST['product_price'],
            'product_stock' => $_POST['product_stock'],
            'product_info' => $_POST['product_info'],
            'product_type' => $_POST['product_type'],
            'product_unit' => $_POST['product_unit'],
            'product_house' => $_POST['product_house'],
            'product_supplier' => $_POST['product_supplier'],

        ];
        if ($_FILES['product_img']['name'] != "") {

            $dataCheck = [
                'id' => $_POST['id'],
            ];
            $sqlCheck = "SELECT * FROM product WHERE id = :id";
            $queryCheck = $conn->prepare($sqlCheck);
            $queryCheck->execute($dataCheck);
            $rowCheck = $queryCheck->fetch();

            if ($rowCheck['product_img'] != "") {
                unlink("../image/" . $rowCheck['product_img']);
            }

            // img
            $name = date("Ymd") . rand();
            $img_type = strrchr($_FILES['product_img']['name'], ".");
            $newname = $name . $img_type;
            $copy = "../image/" . $newname;
            // add image
            $data['product_img'] = $newname;

            $sql = "UPDATE product SET 
                        product_name = :product_name, 
                        product_price = :product_price, 
                        product_stock = :product_stock, 
                        product_info = :product_info, 
                        product_type = :product_type, 
                        product_unit = :product_unit, 
                        product_house = :product_house, 
                        product_supplier = :product_supplier, 
                        product_img = :product_img
                        WHERE id = :id";
            $query = $conn->prepare($sql);
            $query->execute($data);
            if ($query) {
                move_uploaded_file($_FILES['product_img']['tmp_name'], $copy);
            }
        } else {
            $sql = "UPDATE product SET 
                        product_name = :product_name, 
                        product_price = :product_price, 
                        product_stock = :product_stock, 
                        product_info = :product_info, 
                        product_type = :product_type,
                        product_unit = :product_unit,
                        product_house = :product_house, 
                        product_supplier = :product_supplier
                        WHERE id = :id";
            $query = $conn->prepare($sql);
            $query->execute($data);
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
