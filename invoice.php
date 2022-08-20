<?php
    if(isset($_GET["id"])){
        $idInvoice = $_GET["id"];
    }
    require_once 'DataProvider.php';

    $sql = "select * from order_detail where id = '$idInvoice'";
    $list = DataProvider::execQuery($sql);
    $row = mysqli_fetch_assoc($list);
    $price = 0;
    $totalPrice = 0;

?>

<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <title>EcoWipes - Invoice</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content>
    <meta property="og:type" content>
    <meta property="og:url" content>
    <meta property="og:image" content>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/imgs/theme/favicon.svg">
    <link rel="stylesheet" href="assets/css/main_v%3D5.2.css">
    <style>
        p {
            font-size: 14px;
            font-weight: 400;
            line-height: 24px;
            margin-bottom: 5px;
            color: #7E7E7E;
        }
    </style>
</head>

<body>
    <div class="invoice invoice-content invoice-2">
        <div class="back-top-home hover-up mt-30 ml-30">
            <a class="hover-up" href="/"><i class="fi-rs-home mr-5"></i> Trang chủ</a>
        </div>
        <div class="container">
            <div class="row d-flex align-items-center">
                <div class="col-lg-12">
                    <div class="invoice-inner">
                        <div class="invoice-info" id="invoice_wrapper">
                            <div class="invoice-header">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="invoice-numb">
                                            <h4 class="invoice-header-1 mb-10 mt-20">Invoice ID: <span class="text-brand">#<?php echo $row["id"]; ?></span></h4>
                                            <h6 class>Ngày: <?php echo $row["created_at"]; ?></h6>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="invoice-name text-end">
                                            <div class="logo">
                                                <a href><img src="assets/imgs/theme/logo.svg" alt="logo"></a>
                                            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-top">
                                <div class="row">
                                    <div class="col-lg-9 col-sm-8">
                                        <div class="invoice-number">
                                            <!-- <h4 class="invoice-title-1 mb-10">Invoice To</h4> -->
                                            <p class="invoice-addr-1">
                                                <strong>Công ty Cổ Phần EcoWipes</strong> <br>
                                                ecowipes.com.vn <br>
                                                Việt Nam
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-4">
                                        <div class="invoice-number">
                                            <!-- <h4 class="invoice-title-1 mb-10">Bill To</h4> -->
                                            <p class="invoice-addr-1">
                                                Họ tên: <strong><?php echo $row["fullname"]; ?></strong> <br>
                                                Số điện thoại: <a href="tel:<?php echo $row["phone"]; ?>" class="__cf_email__" data-cfemail="c6a4afaaaaafa8a18688a3b5b28ba7b4b2e8a5a9ab"><?php echo $row["phone"]; ?></a> <br>
                                                <?php
                                                    if($row["email"] != ''){
                                                        echo 'Email: <a href="mailto:'.$row["email"].'" class="__cf_email__" data-cfemail="c6a4afaaaaafa8a18688a3b5b28ba7b4b2e8a5a9ab">'.$row["email"].'</a> <br>';
                                                    }
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-3 col-sm-4">
                                        <h4 class="invoice-title-1 mb-10">Phương thức thanh toán</h4>
                                        <p class="invoice-from-1"><?php echo $row["payment_method"]; ?></p>
                                    </div>
                                    <div class="col-lg-9 col-sm-8">
                                        <h4 class="invoice-title-1 mb-10">Địa chỉ</h4>
                                        <p class="invoice-from-1"><?php echo $row["address_detail"].', '.$row["address"]; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-center">
                                <div class="table-responsive">
                                    <table class="table table-striped invoice-table">
                                        <thead class="bg-active">
                                            <tr>
                                                <th>Sản phẩm</th>
                                                <th class="text-center">Đơn giá</th>
                                                <th class="text-center">Số lượng</th>
                                                <th class="text-right">Tổng</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                                $sqlOrderItem = "select * from order_detail od, order_items ot, product p where od.id = ot.order_id and ot.product_id = p.id and od.id = '$idInvoice'";
                                                $listOrderItem = DataProvider::execQuery($sqlOrderItem);
                                                while ($rowOrderItem = mysqli_fetch_array($listOrderItem, MYSQLI_ASSOC)) {
                                                    $totalPrice += $rowOrderItem["price"] * $rowOrderItem["quantity"];
                                            ?>
                                            <tr>
                                                <td>
                                                    <div class="item-desc-1">
                                                        <span><?php echo $rowOrderItem["product_name"] ?></span>
                                                        <!-- <small>SKU: <?php echo $rowOrderItem["id"] ?></small> -->
                                                    </div>
                                                </td>
                                                <td class="text-center"><?php echo number_format($rowOrderItem["price"], 0, ",", ".") . ' ₫' ?></td>
                                                <td class="text-center"><?php echo $rowOrderItem["quantity"] ?></td>
                                                <td class="text-right"><?php echo number_format($rowOrderItem["price"] * $rowOrderItem["quantity"], 0, ",", ".") . ' ₫' ?></td>
                                            </tr>
                                            <?php } ?>
                                            
                                            <tr>
                                                <td colspan="3" class="text-end f-w-600">Tạm tính</td>
                                                <td class="text-right"><?php echo number_format($totalPrice, 0, ",", ".") ?> ₫</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-end f-w-600">Vận chuyển</td>
                                                <td class="text-right"><?php echo number_format($row["shipping_fee"], 0, ",", ".")  ?> ₫</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-end f-w-600" style="font-weight: 600;color: #253d4e;font-size: 1.1rem;margin-bottom: 0px;">Tổng cộng</td>
                                                <td class="text-right f-w-600" style="font-weight: 600;color: #253d4e;font-size: 1.1rem;margin-bottom: 0px;" ><?php echo number_format($totalPrice + $row["shipping_fee"], 0, ",", ".") ?> ₫</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="invoice-bottom">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- <div>
                                            <h3 class="invoice-title-1">Important Note</h3>
                                            <ul class="important-notes-list-1">
                                                <li>All amounts shown on this invoice are in US dollars</li>
                                                <li>finance charge of 1.5% will be made on unpaid balances after 30 days.</li>
                                                <li>Once order done, money can't refund</li>
                                                <li>Delivery might delay due to some external dependency</li>
                                            </ul>
                                        </div> -->
                                    </div>
                                    <div class="col-sm-6 col-offsite">
                                        <div class="text-end">
                                            <p class="mb-0 text-13">Cảm ơn bạn đã tin tưởng chúng tôi</p>
                                            <p><strong style="color:#72be44;">EcoWipes Việt Nam</strong></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-btn-section clearfix d-print-none">
                            <a href="javascript:window.print()" class="btn btn-lg btn-custom btn-print hover-up"> <img src="assets/imgs/theme/icons/icon-print.svg" alt> In </a>
                            <a id="invoice_download_btn" class="btn btn-lg btn-custom btn-download hover-up"> <img src="assets/imgs/theme/icons/icon-download.svg" alt> Tải về </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Vendor JS-->
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="assets/js/vendor/modernizr-3.6.0.min.js"></script>
    <script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
    <!-- Invoice JS -->
    <script src="assets/js/invoice/jspdf.min.js"></script>
    <script src="assets/js/invoice/invoice.js"></script>
</body>

</html>