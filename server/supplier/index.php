<?php
require_once('../connect.php');
try {


    if (@$_POST['action'] == "insert") {
        $data = [
            'company_name'  => $_POST['company_name'],
            'title'         => $_POST['title'],
            'name'          => $_POST['name'],
            'last'          => $_POST['last'],
            'mail'          => $_POST['mail'],
            'phone'         => $_POST['phone'],
            'address'       => $_POST['address'],
            'province'      => $_POST['province'],
            'district'      => $_POST['district'],
            'tambon'        => $_POST['tambon'],
            'zipcode'       => $_POST['zipcode'],
        ];

        $sql = "INSERT INTO supplier 
                        (
                        company_name,
                        title,
                        name,
                        last,
                        mail,
                        phone,
                        address,
                        province,
                        district,
                        tambon,
                        zipcode
                        ) 
                    VALUES (
                        :company_name,
                        :title,
                        :name,
                        :last,
                        :mail,
                        :phone,
                        :address,
                        :province,
                        :district,
                        :tambon,
                        :zipcode
                        )";
        $query = $conn->prepare($sql);
        $query->execute($data);
    }

    if (@$_POST['action'] == "show") {
        $sql = "SELECT * FROM supplier AS s
                INNER JOIN title_name AS t 
                ON s.title = t.id
                INNER JOIN address_province AS p
                ON s.province = p.ProvinceID
                INNER JOIN address_district AS d
                ON s.district = d.DistrictID
                INNER JOIN address_tambon AS tb
                ON s.tambon = tb.TambonID
                ";
        $query = $conn->prepare($sql);
        $query->execute();
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
                        product_type = :product_type
                        WHERE id = :id";
            $query = $conn->prepare($sql);
            $query->execute($data);
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
