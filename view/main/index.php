<?php
require_once("../../server/connect.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../assets/img/logo.png" type="image/x-icon">
    <?php require_once("../template/linkheader.php") ?>
    <title>Admin</title>
</head>

<body>

    <?php require_once("../template/navbar.php") ?>
    <!-- content -->
    <div class="row">
        <div class="col-8 mx-auto">
            <div class="jumbotron">
                <h1 class="display-4">Admin</h1>
                <p class="lead">ระบบออกใบเสนอซื้อ , ออกใบสั่งซื้อ , บริหารจัดการบริษัทตัวแทน , บริหารจัดการสินค้า , บริหารจัดการสมาชิก</p>
                <hr class="my-4">
            </div>
        </div>
    </div>

    <!-- content -->
    <?php require_once("../template/footer.php") ?>
    <?php require_once("../template/linkfooter.php") ?>

</body>

</html>