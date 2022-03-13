<!-- Page Wrapper -->


<?php
require_once("../../server/connect.php");
$slqCountPr = "SELECT COUNT(id) AS count FROM purchase AS p  WHERE p.status IN (1,2,3)";
$queryCountPr = $conn->prepare($slqCountPr);
$queryCountPr->execute();
$rowCountPr = $queryCountPr->fetch(PDO::FETCH_ASSOC);

// 
$slqCountPo = "SELECT COUNT(id) AS count FROM purchase AS p  WHERE p.status IN (3 )";
$queryCountPo = $conn->prepare($slqCountPo);
$queryCountPo->execute();
$rowCountPo = $queryCountPo->fetch(PDO::FETCH_ASSOC);

// House
$slqHouse = "SELECT * FROM product_house AS h";
$queryHouse = $conn->prepare($slqHouse);
$queryHouse->execute();
$rowHouse = $queryHouse->fetchAll(PDO::FETCH_ASSOC);


?>
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-ntp sidebar sidebar-dark accordion" id="accordionSidebar">

        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Project <sup>NMB</sup></div>
        </a>

        <hr class="sidebar-divider my-3">

        <li class="nav-item">
            <a class="nav-link" href="index.php">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>หน้าหลัก</span></a>
        </li>

        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            สมาชิก
        </div>

        <li class="nav-item">
            <a class="nav-link" href="../pr">
                <i class="fas fa-file-signature"></i>
                <span>ใบเสนอซื้อ (PR) <sup class="badge badge-light"><?php echo $rowCountPr['count'] ?></sup> </span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../po">
                <i class="fas fa-clipboard-check"></i>
                <span>ใบสั่งซื้อ (PO) <sup class="badge badge-light"><?php echo $rowCountPo['count'] ?></sup></span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../supplier">
                <i class="fas fa-user-edit"></i>
                <span>จัดการตัวแทนจำหน่าย</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUser">
                <i class="fas fa-fw fa-cog"></i>
                <span>จัดการสมาชิก</span>
            </a>
            <div id="collapseUser" class="collapse">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">จัดการสินค้า:</h6>
                    <a class="collapse-item" href="../user">สมาชิก</a>
                    <a class="collapse-item" href="../authorize">authorize</a>

                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>จัดการสินค้า</span>
            </a>
            <div id="collapseTwo" class="collapse">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">จัดการสินค้า:</h6>
                    <a class="collapse-item" href="../product">สินค้า</a>
                    <a class="collapse-item" href="../product_type">ประเภท</a>
                    <a class="collapse-item" href="../product_unit">หน่วยนับ</a>
                    <a class="collapse-item" href="../product_house">คลังสินค้า</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseHouse">
                <i class="fas fa-fw fa-cog"></i>
                <span>คลังสินค้า</span>
            </a>
            <div id="collapseHouse" class="collapse">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">คลังสินค้า:</h6>
                    <?php foreach ($rowHouse as $item) :  ?>
                        <a class="collapse-item" href="../product_house/house.php?id=<?php echo $item['id'] ?>"><?php echo $item['house_name'] ?></a>
                    <?php endforeach ?>

                </div>
            </div>
        </li>
        <hr class="sidebar-divider d-none d-md-block">
        <li class="nav-item">
            <a class="nav-link" href="../../server/logout.php">
                <i class="fas fa-sign-out-alt"></i>
                <span>ออกจากระบบ</span></a>
        </li>
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>

    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            <!-- Begin Page Content -->
            <div class="container-fluid mt-5">