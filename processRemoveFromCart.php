<?php
    session_start();

    $checkSecure = 0;
    $priceTotal = 0;
    $priceShow = 0;
    $data = '';

    if(isset($_POST["id"])){
        $textProduct = $_POST["id"];
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
            $sqlDetele = "delete from cart_item where session_id = '".$rowBind["id"]."' and product_id = '".$rowProduct["id"]."'";
            DataProvider::execQuery($sqlDetele);

            $sql1 = "select * from shopping_session ss, cart_item ci, product p, image_product ip where ss.id = ci.session_id and ci.product_id = p.id and p.id = ip.product_id and ss.user_id = '".$rowUser["id"]."'";
            $list1 = DataProvider::execQuery($sql1);
            while ($row1 = mysqli_fetch_array($list1, MYSQLI_ASSOC)) {
            $priceTotal += $row1["price"] * $row1["quantity"];
            $priceShow = number_format($row1["price"], 0, ",", ".").' ₫';
            $data .= '<ul>
                        <li>
                            <div class="shopping-cart-img">
                                <a href="product?item='.$row1["product_text"].'"><img alt="'.$row1["product_name"].'" src="'.$row1["img_thumb"].'"></a>
                            </div>
                            <div class="shopping-cart-title">
                                <h4><a href="product?item='.$row1["product_text"].'">'.$row1["product_name"].'</a></h4>
                                <h4><span>'.$row1["quantity"].' × </span>'.$priceShow.'</h4> 
                            </div>
                            <div class="shopping-cart-delete">
                                <button class="btn-delete-cart-product" tyle="button" onclick="remove_from_cart(this.value);" value="'.$row1["product_text"].'"><i class="fi-rs-cross-small"></i></button>
                            </div>
                        </li>
                    </ul>';
            }

            $priceTotalShow = number_format($priceTotal, 0, ",", ".").' ₫';

            $sqlUpdateSessionTotalPrice = "update shopping_session set total_price = $priceTotal where user_id = '".$rowUser["id"]."'";
            DataProvider::execQuery($sqlUpdateSessionTotalPrice);

            echo $data.'
            <div class="shopping-cart-footer">
                <div class="shopping-cart-total">
                    <h4>Tổng cộng <span>'.$priceTotalShow.'</span></h4>
                </div>
                <div class="shopping-cart-button">
                    <a href="cart" class="outline">Xem giỏ hàng</a>
                    <a href="checkout">Thanh toán</a>
                </div>
            </div>';
        }
    }

    else{
        header('Location: /');
    }
?>