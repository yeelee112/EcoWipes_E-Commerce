<?php
http_response_code(200); //200 - Everything will be 200 Oke
if (!isset($_SESSION)) {
    session_start();
}
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once 'PHPMailer-master/PHPMailer-master/src/PHPMailer.php';
require_once 'PHPMailer-master/PHPMailer-master/src/Exception.php';
require_once 'PHPMailer-master/PHPMailer-master/src/SMTP.php';

require_once realpath(__DIR__ . '/vendor/autoload.php');

// $dotenv->required(['DB_SERVER', 'DB_DATABASE', 'DB_USER', 'DB_PASS']);

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

if (!empty($_GET)) {
    $response = array();
    try {
        $accessKey = $_ENV["MOMO_ACCESS_KEY"];
        $secretKey = $_ENV["MOMO_SECRET_KEY"];
        $partnerCode = $_GET["partnerCode"];
        $orderId = $_GET["orderId"];
        $requestId = $_GET["requestId"];
        $amount = $_GET["amount"];
        $orderInfo = $_GET["orderInfo"];
        $orderType = $_GET["orderType"];
        $transId = $_GET["transId"];
        $resultCode = $_GET["resultCode"];
        $message = $_GET["message"];
        $payType = $_GET["payType"];
        $responseTime = $_GET["responseTime"];
        $extraData = $_GET["extraData"];
        $m2signature = $_GET["signature"]; //MoMo signature

        $isSuccess = false;
        $isSendMail = false;
        //Checksum
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&message=" . $message . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo .
        "&orderType=" . $orderType . "&partnerCode=" . $partnerCode . "&payType=" . $payType . "&requestId=" . $requestId . "&responseTime=" . $responseTime .
        "&resultCode=" . $resultCode . "&transId=" . $transId;
        
        $partnerSignature = hash_hmac("sha256", $rawHash, $secretKey);
        
        if ($m2signature == $partnerSignature) {
            if ($resultCode == '0') {
                // $result = '<div class="alert alert-success">Capture Payment Success</div>';
                $isSuccess = true;
                $noteFromUser = '';
                $dataMail = '';
                $priceTotal = 0;
                $totalPay = 0;

                require_once 'DataProvider.php';
                
                $sqlTemp = "select * from temp_order_detail where id = '$orderId'";
                $listTemp = DataProvider::execQuery($sqlTemp);
                $rowTemp = mysqli_fetch_assoc($listTemp);

                // Update Database
                $sqlCreateOrder = "insert into order_detail values('$orderId','" . $rowTemp["user_id"] . "' ," . $rowTemp["total_price"] . ",'" . $rowTemp["fullname"] . "','" . $rowTemp["phone"] . "','" . $rowTemp["email"] . "','" . $rowTemp["address_detail"] . "','" . $rowTemp["address"] . "', " . $rowTemp["shipping_fee"] . " ,'" . $rowTemp["payment_method"] . "','" . $rowTemp["noted_vendor"] . "',0,now(),now())";
                DataProvider::execQuery($sqlCreateOrder);

                $sqlRemoveTemp = "delete from temp_order_detail where id = '$orderId'";
                DataProvider::execQuery($sqlRemoveTemp);

                $sqlCreateMomoPayment = "insert into momo_payment values('$transId','$partnerCode','$requestId','$orderId',$amount,'$orderInfo','$orderType','$message',$resultCode,'$payType','$m2signature','$responseTime')";
                DataProvider::execQuery($sqlCreateMomoPayment);


                // Send Email
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                $date = date('H:i:s d/m/Y');
                $shippingFee = $rowTemp["shipping_fee"];

                $sql = "SELECT * FROM product p, image_product i, order_items ot WHERE p.id = i.product_id and p.id = ot.product_id and ot.order_id = '$orderId'";
                $list = DataProvider::execQuery($sql);
                $temp = 1;
                
                $dataMail = '<tr>
                            <th>No.</th>
                            <th class="center-tr">Sản phẩm</th>
                            <th>Số lượng</th>
                        </tr>';
                while ($row = mysqli_fetch_array($list, MYSQLI_ASSOC)) {
                    $priceTotal += $row['price'] * $row['quantity'];

                    $dataMail .= '
                            <tr>
                                <td class="center-tr">' . $temp . '</td>
                                <td style="font-weight:600">' . $row["product_name"] . '</td>
                                <td class="center-tr">' . $row['quantity'] . '</td>
                            </tr>
                            ';
                    $temp++;
                }

                

                $emailInfo = '';

                if ($rowTemp['email'] != '' || $rowTemp['email'] != NULL) {
                    $emailInfo = '<tr>
                        <th>Email:</th>
                        <td style="color:#72be44;">' . $rowTemp['email'] . '</td>
                    </tr>';
                }

                $userInfo = '<table role="presentation" class="bg_white" cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                            <td class="text-services" style="text-align: left; padding-left:25px;">
                                <div class="heading-section">
                                    <table>
                                        <tr>
                                            <th style="padding-right:40px;">Họ tên:</th>
                                            <td style="font-weight: 700;color:#72be44;">' . $rowTemp['fullname'] . '</td>
                                        </tr>
                                        <tr>
                                            <th>SĐT:</th>
                                            <td>' . $rowTemp['phone'] . '</td>
                                        </tr>
                                        ' . $emailInfo . '
                                        <tr>
                                            <th>Địa chỉ:</th>
                                            <td style="font-weight: 500;">' . $rowTemp['address_detail'] . '</td>
                                        </tr>
                                        <tr>
                                            <td colspan=2>' . $rowTemp['address'] . '
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </table>';
                $totalPay = $priceTotal + $shippingFee;

                $dataMail .= '<tr style="border-top:1px solid #e7e7e7;"></tr>
                    <tr class="final-tr">
                    <td></td>
                    <td class="right-align text-price">Tiền hàng</td>
                    <td class="right-align text-price">' . number_format($priceTotal, 0, ",", ".") . '₫</td>
                    </tr>
                    <tr class="final-tr">
                    <td></td>
                    <td class="right-align text-price">Phí vận chuyển</td>
                    <td class="right-align text-price">' . number_format($shippingFee, 0, ",", ".") . '₫</td>
                    </tr>
                    <tr class="final-tr">
                    <td></td>
                    <td class="text-price">Thành tiền</td>
                    <td style="font-weight:700;padding: 0 0 0 5px;" class="right-align">' . number_format($totalPay, 0, ",", ".") . '₫</td>
                    </tr>';
                if ($rowTemp["noted_vendor"] != '') {
                    $noteFromUser .= '<div style="text-align: center; padding: 0 30px;">
                            <p style="font-size: 0.8rem;">*Ghi chú: ' . $rowTemp["noted_vendor"] . '</p>
                            </div>';
                }

                $mail = new PHPMailer();                              // Passing `true` enables exceptions
                try {

                    //Server settings
                    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;

                    $mail->Username   = $_ENV['USER_APP_GMAIL'];                     //SMTP username
                    $mail->Password   = $_ENV['PASSWORD_APP_GMAIL'];                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;           //Enable implicit TLS encryption
                    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom($_ENV['USER_APP_GMAIL'], "Đơn hàng mới $orderId");
                    $mail->addAddress('chauhoangan789@gmail.com');     //Add a recipient             //Name is optional
                    $mail->addReplyTo('digital@ecowipes.com.vn');


                    //Attachments
                    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
                    $mail->CharSet = 'UTF-8';
                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Thông báo đơn hàng mới Thế Giới Khăn Ướt';
                    $mail->Body    = '<!DOCTYPE html>
                            <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
                                xmlns:o="urn:schemas-microsoft-com:office:office">
                            
                                <head>
                                <meta charset="utf-8"> <!-- utf-8 works for most cases -->
                                <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn"t be necessary -->
                                <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
                                <meta name="x-apple-disable-message-reformatting"> <!-- Disable auto-scale in iOS 10 Mail entirely -->
                                <title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->
                            
                                <link rel="preconnect" href="https://fonts.googleapis.com">
                                <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                                <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap"
                                    rel="stylesheet">
                                <style>
                                    html,body{margin:0 auto !important;padding:0 !important;height:100% !important;width:100% !important;background:#f1f1f1;}*{-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;}td a{color:#72be44;}tr th{color:#503629;}div[style*="margin:16px 0"]{margin:0 !important;}table,td{mso-table-lspace:0pt !important;mso-table-rspace:0pt !important;}table{border-spacing:0 !important;border-collapse:collapse !important;table-layout:fixed !important;margin:0 auto !important;}img{-ms-interpolation-mode:bicubic;}a{text-decoration:none;}*[x-apple-data-detectors],.unstyle-auto-detected-links *,.aBn{border-bottom:0 !important;cursor:default !important;color:inherit !important;text-decoration:none !important;font-size:inherit !important;font-family:inherit !important;font-weight:inherit !important;line-height:inherit !important;}.a6S{display:none !important;opacity:0.01 !important;}.im{color:inherit !important;}img.g-img+div{display:none !important;}@media only screen and (min-device-width:320px) and (max-device-width:374px){u~div .email-container{min-width:320px !important;}}@media only screen and (min-device-width:375px) and (max-device-width:413px){u~div .email-container{min-width:375px !important;}}@media only screen and (min-device-width:414px){u~div .email-container{min-width:414px !important;}}
                                </style>
                                <style>
                                    .primary{background:#0d0cb5;}.bg_white{background:#ffffff;}.email-section{padding:0 2.5em 2.5em 2.5em;}h1,h2,h3,h4,h5,h6{font-family:"Open Sans", sans-serif;color:#000000;margin-top:0;}body{font-family:"Open Sans", sans-serif;font-weight:400;font-size:15px;line-height:1.8;color:#503629;}a{color:#0d0cb5;}table{}.logo h1{margin:0;}.logo h1 a{color:#000000;font-size:20px;font-weight:700;text-transform:uppercase;font-family:"Open Sans", sans-serif;}.navigation{padding:0;}.heading-section{}.heading-section h2{color:#000000;font-size:20px;margin-top:0;line-height:1.4;font-weight:700;text-transform:uppercase;}.heading-section .subheading{margin-bottom:20px !important;display:inline-block;font-size:13px;text-transform:uppercase;letter-spacing:2px;color:rgba(0, 0, 0, .4);position:relative;}.heading-section .subheading::after{position:absolute;left:0;right:0;bottom:-10px;content:"";width:100%;height:2px;background:#0d0cb5;margin:0 auto;}.text-services{padding:10px 10px 0;text-align:center;}.services-list h3{margin-top:0;margin-bottom:0;}.services-list p{margin:0;}.text-services .meta{text-transform:uppercase;font-size:14px;}.text-testimony .name{margin:0;}.text-testimony .position{color:rgba(0, 0, 0, .3);}.img{width:100%;height:auto;position:relative;}.img .icon{position:absolute;top:50%;left:0;right:0;bottom:0;margin-top:-25px;}.img .icon a{display:block;width:60px;position:absolute;top:0;left:50%;margin-left:-25px;}.counter{width:100%;position:relative;z-index:0;}.counter .overlay{position:absolute;top:0;left:0;right:0;bottom:0;content:"";width:100%;background:#000000;z-index:-1;opacity:.3;}.footer{color:rgba(255, 255, 255, .5);}.footer .heading{color:#ffffff;font-size:20px;}.footer ul li a{color:rgba(255, 255, 255, 1);}@media screen and (max-width:500px){.icon{text-align:left;}.text-services{padding-left:0;padding-right:20px;text-align:left;}}
                                    .even-bg-white tr:nth-child(even) {
                            background-color: #f3f3f3;
                            }.final-tr{background-color: #fff !important;}.center-tr{text-align: center; vertical-align: middle;}.right-align{text-align:right}.text-price{text-align:right;font-weight:400;font-size:13px}
                                </style>
                            </head>
                            
                            <body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly;">
                                <center style="width: 100%; background-color: #f1f1f1;">
                                    <div
                                        style="display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
                                    </div>
                                    <div style="max-width: 600px; margin: 0 auto;" class="email-container">
                                        <!-- BEGIN BODY -->
                                        <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                                            style="margin: auto;">
                                            <tr>
                                                <td valign="top" class="bg_white" style="padding: 1em 2.5em;">
                                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td width="35%" class="logo" style="text-align: left;">
                                                                <a href="https://ecowipes.com.vn" target="_blank">
                                                                    <img src="https://lh3.googleusercontent.com/pw/AM-JKLUuW5gfWXGdddiS4lFXYAdq6EyUlvtyLbC4eU9Ibaez98bJCvydMeOub7RilP-BIsEbgsjyBnJ2KvFNTSM_zsQG2qtLHQomZ5YTuXCwQnZTUH_bhB_88g39AnZ_VIBn7BDA4OGUajbzrJCLID8pQKg9=w596-h165-no"
                                                                        style="width:100%">
                                                                </a>
                                                            </td>
                                                            <td width="35%"></td>
                                                            <td width="30%" class="logo" style="text-align: right;">
                                                                <img src="https://lh3.googleusercontent.com/pw/AM-JKLU2uRd7ObrDgPK7Yr1BI-C8DxrQoqsE0Hg64zftkZ0Y6agsBEw2NO5rTyqG1ndsdskjhInHYZYKYR0A-qfLOGZYUnoyYzEVHBSot4eE_hcQDBiwAsLG8J0le7bXHeDGynH09eDTeXxMqnzrnYSXlPGJ=w473-h316-no"
                                                                    style="width:100%">
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr><!-- end tr -->
                            
                                            <tr>
                                                <td class="bg_white">
                                                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                        <tr>
                                                            <td class="bg_white email-section">
                                                                <div class="heading-section" style="text-align: center; padding: 0 30px;">
                                                                    <h1 style="color:#503629;margin-bottom: 0;font-size:20px">Đơn hàng <a href="https://thegioikhanuot.com/invoice?id=' . $orderId . '" style="color:#72be44">#' . $orderId . '</a> (' . $rowTemp["payment_method"] . ')</h1>
                                                                    <p style="margin:0;font-size: 0.8rem;">' . $date . '</p>
                                                                </div>
                                                                ' . $userInfo . '
                                                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                                    <tr>
                                                                        <td class="text-services" style="text-align: left; padding-left:25px;">
                                                                            <div class="heading-section">
                                                                                <table>
                                                                                    ' . $dataMail . '
                                                                                </table>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            ' . $noteFromUser . '
                                                            </td>
                                                        </tr><!-- end: tr -->
                                                    </table>
                                                </td>
                                            </tr><!-- end:tr -->
                                            <!-- 1 Column Text + Button : END -->
                                        </table>
                                        <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                                            style="margin: auto;">
                                            <img width="100%" style="background-color: white; padding-top:30px" src="https://lh3.googleusercontent.com/pw/AM-JKLUUIG08ry3MK2YGgiT4SQQuF0ZF1nQFW9_QHGh_6J2JCKDUVUbuGEi4bNz7CKuIwbX-B07sIaXOAhMQlzq6BuGChrmLiSKWKQBI97kdf2AP1dlGIZRj0RVtTsa5_WHpCNy6p-W6eki_vUal6TxL0qsr=w1560-h282-no">
                                        </table>
                            
                                    </div>
                                </center>
                            </body>
                            </html>';
                    $mail->send();
                    unset($_SESSION['cart']);
                    $isSendMail = true;
                } catch (Exception $e) {
                    $isSendMail = false;
                }
            } else {
                // $result = '<div class="alert alert-danger">' . $message . '</div>';
                $isSuccess = false;
            }
        } else {
            // $result = '<div class="alert alert-danger">This transaction could be hacked, please check your signature and returned signature</div>';
            $isSuccess = false;
        }
    } catch (Exception $e) {
        echo $response['message'] = $e;
    }

    // $debugger = array();
    // $debugger['rawData'] = $rawHash;
    // $debugger['momoSignature'] = $m2signature;
    // $debugger['partnerSignature'] = $partnerSignature;

    // if ($m2signature == $partnerSignature) {
    //     $response['message'] = "Received payment result success";
    //     $result2 = true;
    // } else {
    //     $response['message'] = "ERROR! Fail checksum";
    // }
    // $response['debugger'] = $debugger;
    // echo json_encode($response);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Kết quả thanh toán MoMo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css" />
    <!-- CSS -->
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(255, 255, 255, .8) url("assets/imgs/loader.gif") 50% 50% no-repeat;
        }

        /* When the body has the loading class, we turn
        the scrollbar off with overflow:hidden */
        body.loading .modal {
            overflow: hidden;
        }

        /* Anytime the body has the loading class, our
        modal element will be visible */
        body.loading .modal {
            display: block;
        }
    </style>
</head>

<body>
    <div class="modal"></div>

    <script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $body = $("body");
        $body.addClass("loading");
    </script>

    <?php if ($isSuccess == true) {
        echo '<script>
        Swal.fire({
            html: "<strong>Đặt hàng thành công!</strong><br> <div>Bạn sẽ tự động trở về trang chủ sau 3 giây<div>",
            icon: "success",
            timerProgressBar: true,
            timer: 3000,   
            didOpen: () => {
                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector("b")
                timerInterval = setInterval(() => {
                    // b.textContent = Swal.getTimerLeft()
                }, 100)
            },
            willClose: () => {
                clearInterval(timerInterval);
                location.href = "/";
            }
        });
        </script>
        ';
    } else {
        echo '
            <script>
                Swal.fire({
                    html: "<strong>Đặt hàng không thành công!</strong><br>",
                    icon: "error",
                    timerProgressBar: true,
                    timer: 3000,   
                    didOpen: () => {
                        Swal.showLoading()
                        const b = Swal.getHtmlContainer().querySelector("b")
                        timerInterval = setInterval(() => {
                            // b.textContent = Swal.getTimerLeft()
                        }, 100)
                    },
                    willClose: () => {
                        clearInterval(timerInterval);
                        location.href = "/checkout";
                    }
                });
            </script>
            ';
    } ?>

</body>
</html>