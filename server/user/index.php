<?php
require_once('../connect.php');
try {


    if (@$_POST['action'] == "insert") {
        // img
        $name = date("Ymd") . rand();
        $img_type = strrchr($_FILES['user_img']['name'], ".");
        $newname = $name . $img_type;
        $copy = "../image/" . $newname;


        $data = [
            'user_login' => $_POST['user_login'],
            'user_pass' => md5($_POST['user_pass']),
            'user_email' => $_POST['user_email'],
            'user_title' => $_POST['user_title'],
            'user_name' => $_POST['user_name'],
            'user_last' => $_POST['user_last'],
            'user_status' => $_POST['user_status'],
            'user_img' => $newname,
        ];

        $sql = "INSERT INTO users 
                        (
                    user_login,
                    user_pass,
                    user_email,
                    user_title,
                    user_name,
                    user_last,
                    user_status,
                    user_img
                        ) 
                    VALUES (
                    :user_login,
                    :user_pass,
                    :user_email,
                    :user_title,
                    :user_name,
                    :user_last,
                    :user_status,
                    :user_img
                        )";
        $query = $conn->prepare($sql);
        $query->execute($data);
        if ($query) {
            move_uploaded_file($_FILES['user_img']['tmp_name'], $copy);
        }
    }

    if (@$_POST['action'] == "show") {
        $sql = "SELECT 
        u.*,
        t.title_name
        FROM users AS u
        INNER JOIN title_name AS t
        ON u.user_title = t.id
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
        $sql = "DELETE FROM users WHERE id = :id";
        $query = $conn->prepare($sql);
        $query->execute($data);
    }



    if (@$_POST['action'] == "update") {

        $data = [
            'id' => $_POST['id'],
            'user_email' => $_POST['user_email'],
            'user_title' => $_POST['user_title'],
            'user_name' => $_POST['user_name'],
            'user_last' => $_POST['user_last'],
            'user_status' => $_POST['user_status'],
        ];
        if ($_FILES['user_img']['name'] != "") {

            $dataCheck = [
                'id' => $_POST['id'],
            ];
            $sqlCheck = "SELECT * FROM users WHERE id = :id";
            $queryCheck = $conn->prepare($sqlCheck);
            $queryCheck->execute($dataCheck);
            $rowCheck = $queryCheck->fetch();

            if ($rowCheck['user_img'] != "") {
                unlink("../image/" . $rowCheck['user_img']);
            }

            // img
            $name = date("Ymd") . rand();
            $img_type = strrchr($_FILES['user_img']['name'], ".");
            $newname = $name . $img_type;
            $copy = "../image/" . $newname;
            // add image
            $data['user_img'] = $newname;

            $sql = "UPDATE users SET 
                        user_email = :user_email, 
                        user_title = :user_title, 
                        user_name = :user_name, 
                        user_last = :user_last, 
                        user_status = :user_status, 
                        user_img = :user_img
                        WHERE id = :id";
            $query = $conn->prepare($sql);
            $query->execute($data);
            if ($query) {
                move_uploaded_file($_FILES['user_img']['tmp_name'], $copy);
            }
        } else {
            $sql = "UPDATE users SET 
                       user_email = :user_email, 
                        user_title = :user_title, 
                        user_name = :user_name, 
                        user_last = :user_last,
                        user_status = :user_status
                        WHERE id = :id";
            $query = $conn->prepare($sql);
            $query->execute($data);
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
