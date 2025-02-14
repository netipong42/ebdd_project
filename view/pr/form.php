<?php
require_once('../../server/connect.php');
checkModule(@$_SESSION["user_id"], basename(dirname(__FILE__)), $conn);
$sql = "SELECT * FROM product_type ORDER BY type_name ASC";
$query = $conn->prepare($sql);
$query->execute();
$row = $query->fetchAll();

$sql_supplier = "SELECT  
                s.*,
                t.title_name 
                FROM supplier AS s
                INNER JOIN title_name AS t 
                ON s.title = t.id
                ORDER BY s.company_name ASC";
$query_supplier = $conn->prepare($sql_supplier);
$query_supplier->execute();
$row_supplier = $query_supplier->fetchAll();


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
    <div class="row p-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3>สร้างใบขอซื้อ (PR)</h3>
                </div>
                <div class="card-body">

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active text-dark" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
                        </li>
                    </ul>
                    <!-- info -->
                    <form action="../../server/pr/pr_insert.php" method="post" id="formInsert" enctype="multipart/form-data">

                        <div class="tab-content pt-4" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-4 col-form-label font-pr-form">รหัสผู้ขาย</label>
                                            <div class="col-sm-8">
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" name="supplier_code" id="supplier_code" required readonly>
                                                    <div class="input-group-append pointer" data-toggle="modal" data-target="#exampleModal">
                                                        <span class="input-group-text" id="basic-addon2"><i class="fas fa-search"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-4 col-form-label font-pr-form">เลขที่เอกสาร</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="document_no" id="document_no" required readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-4 col-form-label font-pr-form">วันที่เอกสาร</label>
                                            <div class="col-sm-8">
                                                <input type="date" class="form-control" id="inputPassword" name="docCreated" value="<?php echo date("Y-m-d"); ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-4 col-form-label font-pr-form">ชื่อผู้ขาย</label>
                                            <div class="col-sm-8">
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" id="company_name" required readonly>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-4 col-form-label font-pr-form">ต้องการภายใน (วัน)</label>
                                            <div class="col-sm-8">
                                                <input type="date" class="form-control" id="inputPassword" name="docWant" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-4 col-form-label font-pr-form">วันที่สิ้นสุด</label>
                                            <div class="col-sm-8">
                                                <input type="date" class="form-control" id="inputPassword" name="docExe" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-4 col-form-label font-pr-form">ผู้ติดต่อ</label>
                                            <div class="col-sm-8">
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" id="name" required readonly>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-4 col-form-label font-pr-form">เครดิต (วัน)</label>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="inputPassword" name="credit" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-4 col-form-label font-pr-form">กำหนดส่งของ</label>
                                            <div class="col-sm-8">
                                                <input type="date" class="form-control" id="inputPassword" name="sendProduct" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <!-- product -->
                                <div class="row">
                                    <div class="col-4">
                                        <label for="inputPassword" class="col-sm-4 col-form-label  font-pr-form-label">รายการสินค้า</label>
                                    </div>
                                    <div class="col-8 text-right">
                                        <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#modalproduct">เลือกสินค้า</button>
                                    </div>
                                </div>
                                <table class="table table-bordered mt-3">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-nowrap">#</th>
                                            <th scope="col" class="text-nowrap">รูป</th>
                                            <th scope="col" class="text-nowrap">รหัสสินค้า</th>
                                            <th scope="col" colspan="2" class="text-nowrap">ชื่อสินค้า</th>
                                            <th scope="col" class="text-nowrap">หน่วยนับ</th>
                                            <th scope="col" class="text-nowrap">ราคา</th>
                                            <th scope="col" class="text-nowrap">จำนวน</th>
                                            <th scope="col" class="text-nowrap">ส่วนลด %</th>
                                            <th scope="col" class="text-nowrap">จำนวนเงิน</th>
                                        </tr>
                                    </thead>
                                    <tbody id="show_prodcut_select">

                                    </tbody>
                                    <tfoot>
                                        <tr id="warning_product">
                                            <td colspan="9" class="text-danger text-center">
                                                *** กรุณากดปุ่ม "เลือกสินค้า" เพื่อเลือกอย่างน้อย 1 รายการ ***
                                            </td>
                                        </tr>
                                        <tr>

                                            <input type="text" class="input-hidden" id="totalMoney" name="totalMoney">
                                            <input type="text" class="input-hidden" id="totalDiscount" name="totalDiscount">
                                            <input type="text" class="input-hidden" id="totalVat" name="totalVat">
                                            <input type="text" class="input-hidden" id="totalFanal" name="totalFanal">

                                            <td colspan="5" class="text-right">รวมเงิน</td>
                                            <td colspan="5" class="text-right" id="totalAll">
                                                0.00
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-right">ส่วนลดการค้า</td>
                                            <td colspan="4" class="text-right">
                                                <div class="d-flex align-items-center">
                                                    <input type="number" placeholder="0" min="0" name="discountPer" id="totalDiscountPer" oninput='getValue(this)' class="form-control col-2 ml-auto text-right">
                                                    <span class="ml-3">%</span>
                                                </div>
                                            </td>
                                            <td colspan="1" class="text-right" id="totalDiscountNum">0.00</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-right">เงินก่อนหักภาษี</td>
                                            <td colspan="5" class="text-right" id="beforeTax">0.00</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-right">ภาษีมูลค่าเพิ่ม</td>
                                            <td colspan="3" class="text-right">
                                                <select name="Tex" id="selectTax" class="form-control">
                                                    <option value="1" selected>PO-EX7</option>
                                                    <option value="2">PO-NO</option>
                                                </select>
                                            </td>
                                            <td colspan="1" class="text-right">7%</td>
                                            <td colspan="1" class="text-right" id="tax7">0.00</td>
                                        </tr>
                                        <tr>
                                            <td colspan=" 5" class="text-right">จำนวนเงินทั้งสิน</td>
                                            <td colspan="5" class="text-right" id="finalTotal">0.00</td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <!-- product -->
                                <div class="text-right">
                                    <button type="submit" class="btn btn-success">Save</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal_supplier -->
    <div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl  modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">รายการบริษัทผู้ขาย</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-body table-responsive">
                                    <table id="table" class="table table-bordered  nowrap table-hover pointer">
                                        <thead>
                                            <tr>
                                                <th class="text-center ">เลือก</th>
                                                <th class="text-center ">ลำดับ</th>
                                                <th class="text-center ">รหัสผู้ขาย</th>
                                                <th class="text-center ">บริษัท</th>
                                                <th class="text-center ">ชื่อบริษัทผู้ขาย</th>
                                                <th class="text-center ">เมล</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($row_supplier as $key => $item) {  ?>

                                                <tr>
                                                    <td>
                                                        <div class="d-flex justify-content-center align-items-center">
                                                            <input type="radio" id="sp<?php echo $item["id"]  ?>" name="supplier_no" value="<?php echo $item["id"]  ?>">
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $key + 1  ?>
                                                    </td>
                                                    <td> <?php echo $item["id"]  ?></td>
                                                    <td> <?php echo $item["company_name"]  ?></td>
                                                    <td> <?php echo $item["title_name"] . $item["name"] . " " .  $item["last"] ?></td>
                                                    <td> <?php echo $item["mail"] ?></td>


                                                </tr>
                                            <?php } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success " data-dismiss="modal" id="select_supplier">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal_supplier -->


    <!-- Modal_product -->
    <div class="modal fade" id="modalproduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl  modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เลือกรายการสินค้า</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="tableinventory" class="table table-bordered display nowrap table-hover pointer" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">เลือก</th>
                                <th class="text-center">ลำดับ</th>
                                <th class="text-center">รูปภาพสินค้า</th>
                                <th class="text-center">รหัสสินค้า</th>
                                <th class="text-center">ชื่อสินค้า</th>
                                <th class="text-center">ราคาสินค้า</th>
                                <th class="text-center">ประเภทสินค้า</th>
                                <th class="text-center">บริษัทผู้ขาย</th>
                                <th class="text-center">จำนวนสินค้า</th>
                                <th class="text-center">หน่วยนับ</th>
                            </tr>
                        </thead>
                        <tbody id="show_product">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="select_inventory" data-dismiss="modal">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- content -->
    <?php require_once("../template/footer.php") ?>
    <?php require_once("../template/linkfooter.php") ?>
    <script>
        $(function() {
            $('#table').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                // "responsive": true,
                // "scrollX": true,
            });
        });

        $(function() {
            $('#tableinventory').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                // "responsive": true,
                // "scrollX": true,
                "fixedHeader": true
            });
        });

        // เลือกบริษัท radio
        $('#table tr').click(function() {
            $(this).find('td input:radio').prop('checked', true);
        })

        // เลือกสินค้า checkbox
        $('#tableinventory tbody').on('click', 'tr', function() {
            $(this).find('td input:checkbox').prop('checked', !$(this).find('td input:checkbox').prop("checked"));
        })
        // เลือกบริษัท
        $('#select_supplier').click(function() {
            let supplier_no = $('input[name=supplier_no]:checked', '#table').val()
            $.ajax({
                url: "../../server/supplier/supplier_select.php",
                type: 'POST',
                dataType: 'json',
                data: {
                    supplier_no: supplier_no
                },
                success: function(data) {
                    // supplier
                    let name = `${data.supplier.title_name}${data.supplier.name} ${data.supplier.last}`;
                    const formatYmd = date => date.toISOString().slice(0, 10);
                    const formatTime = time => time.toTimeString().slice(0, 8);
                    let myDate = new Date();
                    let ymd = formatYmd(myDate).split("-").join('');
                    let time = formatTime(myDate).split(":").join('');
                    let document_no = `PO-${data.supplier.id}-${ymd}${time}`;
                    $('#supplier_code').val(data.supplier.id)
                    $('#company_name').val(data.supplier.company_name)
                    $('#name').val(name)
                    $('#document_no').val(document_no)

                    // tfoot
                    $('#totalAll').html(`0.00`);
                    $('#totalAll').html(`0.00`);
                    $('#totalDiscountNum').html(`0.00`);
                    $("#beforeTax").html(`0.00`);
                    $("#tax7").html(`0.00`);
                    $("#finalTotal").html(`0.00`);
                    $("#totalDiscountPer").val(0);

                    // hidden input 
                    $("#totalMoney").val(0);
                    $("#totalDiscount").val(0);
                    $("#totalVat").val(0);
                    $("#totalFanal").val(0);

                    // Delete product old
                    $("#show_prodcut_select").children().remove();
                    // inventory
                    let data_inventory = data.inventory
                    let tableinventory = $('#tableinventory').DataTable();

                    var rows = tableinventory
                        .rows()
                        .remove()
                        .draw();

                    data_inventory.forEach((item, index) => {
                        tableinventory.row.add([
                            `  
                            <div class="d-flex justify-content-center align-items-center">
                                <input type="checkbox" id="sp${item.id}" name="inventory_no" value="${item.id}">
                            </div>
                            `,
                            index + 1,
                            `  
                            <div>
                                <img src='../../server/image/${item.product_img}' width="100">
                            </div>
                            `,
                            item.id,
                            item.product_name,
                            `
                            <div>
                               ${new Intl.NumberFormat().format(item.product_price) }
                            </div>
                            `,
                            item.type_name,
                            item.company_name,
                            item.product_stock,
                            item.unit_name,

                        ]).draw(false);
                    });

                },
                error: function() {}
            })
        })


        // เลือกสินค้า
        var lenData = 0;
        $("#select_inventory").click(function() {
            let list_product = [];
            $("input:checkbox[name=inventory_no]:checked").each(function() {
                list_product.push($(this).val());
            });
            $.ajax({
                url: "../../server/pr/pr_select.php",
                type: 'POST',
                data: {
                    product_id: list_product
                },
                dataType: 'json',
                success: function(data) {
                    lenData = data.length;
                    $("#warning_product").remove();
                    $("#show_prodcut_select").children().remove();

                    // tfoot
                    $('#totalAll').html(`0.00`);
                    $('#totalAll').html(`0.00`);
                    $('#totalDiscountNum').html(`0.00`);
                    $("#beforeTax").html(`0.00`);
                    $("#tax7").html(`0.00`);
                    $("#finalTotal").html(`0.00`);
                    $("#totalDiscountPer").val(0);

                    // hidden input 
                    $("#totalMoney").val(0);
                    $("#totalDiscount").val(0);
                    $("#totalVat").val(0);
                    $("#totalFanal").val(0);

                    data.forEach((item, index) => {
                        $("#show_prodcut_select").append(`
                        <tr>
                            <td>${index+1}</td>
                            <td>
                                <div>
                                    <img src='../../server/image/${item.product_img}' width="64">
                                </div>
                            </td>
                            <td>
                            ${item.id}
                             <input type="hidden" name="product_code[]" value="${item.id}" required>
                            </td>
                            <td colspan="2">${item.product_name}</td>
                            <td>${item.unit_name}</td>
                            <td>
                                <input type="number" class="form-control text-right price" oninput='getValue(this)' name="price[]" value="${item.product_price}" required>
                            </td>
                            <td>
                                <input type="number" class="form-control text-right qty" oninput='getValue(this)' name="qty[]" value="0" required>
                            </td>
                              <td>
                                <input type="number" class="form-control text-right discount" oninput='getValue(this)' name="discount[]"  value="0" required>
                            </td>
                            <td><input type="number" class="form-control text-right total"  name="total[]" value="0" readonly> </td>
                        </tr>
                        `);
                    });
                    getValue()
                },
                error: function() {}
            })
        });


        // Tex
        var statusTax = true;
        $("#selectTax").change(function() {
            if ($(this).val() == 1) {
                statusTax = true
            } else {
                statusTax = false
            }
            getValue($(this))
        });


        function getValue(e) {

            if (e.value < 0) {
                myAleryError();
                e.value = 0;
            } else {
                // calulate total 
                for (let index = 0; index < lenData; index++) {
                    let vPrice = parseFloat($('input.price').eq(index).val());
                    let vQty = parseFloat($('input.qty').eq(index).val());
                    let vDiscount = parseFloat($('input.discount').eq(index).val());
                    $('input.total').eq(index).val((vPrice * vQty) - ((vPrice * vQty) * vDiscount / 100));
                }

                // calulate total all
                let totalAll = 0;
                $('input.total').each(function() {
                    totalAll += parseFloat($(this).val());
                });
                $('#totalAll').html(new Intl.NumberFormat().format(totalAll.toFixed(2)) ? new Intl.NumberFormat().format(totalAll.toFixed(2)) : 0);
                $("#totalMoney").val(parseFloat(totalAll.toFixed(2)));
                // ส่วนลดการค้า
                let totalDiscountPer = 0;
                let inputDiscountPer = parseFloat($("#totalDiscountPer").val());
                totalDiscountPer = parseFloat((totalAll * inputDiscountPer) / 100) ? parseFloat((totalAll * inputDiscountPer) / 100) : 0;
                $('#totalDiscountNum').html(new Intl.NumberFormat().format(totalDiscountPer.toFixed(2)) ? new Intl.NumberFormat().format(totalDiscountPer.toFixed(2)) : 0);
                $("#totalDiscount").val(parseFloat(totalDiscountPer.toFixed(2)));

                // เงินก่อนหักภาษี
                let beforeTax = totalAll - totalDiscountPer;
                $("#beforeTax").html(new Intl.NumberFormat().format(beforeTax.toFixed(2)) ? new Intl.NumberFormat().format(beforeTax.toFixed(2)) : 0);

                // ภาษีมูลค่าเพิ่ม
                let tax7;
                if (statusTax) {
                    tax7 = parseFloat((beforeTax * 7) / 100) ? parseFloat((beforeTax * 7) / 100) : 0;
                    $("#tax7").html(new Intl.NumberFormat().format(tax7.toFixed(2)) ? new Intl.NumberFormat().format(tax7.toFixed(2)) : 0);
                } else {
                    tax7 = 0;
                    $("#tax7").html(0);
                }
                $("#totalVat").val(parseFloat(tax7.toFixed(2)));

                // จำนวนเงินทั้งสิน finalTotal
                let finalTotal = parseFloat(beforeTax + tax7);
                $("#finalTotal").html(new Intl.NumberFormat().format(finalTotal.toFixed(2)) ? new Intl.NumberFormat().format(finalTotal.toFixed(2)) : 0);
                $("#totalFanal").val(parseFloat(finalTotal.toFixed(2)));

            }
        }
    </script>
</body>

</html>