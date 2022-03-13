<?php
require_once("../connect.php");
try {
    $data = [
        'user_no' => $_POST['user_no'],
        'module_no' => $_POST["module_no"]
    ];
    $sql = "INSERT INTO authorize (user_no, module_no) VALUES (:user_no, :module_no)";
    $query = $conn->prepare($sql);
    $query->execute($data);

    if ($query) {
        Header("Location:../../view/authorize/");
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
