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
        <div class="col-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3>เพิ่มหน่วยนับสินค้า</h3>
                </div>
                <div class="card-body">
                    <form id="formType">
                        <div class="form-group">
                            <label for="type_name">ประเภทสินค้า</label>
                            <input type="text" class="form-control" id="unit_name" name="unit_name" placeholder="หน่วยนับสินค้า..." required>
                            <input type="hidden" name="action" value="insert" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success btn-block" name="article_toppic" value="ตกลง">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3> ประเภทสินค้า </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="dataT"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แก้ไข หน่วยนับสินค้า</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formTypeEdit">
                        <div class="form-group">
                            <label for="type_name">หน่วยนับสินค้า</label>
                            <input type="text" class="form-control" id="unit_name_edit" name="unit_name" placeholder="หน่วยนับสินค้า..." required>
                            <input type="hidden" id="unit_id_edit" name="unit_id" required>
                            <input type="hidden" name="action" value="update" required>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-6">
                                    <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">ยกเลิก</button>
                                </div>
                                <div class="col-6">
                                    <input type="submit" class="btn btn-success btn-block" name="article_toppic" value="ตกลง">
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
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
                url: '../../server/product_unit/',
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
                    data: 'unit_name',
                    title: "หน่วยนับสินค้า",
                    className: ''
                },
                {
                    data: 'unit_name',
                    title: "แก้ไข",
                    className: ''
                },
            ],
            columnDefs: [{
                targets: 0,
                render: function(data, type, row, meta) {
                    return `${meta.row + 1}`;
                }
            }, {
                targets: [-1],
                render: function(data, type, row, meta) {
                    let id = row['id'];
                    return `
                        <div>
                            <a class="btn btn-warning btn-icon-split btn-sm" data-toggle="modal" data-target="#modal" onclick="edit(${id})">
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
            }],
        });

        $('#formType').submit(function(e) {
            e.preventDefault();
            let data = $(this).serialize();
            $.ajax({
                url: "../../server/product_unit/",
                type: 'POST',
                data: data,
                success: function() {
                    myAlerySuccess();
                    $('#dataT').DataTable().ajax.reload();
                    $('#formType')[0].reset();
                },
                error: function() {
                    myAleryError();
                }
            })

        })
        $('#formTypeEdit').submit(function(e) {
            e.preventDefault();
            let data = $(this).serialize();
            $.ajax({
                url: "../../server/product_unit/",
                type: 'POST',
                data: data,
                success: function() {
                    myAlerySuccess();
                    $('#modal').modal('hide')
                    $('#dataT').DataTable().ajax.reload();
                    $('#formType')[0].reset();
                },
                error: function() {
                    myAleryError();
                }
            })

        })

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
                    $.ajax({
                        url: "../../server/product_unit/",
                        type: 'POST',
                        data: {
                            action: 'delete',
                            id: id
                        },
                        success: function() {
                            $('#dataT').DataTable().ajax.reload();
                            $('#formType')[0].reset();
                        },
                        error: function() {
                            alert('ไม่สามารถเพิ่มข้อมูลได้');
                        }
                    })
                }
            })
        }

        function edit(id) {
            $.ajax({
                url: "../../server/product_unit/",
                type: 'POST',
                data: {
                    action: 'edit',
                    id: id
                },
                success: function(res) {
                    let dataEdit = JSON.parse(res);
                    $('#unit_id_edit').val(dataEdit[0].id);
                    $('#unit_name_edit').val(dataEdit[0].unit_name);
                },
                error: function() {
                    alert('ไม่สามารถเพิ่มข้อมูลได้');
                }
            })

        }
    </script>
</body>

</html>