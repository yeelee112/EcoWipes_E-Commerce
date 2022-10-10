<?php
    if (!isset($_SESSION)) {
        session_start();
    }

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require_once 'PHPMailer-master/src/PHPMailer.php';
    require_once 'PHPMailer-master/src/Exception.php';
    require_once 'PHPMailer-master/src/SMTP.php';

    require_once realpath(__DIR__ . '/vendor/autoload.php');

    // $dotenv->required(['DB_SERVER', 'DB_DATABASE', 'DB_USER', 'DB_PASS']);

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $dotenv->required(['USER_APP_GMAIL', 'PASSWORD_APP_GMAIL']);

    define('SITE_KEY', '6LdLU6chAAAAAMIuG36XQwBKP7jkzgIaRnqEQWJo');
    define('SECRET_KEY', '6LdLU6chAAAAAAfLBWJRTvd5u-Rm6oJxxFaQAoZU');

    $uid = '';
    $checkSecure = 0;
    $priceTotal = 0;
    $idUserOder = 0;
    $dataMail = '';
    $noteFromUser = '';
    $userInfo = '';
    $emailUser = '';
    $totalPay = 0;
    $idOrder = '';

    if (isset($_POST["name"])) {
        $nameUser = $_POST["name"];
        $checkSecure++;
    }

    if (isset($_POST["phone"])) {
        $phoneUser = $_POST["phone"];
        $checkSecure++;
    }

    if (isset($_POST["email"])) {
        $emailUser = $_POST["email"];
        $checkSecure++;
    }

    if (isset($_POST["address"])) {
        $addressUser = $_POST["address"];
        $checkSecure++;
    }

    if (isset($_POST["city"])) {
        $city = $_POST["city"];
        $checkSecure++;
        $cookie_city = $city;
    }

    if (isset($_POST["district"])) {
        $district = $_POST["district"];
        $checkSecure++;
        $cookie_district = $district;
    }

    if (isset($_POST["ward"])) {
        $ward = $_POST["ward"];
        $checkSecure++;
        $cookie_ward = $ward;
    }

    if (isset($_POST["message"])) {
        $messageUser = $_POST["message"];
        $checkSecure++;
    }

    if (isset($_POST["payment-method"])) {
        $paymentMethod = $_POST["payment-method"];
        $checkSecure++;
    }

    if (isset($_POST["shipping-fee"])) {
        $shippingFee = intval($_POST["shipping-fee"]);
        $checkSecure++;
    }

    setcookie("city", $cookie_city, time() + (86400 * 300), "/");
    setcookie("district", $cookie_district, time() + (86400 * 300), "/");
    setcookie("ward", $cookie_ward, time() + (86400 * 300), "/");

    if (isset($_SESSION['nameUser']) && isset($_SESSION['phoneUser'])) {
        require_once 'DataProvider.php';
        $uid = $_SESSION['phoneUser'];
        $sqlUser = "select * from user_account where phone = '$uid'";
        $listUser = DataProvider::execQuery($sqlUser);
        $rowUser = mysqli_fetch_assoc($listUser);

        $sqlUpdateAccount = "update user_account set address = '$addressUser', updated_at = now() where id = '" . $rowUser["id"] . "'";
        DataProvider::execQuery($sqlUpdateAccount);

        $idUserOder = $rowUser["id"];
    }

    function getCaptcha($SecretKey)
    {
        $Response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . SECRET_KEY . "&response={$SecretKey}");
        $Return = json_decode($Response);
        return $Return;
    }

    $Return = getCaptcha($_POST['g-recaptcha-response']);
    if ($checkSecure >= 3) {
        if (isset($_SESSION['cart'])) {

            require_once 'DataProvider.php';
            $sql1 = "SELECT * FROM product p, image_product i WHERE p.id = i.product_id and p.product_text IN (";

            foreach ($_SESSION['cart'] as $id => $value) {
                $sql1 .= "'" . $id . "',";
            }

            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $date = date('H:i:s d/m/Y');

            $idAfterHash = time() . $phoneUser;

            $idOrder =  hash("adler32", $idAfterHash, FALSE);
            $idOrder = 'DH-' . strtoupper($idOrder);

            $address = $ward . ' - ' . $district . ' - ' . $city;
            $sql1 = substr($sql1, 0, -1) . ")";
            $list1 = DataProvider::execQuery($sql1);
            $temp = 1;
                $dataMail .= '<tr>
                    <th>No.</th>
                    <th class="center-tr">Sản phẩm</th>
                    <th>Số lượng</th>
                    </tr>';
            while ($row1 = mysqli_fetch_array($list1, MYSQLI_ASSOC)) {

                $sqlAddOrderItem = "insert into order_items values ('','$idOrder','" . $row1["product_id"] . "','" . $_SESSION['cart'][$row1['product_text']]['quantity'] . "',now(),now())";
                DataProvider::execQuery($sqlAddOrderItem);

                $sqlUpdateSoldItem = "update product set total_sold = total_sold + " . $_SESSION['cart'][$row1['product_text']]['quantity'] . " where id = '" . $row1["product_id"] . "'";
                DataProvider::execQuery($sqlUpdateSoldItem);

                $priceTotal += $row1["price"] * $_SESSION['cart'][$row1['product_text']]['quantity'];

                $dataMail .= '
                        <tr>
                        <td class="center-tr">' . $temp . '</td>
                        <td style="font-weight:600">' . $row1["product_name"] . '</td>
                        <td class="center-tr">' . $_SESSION['cart'][$row1['product_text']]['quantity'] . '</td>
                        </tr>
                        ';
                $temp++;
            }
            $totalPay = $priceTotal + $shippingFee;

            if ($paymentMethod == "COD" || $paymentMethod == "Banking") {



                $emailInfo = '';

                if ($emailUser != '' || $emailUser != NULL) {
                    $emailInfo = '<tr>
                        <th>Email:</th>
                        <td style="color:#72be44;">' . $emailUser . '</td>
                    </tr>';
                }

                $userInfo = '<table role="presentation" class="bg_white" cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                            <td class="text-services" style="text-align: left; padding-left:25px;">
                                <div class="heading-section">
                                    <table>
                                        <tr>
                                            <th style="padding-right:40px;">Họ tên:</th>
                                            <td style="font-weight: 700;color:#72be44;">' . $nameUser . '</td>
                                        </tr>
                                        <tr>
                                            <th>SĐT:</th>
                                            <td>' . $phoneUser . '</td>
                                        </tr>
                                        ' . $emailInfo . '
                                        <tr>
                                            <th>Địa chỉ:</th>
                                            <td style="font-weight: 500;">' . $addressUser . '</td>
                                        </tr>
                                        <tr>
                                            <td colspan=2>' . $address . '
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </table>';

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

                if ($messageUser != '') {
                    $noteFromUser .= '<div style="text-align: center; padding: 0 30px;">
                        <p style="font-size: 0.8rem;">*Ghi chú: ' . $messageUser . '</p>
                        </div>';
                }

                unset($_SESSION["coupon"]);

                $sqlAddOrderDetail = "insert into order_detail values('$idOrder', '$idUserOder','$priceTotal','$nameUser','$phoneUser','$emailUser','$addressUser','$address', $shippingFee ,'$paymentMethod','$messageUser',0,now(),now())";
                DataProvider::execQuery($sqlAddOrderDetail);
                $curPageName = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);

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
                    $mail->setFrom($_ENV['USER_APP_GMAIL'], "Đơn hàng mới $idOrder");
                    $mail->addAddress('cskh@ecowipes.com.vn');     //Add a recipient             //Name is optional
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
                                                                    <h1 style="color:#503629;margin-bottom: 0;font-size:20px">Đơn hàng <a href="https://thegioikhanuot.com/invoice?id=' . $idOrder . '" style="color:#72be44">#' . $idOrder . '</a> (' . $paymentMethod . ')</h1>
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
                    echo true;
                } catch (Exception $e) {
                    echo false;
                }
            } else if ($paymentMethod == "MOMO") {
                function execPostRequest($url, $data)
                {
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt(
                        $ch,
                        CURLOPT_HTTPHEADER,
                        array(
                            'Content-Type: application/json',
                            'Content-Length: ' . strlen($data)
                        )
                    );
                    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
                    //execute post
                    $result = curl_exec($ch);
                    //close connection
                    curl_close($ch);
                    return $result;
                }

                $endpoint = "https://payment.momo.vn/v2/gateway/api/create";
                // $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

                $urlHost = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

                $partnerCode = $_ENV['MOMO_PARTNER_CODE'];
                $accessKey = $_ENV['MOMO_ACCESS_KEY'];
                $secretKey = $_ENV['MOMO_SECRET_KEY'];
                $orderInfo = "Thanh toán qua MoMo";
                $amount = $totalPay;
                $orderId = $idOrder;
                // time() .""
                $redirectUrl = $urlHost . "/processMomoResult";
                $ipnUrl = $urlHost . "/processMomoResult";
                $extraData = "";
                $subIdOrder = substr($idOrder, 3);
                $subPhone = substr($phoneUser, 1);

                if (true) {
                    $requestId = $subIdOrder.$subPhone;
                    $requestType = "captureWallet";
                    //before sign HMAC SHA256 signature
                    $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
                    $signature = hash_hmac("sha256", $rawHash, $secretKey);
                    $data = array(
                        'partnerCode' => $partnerCode,
                        'requestId' => $requestId,
                        'amount' => $amount,
                        'orderId' => $orderId,
                        'orderInfo' => $orderInfo,
                        'redirectUrl' => $redirectUrl,
                        'ipnUrl' => $ipnUrl,
                        'lang' => 'vi',
                        'extraData' => $extraData,
                        'requestType' => $requestType,
                        'signature' => $signature
                    );
                    $result = execPostRequest($endpoint, json_encode($data));
                    $jsonResult = json_decode($result, true);

                    $sqlAddTempOrder = "insert into temp_order_detail values('$idOrder', '$idUserOder','$priceTotal','$nameUser','$phoneUser','$emailUser','$addressUser','$address', $shippingFee ,'$paymentMethod','$messageUser',0,now(),now())";
                    DataProvider::execQuery($sqlAddTempOrder);

                    echo $result;

                    // header('Location: ' . $jsonResult['payUrl']);
                    // echo json_encode(['location' => $jsonResult['payUrl']]);
                }
            }
        }
    }
    else {
        echo false;
    }
?>