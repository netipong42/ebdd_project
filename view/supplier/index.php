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
            <a href="./form.php" class="btn btn-success">เพิ่มผู้จัดจำหน่าย</a>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3> ผู้จัดจำหน่าย </h3>
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
                url: '../../server/supplier/',
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
                    data: 'company_name',
                    title: "ชื่อบริษัท",
                    className: ''
                },
                {
                    data: 'id',
                    title: "ชื่อ-สกุล",
                    className: ''
                },
                {
                    data: 'mail',
                    title: "เมล",
                    className: ''
                },
                {
                    data: 'phone',
                    title: "เบอร์โทร",
                    className: ''
                },
                {
                    data: 'id',
                    title: "ที่อยู่",
                    className: ''
                },
                {
                    data: 'id',
                    title: "#",
                    className: ''
                },
            ],
            columnDefs: [{
                    targets: 2,
                    render: function(dat, type, row, meta) {
                        return `
                        ${row.title_name}${row.name} ${row.last}`
                    }
                },
                {
                    targets: 5,
                    render: function(data, type, row, meta) {
                        return `${row.address} ${row.TambonName} ${row.DistrictName} ${row.ProvinceThai} ${row.zipcode}`
                    }
                },
                {
                    targets: 6,
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
                        url: "../../server/supplier/",
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