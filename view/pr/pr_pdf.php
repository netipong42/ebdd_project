<?php
require_once("../../server/connect.php");
require_once("../../server/thaibath.php");
require_once __DIR__ . '../../../vendor/autoload.php';
checkModule(@$_SESSION["user_id"], basename(dirname(__FILE__)), $conn);
// PDF
$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf(
    [
        'fontDir' => array_merge($fontDirs, [
            __DIR__ . '/tmp',
        ]),
        'fontdata' => $fontData + [
            'thsarabun' => [
                'R' => 'THSarabunNew.ttf',
                'I' => 'THSarabunNew Italic.ttf',
                'B' => 'THSarabunNew Bold.ttf',
            ]
        ],
        'default_font' => 'thsarabun',
        'margin_left'     => 10,
        'margin_right'    => 10,
        'margin_top'      => 90,
        'margin_bottom'   => 65,
        'margin_header'   => 10,
        'margin_footer'   => 10,
        'format'          => 'A4',
    ]
);

// mycompany
$sql_company = "SELECT * FROM detail_company";
$query_company = $conn->prepare($sql_company);
$query_company->execute();
$row_company = $query_company->fetch(PDO::FETCH_ASSOC);


$data = [
    'id' => $_GET['id'],
];
$sql_purchase = "SELECT 
                p.*,
                s.company_name,
                t.title_name,
                s.name,
                s.last,
                s.tax,
                s.phone,
                s.address,
                ap.ProvinceThai,
                ad.DistrictName,
                ab.TambonName,
                ab.zipcode,
                u.user_name,
                u.user_last,
                tu.title_name AS user_title
                FROM purchase AS p
                INNER JOIN supplier AS s
                ON p.supplier_code = s.id
                INNER JOIN address_province AS ap
                ON s.province = ap.ProvinceID
                INNER JOIN address_district AS ad
                ON s.district = ad.DistrictID
                INNER JOIN address_tambon AS ab
                ON s.tambon = ab.TambonID
                INNER JOIN users AS u
                ON p.user_create = u.id
                INNER JOIN title_name AS t
                ON s.title = t.id
                INNER JOIN title_name AS tu
                ON u.user_title = tu.id
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


// SetHTMLHeader
$mpdf->SetHTMLHeader('
<div class="row">
    <div class="col-6">
        <img src="../../assets/img/logo.png" alt="logo" width="150">
    </div>
    <div class="col-6">
        <div class="text-right">' . $row_company['company_name'] . '</div>
        <div class="text-right">' . $row_company['document_address'] . '</div>
        <div class="text-right">เลขที่ผู้เสียภาษี ' . $row_company['tax_number'] . '</div>
    </div>
    <div class="row">
        <div class="col-6 mr-auto b-a">
                <div class="row">
                    <div class="col-6 bg-black">
                        <div class="text-center">
                            <h3 class="p-0">Purchase Order</h3>
                            <h4 class="p-0">ใบสั่งซื้อ</h4>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center">
                            <h3 class="p-0">เลขที่เอกสาร</h3>
                            <h4 class="p-0">' . $row_purchase['document_no'] . '</h4>
                        </div>
                    </div>
                </div>
        </div>
    </div>
        <div class="row b-a m-t">
            <div class="col-6">
                    <div class="row">
                        <div class="row p">
                            <div class="col-4 ">ผู้ขาย</div>
                            <div class="col-8">' . $row_purchase['company_name'] . '</div>
                        </div>
                        <div class="row p">
                            <div class="col-4">เลขที่ผู้เสียภาษี</div>
                            <div class="col-8">' . $row_purchase['tax'] . '</div>
                        </div>
                        <div class="row p">
                            <div class="col-4">ที่อยู่</div>
                            <div class="col-8">' . $row_purchase['address'] . " " . $row_purchase['TambonName'] . " " . $row_purchase['DistrictName'] . " " . $row_purchase['ProvinceThai'] . " " . $row_purchase['zipcode'] . '</div>
                        </div>
                        <div class="row p">
                            <div class="col-4">โทร</div>
                            <div class="col-8">' . $row_purchase['phone'] . '</div>
                        </div>
                    </div>
            </div>
            <div class="col-6">
                    <div class="row b-l">
                        <div class="col-6">
                            <div class="row p">
                                <div class="col-6">วันที่</div>
                                <div class="col-6">' . $row_purchase['docCreated'] . '</div>
                            </div>
                            <div class="row p">
                                <div class="col-6">ต้องการภายในวัน</div>
                                <div class="col-6">' . $row_purchase['docWant'] . '</div>
                            </div>
                            <div class="row p">
                                <div class="col-6">วันที่ครบกำหนด</div>
                                <div class="col-6">' . $row_purchase['docExe'] . '</div>
                            </div>
                            <div class="row p">
                                <div class="col-6">เครดิต</div>
                                <div class="col-6">7</div>
                            </div>
                            <div class="row p">
                                <div class="col-6">ผู้ติดต่อ</div>
                                <div class="col-6">' . $row_purchase['title_name'] . $row_purchase['name'] . " " . $row_purchase['last'] . '</div>
                            </div>
                        </div>
                        <div class="col-6">
                         <div class="row p">
                                <div class="col-6">ผู้จัดทำ</div>
                                <div class="col-6">' . $row_purchase['user_title'] . $row_purchase['user_name'] . " " . $row_purchase['user_last'] . '</div>
                            </div>
                        </div>
                    </div>
            </div>
    </div>
</div>
');


// SetHTMLFooter
$mpdf->SetHTMLFooter('
<div class="row">
    <div class="col-6">
        <div class="row ">
            <table>
                <tbody>
                    <tr>
                        <td width="20">รวมเป็นเงิน</td>
                        <td class="text-center">' . baht_text($row_purchase['totalFanal']) . '</td>
                    </tr>
                    <tr >
                        <td class="note"width="20">หมายเหตุ</td>
                        <td class="note text-center"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-6">
            <div class="row ">
            <table>
                <tbody>
                    <tr>
                        <td class="bg-white">รวมเป็นเงิน</td>
                        <td class="text-right bg-white">' . number_format($row_purchase['totalMoney'], 2)  . '</td>
                    </tr>
                    <tr>
                        <td class="bg-white">หักส่วนลด</td>
                        <td class="text-right bg-white">' . number_format($row_purchase['totalDiscount'], 2)  . '</td>
                    </tr>
                    <tr>
                        <td class="bg-white">เงินก่อนหักภาษี</td>
                        <td class="text-right bg-white">' . number_format($row_purchase['totalMoney'] + $row_purchase['totalDiscount'], 2)  . '</td>
                    </tr>
                    <tr>
                        <td class="bg-white">ภาษีมูลค่าเพิ่ม</td>
                        <td class="text-right bg-white">' . number_format($row_purchase['totalVat'], 2)  . '</td>
                    </tr>
                    <tr>
                        <td class="fb">รวมเป็นเงินทั้งสิน</td>
                        <td class="text-right bg-black  fb">' . number_format($row_purchase['totalFanal'], 2)  . '</td>
                    </tr>
                </tbody>
            </table>
      
            </div>
    </div>
</div>
<div class="text-center">Page ' . '{PAGENO}' . " / " . '{nb}' . '</div>
');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/stylePrint.css">
</head>

<body>
    <!-- เนื้อหา -->
    <div class="row">
        <!-- <embed src="./test.pdf" type="application/pdf" frameBorder="0" scrolling="auto" height="1000" width="100%" /> -->
        <?php ob_start();  ?>
        <!-- Start PDF -->
        <div class="content">
            <table>
                <thead>
                    <tr>
                        <th class=" text-center">ลำดับ</th>
                        <th class="text-center">รหัสสินค้า</th>
                        <th class="text-center">รายการ</th>
                        <th class="text-right">จำนวน</th>
                        <th class="text-right">หน่วยนับ</th>
                        <th class="text-right">ราคา</th>
                        <th class="text-right">ส่วนลด</th>
                        <th class="text-right">จำนวนเงิน</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($row_detail as $key => $item) : ?>
                        <tr>
                            <td class="text-center"><?php echo $key += 1 ?></td>
                            <td><?php echo $item['product_id'] ?></td>
                            <td><?php echo $item['product_name'] ?></td>
                            <td class="text-right"><?php echo number_format($item['qty']) ?></td>
                            <td class="text-right"><?php echo $item['unit_name'] ?></td>
                            <td class="text-right"><?php echo number_format($item['price'], 2) ?></td>
                            <td class="text-right"><?php echo number_format($item['discount']) ?>%</td>
                            <td class="text-right"><?php echo number_format($item['total'], 2) ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <!-- Stop PDF -->
        <?php
        $html =  ob_get_contents();
        $stylesheet = file_get_contents('../../assets/css/stylePrint.css');
        $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
        $mpdf->Output("pr.pdf", "F");
        ob_end_flush();
        ?>
        <?php
        if (file_exists("pr.pdf")) {
            echo '<meta http-equiv="refresh" content="0;url=./pr.pdf">';
        } else {
            header("Location:./index.php");
        }
        ?>
    </div>
    <!-- เนื้อหา -->
</body>

</html>