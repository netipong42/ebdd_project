<?php
require_once('../../server/connect.php');

$data = [
    'id' => $_GET['id']
];
$sql = "SELECT * FROM supplier WHERE id = :id";
$query = $conn->prepare($sql);
$query->execute($data);
$row = $query->fetch();



$sql_title = "SELECT * FROM title_name ORDER BY title_name ASC";
$query_title = $conn->prepare($sql_title);
$query_title->execute();
$row_title = $query_title->fetchAll();

$sql_province = "SELECT * FROM address_province  ORDER BY ProvinceThai ASC";
$query_province = $conn->prepare($sql_province);
$query_province->execute();
$row_province = $query_province->fetchAll();

$data_district = [
    "ProvinceID" => $row['province']
];

$sql_district = "SELECT * FROM address_district WHERE ProvinceID = :ProvinceID ORDER BY DistrictName ASC";
$query_district = $conn->prepare($sql_district);
$query_district->execute($data_district);
$row_district = $query_district->fetchAll();

$data_tambon = [
    "DistrictID" => $row['district']
];

$sql_tambon = "SELECT * FROM address_tambon WHERE DistrictID = :DistrictID ORDER BY TambonName ASC";
$query_tambon = $conn->prepare($sql_tambon);
$query_tambon->execute($data_tambon);
$row_tambon = $query_tambon->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../assets/img/logo.png" type="image/x-icon">
    <?php require_once("../template/linkheader.php") ?>
    <script src="https://cdn.ckeditor.com/ckeditor5/32.0.0/classic/ckeditor.js"></script>

    <title>Admin</title>
</head>

<body>

    <?php require_once("../template/navbar.php") ?>
    <!-- content -->
    <div class="row">
        <div class="col-8 mx-auto">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h3>แก้ไขผู้จัดจำหน่าย</h3>
                </div>
                <div class="card-body">
                    <form id='formSupplier' method="post" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="update">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="product_name">ชื่อบริษัทผู้จัดจำหน่าย</label>
                                    <input type="text" class="form-control" id="product_name" name="company_name" placeholder="ชื่อบริษัทผู้จัดจำหน่าย..." value="<?php echo $row['company_name'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="product_name">เลขประจำตัวผู้เสียภาษี</label>
                                    <input type="text" class="form-control" id="product_name" name="tax" placeholder="เลขประจำตัวผู้เสียภาษี..." value="<?php echo $row['tax'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-4">
                                            <label for="product_price">คำนำหน้า</label>
                                            <select class="form-control" id="product_title" name="title" required>
                                                <option value="">--กรุณาเลือก--</option>
                                                <?php foreach ($row_title as $item) :   ?>
                                                    <option value="<?php echo $item['id']  ?>" <?php echo $item['id'] == $row['title'] ? "selected" : ""  ?>> <?php echo $item['title_name']  ?>
                                                    </option>
                                                <?php endforeach  ?>
                                            </select>
                                        </div>
                                        <div class="col-4">
                                            <label for="product_stock">ชื่อ</label>
                                            <input type="text" class="form-control" name="name" placeholder="ชื่อ..." value="<?php echo $row['name'] ?>" required>
                                        </div>
                                        <div class="col-4">
                                            <label for="product_stock">นามสกุล</label>
                                            <input type="text" class="form-control" name="last" placeholder="นามสกุล..." value="<?php echo $row['last'] ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="product_name">อีเมล</label>
                                            <input type="email" name="mail" class="form-control" placeholder="E-mail..." value="<?php echo $row['mail'] ?>" required>
                                        </div>

                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="product_name">เบอร์</label>
                                            <input type="tel" name="phone" class="form-control" placeholder="เบอร์..." value="<?php echo $row['phone'] ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="product_name">รายละเอียดที่อยู่</label>
                                            <input type="text" name="address" class="form-control" placeholder="รายละเอียดที่อยู่..." value="<?php echo $row['address'] ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="product_price">จังหวัด</label>
                                            <select class="form-control" name="province" id="province" required>
                                                <option value="">--กรุณาเลือก--</option>
                                                <?php foreach ($row_province as $item) :   ?>
                                                    <option value="<?php echo $item['ProvinceID']  ?>" <?php echo $item['ProvinceID'] == $row['province'] ? "selected" : ""  ?>>
                                                        <?php echo $item['ProvinceThai']  ?>
                                                    </option>
                                                <?php endforeach  ?>
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <label for="product_price">อำเภอ</label>
                                            <select class="form-control" id="district" name="district" required>
                                                <option value="">--กรุณาเลือก--</option>
                                                <?php foreach ($row_district as $item) :   ?>
                                                    <option value="<?php echo $item['DistrictID']  ?>" <?php echo $item['DistrictID'] == $row['district'] ? "selected" : ""  ?>>
                                                        <?php echo $item['DistrictName']  ?>
                                                    </option>
                                                <?php endforeach  ?>
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <label for="product_price">ตำบล</label>
                                            <select class="form-control" id="tambon" name="tambon" required>
                                                <option value="">--กรุณาเลือก--</option>
                                                <?php foreach ($row_tambon as $item) :   ?>
                                                    <option value="<?php echo $item['TambonID']  ?>" <?php echo $item['TambonID'] == $row['tambon'] ? "selected" : ""  ?>>
                                                        <?php echo $item['TambonName']  ?>
                                                    </option>
                                                <?php endforeach  ?>
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <label for="product_name">รหัสไปรษณีย์</label>
                                            <input type="text" id="zipcode" name="zipcode" class="form-control" value="<?php echo $row['zipcode'] ?>" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <a href="./index.php" class="btn btn-outline-danger btn-block">ย้อนกลับ</a>
                                        </div>
                                        <div class="col-6">
                                            <input type="hidden" class="form-control" name="id" value="<?php echo $row['id'] ?>" required>
                                            <input type="submit" class="btn btn-success btn-block" value="บันทึก">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- content -->
    <?php require_once("../template/footer.php") ?>
    <?php require_once("../template/linkfooter.php") ?>
    <script>
        // insert
        $('#formSupplier').submit(function(e) {
            e.preventDefault();
            let formData = new FormData($("#formSupplier")[0]);
            $.ajax({
                url: "../../server/supplier/",
                type: 'POST',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function() {
                    myAlerySuccess();
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                },
                error: function() {
                    myAleryError();
                }
            })

        })


        $("#province").change(function() {
            let ProvinceID = $(this).val();
            $.ajax({
                url: "../../server/address/select_address.php",
                type: 'POST',
                dataType: 'json',
                data: {
                    ProvinceID: ProvinceID,
                    action: "district"
                },
                success: function(data) {
                    $("#district").children().remove();
                    $("#tambon").children().remove();
                    $("#district").append(` <option value="">--กรุณาเลือก--</option>`);
                    $("#tambon").append(` <option value="">--กรุณาเลือก--</option>`);
                    $("#zipcode").val("");
                    data.forEach((item) => {
                        $("#district").append(`<option value="${item.DistrictID}">${item.DistrictName}</option>`);
                    });
                },
                error: function() {}
            })
        });

        $("#district").change(function() {
            let DistrictID = $(this).val();
            $.ajax({
                url: "../../server/address/select_address.php",
                type: 'POST',
                dataType: 'json',
                data: {
                    DistrictID: DistrictID,
                    action: "tambon"
                },
                success: function(data) {
                    $("#tambon").children().remove();
                    $("#tambon").append(` <option value="">--กรุณาเลือก--</option>`);
                    $("#zipcode").val("");
                    data.forEach((item) => {
                        $("#tambon").append(`<option value="${item.TambonID}">${item.TambonName}</option>`);
                    });
                },
                error: function() {}
            })
        });

        $("#tambon").change(function() {
            let TambonID = $(this).val();
            $.ajax({
                url: "../../server/address/select_address.php",
                type: 'POST',
                dataType: 'json',
                data: {
                    TambonID: TambonID,
                    action: "zipcode"
                },
                success: function(data) {
                    $("#zipcode").val(data.zipcode);

                },
                error: function() {}
            })
        });


        // input file
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
</body>

</html>