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
        $sql = "SELECT 
                s.*,
                t.title_name,
                p.ProvinceThai,
                d.DistrictName,
                tb.TambonName
                FROM supplier AS s
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
        $sql = "DELETE FROM supplier WHERE id = :id";
        $query = $conn->prepare($sql);
        $query->execute($data);
    }

    if (@$_POST['action'] == "update") {
        $data = [
            'id'            => $_POST['id'],
            'tax'            => $_POST['tax'],
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
        $sql = "UPDATE supplier SET 
                tax = :tax, 
                company_name = :company_name, 
                title = :title, 
                name = :name, 
                last = :last, 
                mail = :mail, 
                phone = :phone,
                address = :address,
                province = :province,
                district = :district,
                tambon = :tambon,
                zipcode = :zipcode
                WHERE id = :id";
        $query = $conn->prepare($sql);
        $query->execute($data);
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
