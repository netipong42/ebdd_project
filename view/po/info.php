<?php
require_once('../../server/connect.php');
checkModule(@$_SESSION["user_id"], basename(dirname(__FILE__)), $conn);
$data = [
    'id' => $_GET['id'],
];

$sql_purchase = "SELECT 
                p.*,
                s.company_name,
                t.title_name,
                s.name,
                s.last
                FROM purchase AS p
                INNER JOIN supplier AS s
                ON p.supplier_code = s.id
                INNER JOIN title_name AS t
                ON s.title = t.id
                WHERE p.id = :id";
$query_purchase = $conn->prepare($sql_purchase);
$query_purchase->execute($data);
$row_purchase = $query_purchase->fetch(PDO::FETCH_ASSOC);
$sql_detail = "SELECT
                dt.*,
                p.product_name,
                p.product_img,
                u.unit_name,
                s.company_name,
                p.id AS product_id
                FROM purchase_detail AS dt
                INNER JOIN purchase AS pc
                ON dt.document_no = pc.id
                INNER JOIN supplier AS s
                ON pc.supplier_code = s.id
                INNER JOIN product AS p
                ON dt.product_code = p.id
                INNER JOIN product_unit AS u
                ON p.product_unit = u.id
                WHERE dt.document_no = :id
                ";
$query_detail = $conn->prepare($sql_detail);
$query_detail->execute($data);
$row_detail = $query_detail->fetchAll(PDO::FETCH_ASSOC);

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
            <div class="card card-primary">
                <div class="card-header bg-success text-white">
                    <h3>ใบสั่งซื้อ (PO)</h3>
                </div>
                <div class="card-body">

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active text-dark" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
                        </li>
                    </ul>
                    <!-- info -->
                    <form action="../../server/po/po_update.php" method="post" enctype="multipart/form-data">

                        <div class="tab-content pt-4" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-4 col-form-label font-pr-form">รหัสผู้ขาย</label>
                                            <input type="hidden" name="purchase_id" value="<?php echo $row_purchase['id'] ?>" required readonly>

                                            <div class="col-sm-8">
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" name="supplier_code" id="supplier_code" value="<?php echo $row_purchase['supplier_code'] ?>" required readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-4 col-form-label font-pr-form">เลขที่เอกสาร</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="document_no" id="document_no" value="<?php echo $row_purchase['document_no'] ?>" required readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-4 col-form-label font-pr-form">วันที่เอกสาร</label>
                                            <div class="col-sm-8">
                                                <input type="date" class="form-control" id="inputPassword" name="docCreated" value="<?php echo $row_purchase['docCreated'] ?>" required readonly>
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
                                                    <input type="text" class="form-control" id="company_name" value="<?php echo $row_purchase['company_name'] ?>" required readonly>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-4 col-form-label font-pr-form">ต้องการภายใน (วัน)</label>
                                            <div class="col-sm-8">
                                                <input type="date" class="form-control" id="inputPassword" name="docWant" value="<?php echo $row_purchase['docWant'] ?>" required readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-4 col-form-label font-pr-form">วันที่สิ้นสุด</label>
                                            <div class="col-sm-8">
                                                <input type="date" class="form-control" id="inputPassword" name="docExe" value="<?php echo $row_purchase['docExe'] ?>" required readonly>
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
                                                    <input type="text" class="form-control" id="name" value="<?php echo $row_purchase['title_name'] . $row_purchase['name'] . " " . $row_purchase['last'] ?>" required readonly>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-4 col-form-label font-pr-form">เครดิต (วัน)</label>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="inputPassword" name="credit" value="<?php echo $row_purchase['credit'] ?>" required readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-4 col-form-label font-pr-form">กำหนดส่งของ</label>
                                            <div class="col-sm-8">
                                                <input type="date" class="form-control" id="inputPassword" name="sendProduct" value="<?php echo $row_purchase['sendProduct'] ?>" required readonly>
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
                                        <?php foreach ($row_detail as $key => $item) : ?>
                                            <tr>
                                                <td><?php echo $key += 1 ?></td>
                                                <td>
                                                    <div>
                                                        <img src='../../server/image/<?php echo $item['product_img'] ?>' width="64">
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php echo $item['id'] ?>
                                                    <input type="hidden" name="product_code[]" value="<?php echo $item['product_id'] ?>" required>
                                                </td>
                                                <td colspan="2"><?php echo $item['product_name'] ?></td>
                                                <td><?php echo $item['unit_name'] ?></td>
                                                <td>
                                                    <input type="number" class="form-control text-right price" oninput='getValue(this)' name="price[]" value="<?php echo $item['price'] ?>" required readonly>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control text-right qty" oninput='getValue(this)' name="qty[]" value="<?php echo $item['qty'] ?>" required readonly>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control text-right discount" oninput='getValue(this)' name="discount[]" value="<?php echo $item['discount'] ?>" required readonly>
                                                </td>
                                                <td><input type="number" class="form-control text-right total" name="total[]" value="<?php echo $item['total'] ?>" readonly readonly> </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>

                                            <input type="text" class="input-hidden" id="totalMoney" name="totalMoney" value="<?php echo $row_purchase["totalMoney"] ?>">
                                            <input type="text" class="input-hidden" id="totalDiscount" name="totalDiscount" value="<?php echo $row_purchase["totalDiscount"] ?>">
                                            <input type="text" class="input-hidden" id="totalVat" name="totalVat" value="<?php echo $row_purchase["totalVat"] ?>">
                                            <input type="text" class="input-hidden" id="totalFanal" name="totalFanal" value="<?php echo  $row_purchase["totalFanal"] ?>">

                                            <td colspan="5" class="text-right">รวมเงิน</td>
                                            <td colspan="5" class="text-right" id="totalAll">
                                                <?php echo number_format($row_purchase['totalMoney'], 2)  ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-right">ส่วนลดการค้า</td>
                                            <td colspan="4" class="text-right">
                                                <div class="d-flex align-items-center">
                                                    <input type="number" placeholder="0" min="0" name="discountPer" id="totalDiscountPer" oninput='getValue(this)' class="form-control col-2 ml-auto text-right" value="<?php echo $row_purchase["discountPer"] ?>">
                                                    <span class="ml-3">%</span>
                                                </div>
                                            </td>
                                            <td colspan="1" class="text-right" id="totalDiscountNum"> <?php echo number_format($row_purchase['totalDiscount'], 2)  ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-right">เงินก่อนหักภาษี</td>
                                            <td colspan="5" class="text-right" id="beforeTax"><?php echo number_format($row_purchase['totalMoney'] + $row_purchase['totalDiscount'], 2)  ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-right">ภาษีมูลค่าเพิ่ม</td>
                                            <td colspan="3" class="text-right">
                                                <select name="Tex" id="selectTax" class="form-control">
                                                    <option value="1" <?php echo $row_purchase['totalVat'] != 0 ? "selected" : '' ?>>PO-EX7</option>
                                                    <option value="2" <?php echo $row_purchase['totalVat'] == 0 ? "selected" : '' ?>>PO-NO</option>
                                                </select>
                                            </td>
                                            <td colspan="1" class="text-right">7%</td>
                                            <td colspan="1" class="text-right" id="tax7"><?php echo number_format($row_purchase['totalVat'], 2)  ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan=" 5" class="text-right">จำนวนเงินทั้งสิน</td>
                                            <td colspan="5" class="text-right" id="finalTotal"><?php echo number_format($row_purchase['totalFanal'], 2)  ?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <!-- product -->
                                <div class="text-right">
                                    <a href="./index.php" class="btn btn-info">กลับ</a>
                                    <button class="btn btn-warning" name="btnstatus" value="cancel">ไม่อนุมัติ</button>
                                    <button class="btn btn-success" name="btnstatus" value="success">อนุมัติ</button>
                                </div>
                            </div>

                            <div class=" tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...
                            </div>
                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
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

        var lenData = $("#show_prodcut_select > tr").length;


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