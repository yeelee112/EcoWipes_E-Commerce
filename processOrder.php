<?php 
    if (!isset($_SESSION)) {
        session_start();
    }

    $uid = '';
    $checkSecure = 0;
    $priceTotal = 0;
    $idUserOder = 0;

    if(isset($_POST["name"])){
        $nameUser = $_POST["name"];
        $checkSecure++;
    }
    if(isset($_POST["phone"])){
        $phoneUser = $_POST["phone"];
        $checkSecure++;
    }
    if(isset($_POST["email"])){
        $emailUser = $_POST["email"];
        $checkSecure++;
    }
    if(isset($_POST["address"])){
        $addressUser = $_POST["address"];
        $checkSecure++;
    }

    if(isset($_POST["city"])){
        $city = $_POST["city"];
        $checkSecure++;
        $cookie_city = $city;
    }

    if(isset($_POST["district"])){
        $district = $_POST["district"];
        $checkSecure++;
        $cookie_district = $district;
    }

    if(isset($_POST["ward"])){
        $ward = $_POST["ward"];
        $checkSecure++;
        $cookie_ward = $ward;
    }

    if(isset($_POST["message"])){
        $messageUser = $_POST["message"];
        $checkSecure++;
    }

    if(isset($_POST["payment-method"])){
        $paymentMethod = $_POST["payment-method"];
        $checkSecure++;
    }

    if(isset($_POST["shipping-fee"])){
        $shippingFee = $_POST["shipping-fee"];
        $checkSecure++;
        if(!is_int($shippingFee)){
            $shippingFee = 0;
        }
    }
    
    setcookie("city", $cookie_city, time() + (86400 * 100), "/");
    setcookie("district", $cookie_district, time() + (86400 * 300), "/");
    setcookie("ward", $cookie_ward, time() + (86400 * 300), "/");

    if(isset($_SESSION['nameUser']) && isset($_SESSION['phoneUser'])){
        require_once 'DataProvider.php';
        $uid = $_SESSION['phoneUser'];
        $sqlUser = "select * from user_account where phone = '$uid'";
        $listUser = DataProvider::execQuery($sqlUser);
        $rowUser = mysqli_fetch_assoc($listUser);

        $sqlUpdateAccount = "update user_account set address = '$addressUser', updated_at = now() where id = '".$rowUser["id"]."'";
        DataProvider::execQuery($sqlUpdateAccount);

        $idUserOder = $rowUser["id"];
    }
    
    if($checkSecure >= 3){
        // if(isset($_SESSION['nameUser']) && isset($_SESSION['phoneUser'])){
        //     $uid = $_SESSION['phoneUser'];
            
        //     require_once 'DataProvider.php';
            
        //     $sqlUser = "select * from user_account where phone = '$uid'";
        //     $listUser = DataProvider::execQuery($sqlUser);
        //     $rowUser = mysqli_fetch_assoc($listUser);
            
        //     $sqlCart = "select * from shopping_session ss where ss.user_id = '".$rowUser["id"]."'"; 
        //     $listCart = DataProvider::execQuery($sqlCart);   
        //     $rowCart = mysqli_fetch_assoc($listCart);
            
        //     $sqlAddOrderDetail = "insert into order_detail values('".$rowCart["id"]."','".$rowUser["id"]."','".$rowCart["total_price"]."','$nameUser','$phoneUser','$addressUser','$messageUser',now(),now())";
        //     DataProvider::execQuery($sqlAddOrderDetail);
            
        //     $sqlCartItem = "select * from cart_item ci, shopping_session ss where ci.session_id = ss.id and ss.user_id = '".$rowUser["id"]."'";
        //     $listCartItem = DataProvider::execQuery($sqlCartItem);
        //     while($rowCartItem = mysqli_fetch_array($listCartItem, MYSQLI_ASSOC)){
        //         $sqlAddOrderItem = "insert into order_items values ('','".$rowCart["id"]."','".$rowCartItem["product_id"]."','".$rowCartItem["quantity"]."',now(),now())";
        //         DataProvider::execQuery($sqlAddOrderItem);
        //         $sqlDeteleCartItem = "delete from cart_item where product_id = '".$rowCartItem["product_id"]."'";
        //         DataProvider::execQuery($sqlDeteleCartItem);
        //     }
        //     $sqlDeleteSession = "delete from shopping_session where id = '".$rowCart["id"]."'";
        //     DataProvider::execQuery($sqlDeleteSession);
            
        //     echo "<script>alert('Cảm ơn bạn đã đặt hàng thành công')</script>";   
        //     header("Location: /");

        // }
        if(isset($_SESSION['cart'])){
            require_once 'DataProvider.php';

            $sql1 = "SELECT * FROM product p, image_product i WHERE p.id = i.product_id and p.product_text IN (";

            foreach ($_SESSION['cart'] as $id => $value) {
                $sql1 .= "'" . $id . "',";
            }

            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $date = date('y-m-d h:i:s');

            $idAfterHash = $date.$phoneUser;

            $idOrder =  hash("adler32", $idAfterHash, FALSE);
            $idOrder = 'DH-'.strtoupper($idOrder);

            $address = $ward.' - '.$district.' - '.$city;
            echo '<script>alert("'.$address.'")</script>';
            $sql1 = substr($sql1, 0, -1) . ")";
            $list1 = DataProvider::execQuery($sql1);


            while ($row1 = mysqli_fetch_array($list1, MYSQLI_ASSOC)) {

                $sqlAddOrderItem = "insert into order_items values ('','$idOrder','".$row1["product_id"]."','".$_SESSION['cart'][$row1['product_text']]['quantity']."',now(),now())";
                DataProvider::execQuery($sqlAddOrderItem);

                $sqlUpdateSoldItem = "update product set total_sold = total_sold + ".$_SESSION['cart'][$row1['product_text']]['quantity']." where id = '".$row1["product_id"]."'";
                DataProvider::execQuery($sqlUpdateSoldItem);
                
                $priceTotal += $row1["price"] * $_SESSION['cart'][$row1['product_text']]['quantity'];
            }
            
            $sqlAddOrderDetail = "insert into order_detail values('$idOrder', '$idUserOder','$priceTotal','$nameUser','$phoneUser','$addressUser','$address', $shippingFee ,'$paymentMethod','$messageUser',0,now(),now())";                
            DataProvider::execQuery($sqlAddOrderDetail);
            echo '<script>alert('.$sqlAddOrderDetail.')</script>';
            unset($_SESSION['cart']);
        }
    }

    else{
        header('Location: /');
    }
?>