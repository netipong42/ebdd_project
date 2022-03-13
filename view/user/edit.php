<?php
require_once('../../server/connect.php');


$data = ['id' => $_GET['id']];
$sql = "SELECT * FROM users WHERE id = :id";
$query = $conn->prepare($sql);
$query->execute($data);
$row = $query->fetch();

$sql_title = "SELECT * FROM title_name ORDER BY title_name ASC";
$query_title = $conn->prepare($sql_title);
$query_title->execute();
$row_title = $query_title->fetchAll();

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
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                        <div class="row">
                            <div class="col-6 mx-auto">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="user_login">Username</label>
                                            <input type="text" class="form-control" id="user_login" name="user_login" value="<?php echo $row['user_login'] ?>" placeholder="Username..." required readonly>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="user_pass">Password</label>
                                            <input type="password" class="form-control" id="user_pass" name="user_pass" value="<?php echo $row['user_pass'] ?>" placeholder="Password..." required readonly>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="user_email">E-mail</label>
                                            <input type="email" class="form-control" id="user_email" name="user_email" value="<?php echo $row['user_email'] ?>" placeholder="E-mail..." required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="user_price">คำนำหน้า</label>
                                            <select class="form-control" id="user_title" name="user_title" required>
                                                <option value="">--กรุณาเลือก--</option>
                                                <?php foreach ($row_title as $item) :   ?>
                                                    <option value="<?php echo $item['id']  ?>" <?php echo $item['id'] == $row['user_title'] ? "selected" : "" ?>> <?php echo $item['title_name']  ?>
                                                    </option>
                                                <?php endforeach  ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="user_name">ชื่อ</label>
                                            <input type="text" class="form-control" id="user_name" name="user_name" value="<?php echo $row['user_name'] ?>" placeholder="ชื่อ..." required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="user_last">นามสกุล</label>
                                            <input type="text" class="form-control" id="user_last" name="user_last" value="<?php echo $row['user_last'] ?>" placeholder="นามสกุล..." required>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="img" class="form-label">รูปสมาชิก</label>
                                            <div class="custom-file">
                                                <input type="file" onChange="PreviewImage(event)" class="custom-file-input" name="user_img" id="uploadImage" accept="image/*">
                                                <label class="custom-file-label" for="uploadImage">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <img src="../../server/image/<?php echo $row['user_img'] ?>" alt="" id="uploadPreview" class="mb-3 mx-auto d-block">

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
            $.ajax({
                url: "../../server/user/",
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