<?php 
    session_start();
    $uid = '';
    $checkSecure = 0;
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

    if(isset($_POST["message"])){
        $messageUser = $_POST["message"];
        $checkSecure++;
    }
    
    if($checkSecure >= 3){
        if(isset($_SESSION['nameUser']) && isset($_SESSION['phoneUser'])){
            $uid = $_SESSION['phoneUser'];
        }

        require_once 'DataProvider.php';

        $sqlUser = "select * from user_account where phone = '$uid'";
        $listUser = DataProvider::execQuery($sqlUser);
        $rowUser = mysqli_fetch_assoc($listUser);

        $sqlCart = "select * from shopping_session ss where ss.user_id = '".$rowUser["id"]."'"; 
        $listCart = DataProvider::execQuery($sqlCart);
        $rowCart = mysqli_fetch_assoc($listCart);

        $sqlAddOrderDetail = "insert into order_detail values('".$rowCart["id"]."','".$rowUser["id"]."','".$rowCart["total_price"]."','$nameUser','$phoneUser','$addressUser','$messageUser',now(),now())";
        DataProvider::execQuery($sqlAddOrderDetail);

        $sqlCartItem = "select * from cart_item ci, shopping_session ss where ci.session_id = ss.id and ss.user_id = '".$rowUser["id"]."'";
        $listCartItem = DataProvider::execQuery($sqlCartItem);
        while($rowCartItem = mysqli_fetch_array($listCartItem, MYSQLI_ASSOC)){
            $sqlAddOrderItem = "insert into order_items values ('','".$rowCart["id"]."','".$rowCartItem["product_id"]."','".$rowCartItem["quantity"]."',now(),now())";
            DataProvider::execQuery($sqlAddOrderItem);
            $sqlDeteleCartItem = "delete from cart_item where product_id = '".$rowCartItem["product_id"]."'";
            DataProvider::execQuery($sqlDeteleCartItem);
        }
        $sqlDeleteSession = "delete from shopping_session where id = '".$rowCart["id"]."'";
        DataProvider::execQuery($sqlDeleteSession);

        echo "<script>alert('Cảm ơn bạn đã đặt hàng thành công')</script>";

        header("Location: /");
    }

    else{
        header('Location: /');
    }
?>