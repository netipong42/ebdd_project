<?php require_once("../../server/connect.php") ?>
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

        <div class="col-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3> ใบสั่งซื้อ (PO) </h3>
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
                url: '../../server/po/',
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
                    data: 'docCreated',
                    title: "วันที่เอกสาร",
                    className: ''
                },
                {
                    data: 'document_no',
                    title: "เลขที่เอกสาร",
                    className: ''
                },
                {
                    data: 'company_name',
                    title: "ชื่อผู้ซื้อ",
                    className: ''
                },
                {
                    data: 'totalFanal',
                    title: "จำนวนเงิน",
                    className: 'text-right'
                },
                {
                    data: 'id',
                    title: "ตรวจสอบ",
                    className: 'text-right'
                },
                {
                    data: 'id',
                    title: "สถานะ",
                    className: 'text-right'
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
                    targets: 4,
                    render: $.fn.dataTable.render.number(',', '.', 2, '')
                },
                {
                    targets: 5,
                    render: function(data, type, row, meta) {
                        let id = row['id'];
                        let status = row['status'];
                        if (status == 3) {
                            return `
                            <div>
                                    <a href="./info.php?id=${id}" class="btn btn-success btn-icon-split btn-sm" >
                                    <span class="icon text-white-50">
                                        <i class="far fa-edit"></i>
                                    </span>
                                    <span class="text">อนุมัติ</span>
                                </a>
                                <a href="./po_pdf.php?id=${id}" target="_blank" class="btn btn-info btn-icon-split btn-sm">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-info"></i>
                                    </span>
                                    <span class="text">PDF</span>
                                </a>
                            </div>
                            `;
                        } else {
                            return `
                            <div>
                                <a href="./po_pdf.php?id=${id}" target="_blank" class="btn btn-info btn-icon-split btn-sm">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-info"></i>
                                    </span>
                                    <span class="text">PDF</span>
                                </a>
                            </div>
                            `;
                        }

                    }
                },
                {
                    targets: 6,
                    render: function(data, type, row, meta) {
                        let status = row['status'];
                        let text = '';
                        let color = '';
                        if (status == 1) {
                            text = 'รอการตรวจสอบ';
                            color = 'warning';
                        }
                        if (status == 2) {
                            text = 'ไม่ผ่าน';
                            color = 'danger';
                        }
                        if (status == 3) {
                            text = 'รออนุมัติของ';
                            color = 'warning';
                        }
                        if (status == 4) {
                            text = 'รับของแล้ว';
                            color = 'success';
                        }
                        if (status == 5) {
                            text = 'ไม่สำเร็จ';
                            color = 'danger';
                        }
                        return `
                            <div>
                            <span class="badge badge-${color} p-2">${text}</span>
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
                        url: "../../server/po/",
                        type: 'POST',
                        data: {
                            action: 'delete',
                            id: id
                        },
                        success: function() {
                            $('#dataT').DataTable().ajax.reload();
                        },
                        error: function() {}
                    })
                }
            })
        }
    </script>
    <?php
    if (@$_SESSION["myalert"] == "success") {
        echo "<script> myAlerySuccess() </script>";
        unset($_SESSION["myalert"]);
    }
    ?>
</body>

</html>