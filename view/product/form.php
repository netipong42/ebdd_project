<?php
require_once('../../server/connect.php');
checkModule(@$_SESSION["user_id"], basename(dirname(__FILE__)), $conn);
$sql = "SELECT * FROM product_type ORDER BY type_name ASC";
$query = $conn->prepare($sql);
$query->execute();
$row = $query->fetchAll();

$sql_supplier = "SELECT * FROM supplier ORDER BY company_name ASC";
$query_supplier = $conn->prepare($sql_supplier);
$query_supplier->execute();
$row_supplier = $query_supplier->fetchAll();

$sql_unit = "SELECT * FROM product_unit ORDER BY unit_name ASC";
$query_unit = $conn->prepare($sql_unit);
$query_unit->execute();
$row_unit = $query_unit->fetchAll();


$sql_house = "SELECT * FROM product_house ORDER BY house_name ASC";
$query_house = $conn->prepare($sql_house);
$query_house->execute();
$row_house = $query_house->fetchAll();

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
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3>เพิ่มสินค้า</h3>
                </div>
                <div class="card-body">
                    <form id='formProduct' method="post" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="insert">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="product_name">ชื่อสินค้า</label>
                                    <input type="text" class="form-control" id="product_name" name="product_name" placeholder="ชื่อสินค้า..." required>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="product_price">สินค้าราคา</label>
                                            <input type="number" class="form-control" id="product_price" name="product_price" placeholder="ราคาสินค้า..." required>
                                        </div>
                                        <div class="col-6">
                                            <label for="product_stock">จำนวนสินค้า</label>
                                            <input type="number" class="form-control" id="product_stock" name="product_stock" placeholder="จำนวนสินค้า..." value="0" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="product_name">ผู้จัดจำหน่าย</label>
                                    <select name="product_supplier" class="form-control" required>
                                        <option value="">---เลือกผู้จัดจำหน่าย---</option>
                                        <?php foreach ($row_supplier as $item) : ?>
                                            <option value="<?php echo $item['id'] ?>"><?php echo $item['company_name'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="product_name">ประเภทสินค้า</label>
                                            <select name="product_type" class="form-control" required>
                                                <option value="">---เลือกประเภทสินค้า---</option>
                                                <?php foreach ($row as $item) : ?>
                                                    <option value="<?php echo $item['id'] ?>"><?php echo $item['type_name'] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="product_name">หน่วยนับสินค้า</label>
                                            <select name="product_unit" class="form-control" required>
                                                <option value="">---เลือกหน่วยนับสินค้า---</option>
                                                <?php foreach ($row_unit as $item) : ?>
                                                    <option value="<?php echo $item['id'] ?>"><?php echo $item['unit_name'] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="product_name">คลังสินค้า</label>
                                            <select name="product_house" class="form-control" required>
                                                <option value="">---เลือกคลังสินค้า---</option>
                                                <?php foreach ($row_house as $item) : ?>
                                                    <option value="<?php echo $item['id'] ?>"><?php echo $item['house_name'] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="img" class="form-label">รูปสินค้า</label>
                                            <div class="custom-file">
                                                <input type="file" onChange="PreviewImage(event)" class="custom-file-input" name="product_img" id="uploadImage" accept="image/*" required>
                                                <label class="custom-file-label" for="uploadImage">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <img src="" alt="" id="uploadPreview" class="mb-3 mx-auto d-block">

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <a href="./index.php" class="btn btn-outline-danger btn-block">ย้อนกลับ</a>
                                        </div>
                                        <div class="col-6">
                                            <input type="submit" class="btn btn-success btn-block" value="บันทึก">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class=" col-6">
                                <div class="form-group">
                                    <label for="product_info">รายละเอียดสินค้า</label>
                                    <textarea id="editor"></textarea>
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
        // preview
        $(":file").on("change", function() {
            let output = document.getElementById('uploadPreview');
            let file = this.files[0];
            let fileType = file["type"];
            let validImageTypes = ["image/gif", "image/jpeg", "image/png", "image/jpg"];
            if ($.inArray(fileType, validImageTypes) < 0) {
                $('#uploadImage').val('');
                $('#uploadPreview').attr('src', '');
                Swal.fire({
                    icon: `warning`,
                    title: `ตรวจสอบ`,
                    text: `รองรับไฟล์ .jpg, .jpg, png เท่านั้น`,
                    showCancelButton: false,
                    confirmButtonText: "ตกลง",
                    confirmButtonColor: "#3085d6",
                });
            } else {
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function() {
                    URL.revokeObjectURL(output.src) // free memory
                }
            }
        });


        // insert
        $('#formProduct').submit(function(e) {
            e.preventDefault();
            let formData = new FormData($("#formProduct")[0]);
            formData.append('product_info', editor.getData());
            $.ajax({
                url: "../../server/product/",
                type: 'POST',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function() {
                    myAlerySuccess();
                    $('#formProduct')[0].reset();
                    $('#uploadPreview').attr('src', '');
                    editor.setData("");
                },
                error: function() {
                    myAleryError();
                }
            })

        })



        // CK
        var editor;

        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(newEditor => {
                editor = newEditor;
            })
            .catch(error => {
                console.error(error);
            });

        // input file
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
</body>

</html>