<?php
require_once("../../server/connect.php");
checkModule(@$_SESSION["user_id"], basename(dirname(__FILE__)), $conn);
$data = ['id' => $_GET['id']];
$sql = "SELECT 
        u.id,
        u.user_name,
        a.module_no
        FROM users AS u
        INNER JOIN authorize AS a
        ON u.id = a.user_no 
        WHERE u.id =:id
        ";
$query = $conn->prepare($sql);
$query->execute($data);
$row = $query->fetchAll(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>
    <?php require_once("../template/linkheader.php") ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <?php require_once("../template/navbar.php") ?>
    <!-- เนื้อหา -->
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-warning">
                <div class="card-header">
                    <h1>Authorize Edit</h1>
                </div>
                <div class="card-body">
                    <h3><?php echo $row[0]['user_name'] ?></h3>
                    <div>
                        <ul class="list-group">
                            <?php foreach ($row as $item) :  ?>
                                <li class="list-group-item d-flex align-items-center justify-content-between">
                                    <?php echo $item['module_no']  ?>
                                    <button onClick="confirmAlert('<?php echo $item["id"] ?>','<?php echo $item["module_no"] ?>')" class="btn btn-danger"><i class="fas fa-backspace"></i></button>
                                </li>
                            <?php endforeach  ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- เนื้อหา -->
    <?php require_once("../template/footer.php") ?>
    <?php require_once("../template/linkfooter.php") ?>
    <script>
        function confirmAlert(id, module_no) {
            Swal.fire({
                icon: `warning`,
                title: `ยืนยันการลบ`,
                text: `ต้องการลบข้อมูลหรือไม่`,
                showCancelButton: true,
                cancelButtonText: `ยกเลิก`,
                cancelButtonColor: `#E74A3B`,
                confirmButtonText: `ตกลง`,
                confirmButtonColor: `#1CC88A`,
            }).then((res) => {
                if (res.isConfirmed) {
                    location.assign(`../../server/authorize/authorize_delete.php?id=${id}&module=${module_no}`);
                }
            })
        }
    </script>
</body>

</html>