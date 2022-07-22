<?php
    session_start();

    $checkSecure = 0;
    $priceTotal = 0;
    $priceShow = 0;
    $data = '';
    $checkSecure = 0;

    if(isset($_POST["id"])){
        $textProduct = $_POST["id"];
        $checkSecure++;
    }
    if (isset($_POST["qty"])){
        $qtyProduct = $_POST["qty"];
        $checkSecure++;
    }

    if($checkSecure > 0){
        if(isset($_SESSION['nameUser']) && isset($_SESSION['phoneUser'])){
            $uid = $_SESSION['phoneUser'];
        }

        require_once 'DataProvider.php';

        $sqlUser = "select * from user_account where phone = '$uid'";
        $listUser = DataProvider::execQuery($sqlUser);
        $rowUser = mysqli_fetch_assoc($listUser);

        $sqlProduct = "select * from product where product_text = '$textProduct'";
        $listProduct = DataProvider::execQuery($sqlProduct);
        $rowProduct = mysqli_fetch_assoc($listProduct);

        $sqlBind = "select * from shopping_session ss where ss.user_id = '".$rowUser["id"]."'";
        $listBind = DataProvider::execQuery($sqlBind);
        $rowBind = mysqli_fetch_assoc($listBind);

        if(mysqli_num_rows($listBind) > 0){
            $sqlUpdateQuantity = "update cart_item set quantity = $qtyProduct where product_id = '".$rowProduct["id"]."'";
            DataProvider::execQuery($sqlUpdateQuantity);
            
            $priceTotalProduct = 0;
            $priceTotalCart = 0;
            $sql1 = "select * from shopping_session ss, cart_item ci, product p, image_product ip where ss.id = ci.session_id and ci.product_id = p.id and p.id = ip.product_id and ss.user_id = '".$rowUser["id"]."'";
            $list1 = DataProvider::execQuery($sql1);
            while ($row1 = mysqli_fetch_array($list1, MYSQLI_ASSOC)) {
                if($row1["product_text"] == $textProduct){
                    $priceTotalProduct += $row1["price"] * $row1["quantity"];
                    $data = number_format($priceTotalProduct, 0, ",", ".").' ₫';
                }
                $priceTotalCart += $row1["price"] * $row1["quantity"];
            }

            $sqlUpdateSessionTotalPrice = "update shopping_session set total_price = $priceTotalCart where user_id = '".$rowUser["id"]."'";
            DataProvider::execQuery($sqlUpdateSessionTotalPrice);

            echo $data;
        }
    }
?>