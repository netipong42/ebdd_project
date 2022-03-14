<?php
require_once("./connect.php");

try {

    $data = [
        'user' => $_POST['user'],
        'pass' => md5($_POST['pass'])
    ];

    $sql = "SELECT * FROM users WHERE user_login = :user AND user_pass = :pass";
    $query = $conn->prepare($sql);
    $query->execute($data);
    $row = $query->fetch(PDO::FETCH_ASSOC);


    if ($query->rowCount() == 1) {
        $_SESSION["user_id"] = $row["id"];
        Header("Location:../view/main/");
    } else {
        Header("Location:../view/main/login.php");
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
