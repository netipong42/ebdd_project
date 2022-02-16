<?php
require_once("server/connect.php");
if ($_SESSION['admin_id'] == "") {
    Header("Location:./login.php");
}
$sql = "SELECT * FROM member";
$query = $conn->prepare($sql);
$query->execute();
$row = $query->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/img/logo.png" type="image/x-icon">
    <?php require_once("./linkheader.php") ?>
    <title>Banking game Admin</title>
</head>

<body>

    <?php require_once("./navbar.php") ?>
    <!-- content -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-inline">
            <h3 class="m-0 font-weight-bold text-primary">สมาชิก</h3>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ชื่อ</th>
                            <th>สกุล</th>
                            <th>เบอร์</th>
                            <th>พ้อย</th>
                            <th>พ้อย (เงิน)</th>
                            <th>แลกพ้อย</th>
                            <th>ลบ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($row as $key => $item) { ?>
                            <tr>
                                <td><?php echo $key + 1 ?></td>
                                <td><?php echo $item['member_name'] ?></td>
                                <td><?php echo $item['member_last'] ?></td>
                                <td><?php echo $item['member_phone'] ?></td>
                                <td>
                                    <?php echo number_format($item['member_point']) ?>
                                </td>
                                <td>
                                    <?php if ($item['member_point_b'] >= 1000 || $item['member_point_b'] >= 100 || $item['member_point_b'] >= 10) { ?>
                                        <div class="btn btn-success btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-check"></i>
                                            </span>
                                            <span class="text">
                                                <?php echo number_format($item['member_point_b']) ?>
                                            </span>
                                        </div>
                                    <?php  } else { ?>
                                        <div class="btn btn-secondary btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-times"></i>
                                            </span>
                                            <span class="text">
                                                <?php echo number_format($item['member_point_b']) ?>
                                            </span>
                                        </div>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($item['member_point_b'] >= 1000 || $item['member_point_b'] >= 100 || $item['member_point_b'] >= 10) { ?>
                                        <button data-toggle="modal" data-target="#id<?php echo $item['member_id'] ?>" class="btn btn-warning btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="far fa-edit"></i>
                                            </span>
                                            <span class="text">แลกพ้อย</span>
                                        </button>
                                    <?php } ?>
                                </td>
                                <td>
                                    <span onClick="confirmAlert(<?php echo $item['member_id'] ?>)" class="btn btn-danger btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-info"></i>
                                        </span>
                                        <span class="text">ลบ</span>
                                    </span>
                                </td>
                            </tr>

                            <!-- Modal -->
                            <div class="modal fade" id="id<?php echo $item['member_id'] ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">การแลกเงิน</h5>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="server/change.php" method="post">
                                            <div class="modal-body">
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">ชื่อ-สกุล</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" readonly class="form-control-plaintext" value="<?php echo $item['member_name'] . " " . $item['member_last']  ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">พ้อยที่มี</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" readonly class="form-control-plaintext" value="<?php echo number_format($item['member_point_b']) ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">พ้อยที่ต้องการแลก</label>
                                                    <div class="col-sm-8">
                                                        <select name="point_change" class="form-control" required>
                                                            <option value="" selected disabled>--กรุณาเลือกพ้อย--</option>
                                                            <?php if ($item['member_point_b'] >= 10) { ?>
                                                                <option value="10">10</option>
                                                            <?php  } ?>
                                                            <?php if ($item['member_point_b'] >= 100) { ?>
                                                                <option value="100">100</option>
                                                            <?php  } ?>
                                                            <?php if ($item['member_point_b'] >= 1000) { ?>
                                                                <option value="1000">1000</option>
                                                            <?php  } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="member_id" value="<?php echo $item['member_id'] ?>">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="reset" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                                                <button type="submit" class="btn btn-success">ตกลง</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- content -->
    <?php require_once("./footer.php") ?>
    <?php require_once("./linkfooter.php") ?>
    <script>
        function confirmAlert(id) {
            Swal.fire({
                title: 'ยืนยันการลบ',
                text: `ต้องการลบข้อมูลหรือไม่`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1CC88A',
                cancelButtonColor: '#E74A3B',
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.assign(`./server/member_del.php?id=${id}`);
                }
            })
        }
    </script>
    <?php
    if (@$_SESSION['alert'] == "success") {
        echo '<script> myAlery() </script>';
        unset($_SESSION['alert']);
    }
    if (@$_SESSION['alert'] == "error") {
        echo '<script> myAleryError() </script>';
        unset($_SESSION['alert']);
    }
    ?>
</body>

</html>