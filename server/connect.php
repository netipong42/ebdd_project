<?php
date_default_timezone_set('Asia/Bangkok');
session_start();

// localhost
$host = "localhost";
$user = "ebdd_project";
$password = "ebdd_project";
$dbname = "ebdd_project";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $error) {
    echo $error->getMessage();
}

function show($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}
function checkModule($user_no, $module, $conn)
{
    try {

        $dataCheckStatus = [
            "user_no" => $user_no
        ];
        $sqlCheckStatus = "SELECT * FROM users WHERE id = :user_no";
        $queryCheckStatus = $conn->prepare($sqlCheckStatus);
        $queryCheckStatus->execute($dataCheckStatus);
        $rowCheckStatus = $queryCheckStatus->fetch();
        if ($rowCheckStatus['user_status'] != "A") {
            $dataCheck = [
                'user_no' => $user_no,
                'module_no' => $module
            ];
            $sqlCheck = "SELECT * FROM authorize WHERE user_no=:user_no AND module_no = :module_no";
            $queryCheck = $conn->prepare($sqlCheck);
            $queryCheck->execute($dataCheck);
            if ($queryCheck->rowCount() == 0) {
                echo '<meta http-equiv="refresh" content="0;url=../main/login.php">';
            }
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
