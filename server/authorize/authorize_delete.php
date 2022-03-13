<?php

require_once("../connect.php");

try {
    $data = [
        "id" => $_GET['id'],
        "module" => $_GET['module'],
    ];
    show($data);
    $sql = "DELETE FROM authorize WHERE user_no = :id AND module_no = :module";
    $query = $conn->prepare($sql);
    $query->execute($data);

    if ($query) {
        Header("Location:../../view/authorize/");
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
