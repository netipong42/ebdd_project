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
        <div class="col-12 my-3">
            <a href="./form.php" class="btn btn-success">เพิ่มสมาชิก</a>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3> สมาชิก </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="dataT"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- content -->
    <?php require_once("../template/footer.php") ?>
    <?php require_once("../template/linkfooter.php") ?>
    <script>
        $('#dataT').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,

            ajax: {
                url: '../../server/user/',
                data: function() {
                    return {
                        action: 'show'
                    };
                },
                dataSrc: '',
                method: 'POST'
            },
            columns: [{
                    data: 'id',
                    title: "#",
                    className: ''
                },
                {
                    data: 'user_name',
                    title: "รูป",
                    className: ''
                },
                {
                    data: 'user_name',
                    title: "ชื่อสมาชิก",
                    className: ''
                },
                {
                    data: 'user_email',
                    title: "เมล",
                    className: ''
                },
                {
                    data: 'user_status',
                    title: "สถานะ",
                    className: ''
                },
                {
                    data: 'id',
                    title: "แก้ไข",
                    className: ''
                },
            ],
            columnDefs: [

                {
                    targets: 0,
                    render: function(data, type, row, meta) {
                        return `${meta.row + 1}`;
                    }
                },

                {
                    targets: 1,
                    render: function(data, type, row, meta) {
                        let img = row['user_img'];
                        return `
                            <div>
                                <img src="../../server/image/${img}" class="product_img_table">
                            </div>
                        `;
                    }
                },
                {
                    targets: 2,
                    render: function(data, type, row, meta) {
                        let title = row['title_name'];
                        let name = row['user_name'];
                        let last = row['user_last'];
                        return `
                            <div>
                               ${title}${name} ${last}
                            </div>
                        `;
                    }
                },
                {
                    targets: 5,
                    render: function(data, type, row, meta) {
                        let id = row['id'];
                        return `
                           <div>
                              <a href="./edit.php?id=${id}" class="btn btn-warning btn-icon-split btn-sm" >
                                <span class="icon text-white-50">
                                    <i class="far fa-edit"></i>
                                </span>
                                <span class="text">แก้ไข</span>
                            </a>
                              <a class="btn btn-danger btn-icon-split btn-sm" onclick="confirmDelete(${id})">
                                <span class="icon text-white-50">
                                    <i class="fas fa-info"></i>
                                </span>
                                <span class="text">ลบ</span>
                            </a>
                      </div>
                        `;
                    }
                },
            ],
        });

        function confirmDelete(id) {
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
                    console.log(id);
                    $.ajax({
                        url: "../../server/user/",
                        type: 'POST',
                        data: {
                            action: 'delete',
                            id: id
                        },
                        success: function() {
                            $('#dataT').DataTable().ajax.reload();
                        },
                        error: function() {
                            alert('ไม่สามารถเพิ่มข้อมูลได้');
                        }
                    })
                }
            })
        }
    </script>
</body>

</html>