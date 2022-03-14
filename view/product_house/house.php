<?php
// House
require_once('../../server/connect.php');

checkModule(@$_SESSION["user_id"], basename(dirname(__FILE__)), $conn);
$data = ['id' => $_GET['id']];
$slqHouse = "SELECT * FROM product_house AS h WHERE id=:id";
$queryHouse = $conn->prepare($slqHouse);
$queryHouse->execute($data);
$rowHouseName = $queryHouse->fetch(PDO::FETCH_ASSOC);
?>
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
                    <h3> คลังสินค้า <?php echo $rowHouseName['house_name'] ?> </h3>
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
        let idHouse = <?php echo $_GET['id'] ?>;
        console.log(idHouse);
        $('#dataT').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,

            ajax: {
                url: '../../server/product/',
                data: function() {
                    return {
                        action: 'showProductHouse',
                        idHouse: idHouse
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
                    data: 'product_name',
                    title: "รูป",
                    className: ''
                },
                {
                    data: 'product_name',
                    title: "ชื่อสินค้า",
                    className: ''
                },
                {
                    data: 'product_price',
                    title: "ราคาสินค้า",
                    className: ''
                },
                {
                    data: 'product_stock',
                    title: "จำนวนสินค้าคงคลัง",
                    className: ''
                },
                {
                    data: 'unit_name',
                    title: "จำนวนนับ",
                    className: ''
                },
                {
                    data: 'type_name',
                    title: "ประเภทสินค้า",
                    className: ''
                },
                {
                    data: 'house_name',
                    title: "คลังสินค้า",
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
                        let img = row['product_img'];
                        return `
                            <div>
                                <img src="../../server/image/${img}" class="product_img_table">
                            </div>
                        `;
                    }
                },
                {
                    targets: 3,
                    render: $.fn.dataTable.render.number(',', 1, '')
                },
                {
                    targets: 4,
                    render: $.fn.dataTable.render.number(',', 1, '')
                },
                {
                    targets: 5,
                    render: function(data, type, row, meta) {
                        let stock = row['product_stock'];
                        if (stock <= 0) {
                            return `
                             ${stock}
                             <sup class="badge badge-danger">สินค้าหมด</sup>
                            `;
                        } else if (stock <= 20) {
                            return `
                             ${stock}
                             <sup class="badge badge-warning">สินค้าใกล้หมด</sup>
                            `;
                        } else {
                            return `
                             ${stock}
                            `;
                        }
                    }
                    // render: $.fn.dataTable.render.number(',', 1, '')
                },

            ],
        });
    </script>
</body>

</html>