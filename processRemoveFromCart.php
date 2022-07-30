<?php
    session_start();
    
    $checkSecure = 0;
    $priceTotal = 0;
    $priceShow = 0;
    $data = '';
    $count = 0;

    if(isset($_POST["id"])){
        $id = $_POST["id"];
        $checkSecure++;
    }

    if($checkSecure > 0){
        require_once 'DataProvider.php';
        unset($_SESSION['cart'][$id]);
        
        foreach($_SESSION['cart'] as $id => $value){
            $count += $_SESSION['cart'][$id]['quantity'];
        }
        
        if($count > 0){
            $sql1="SELECT * FROM product p, image_product i WHERE p.id = i.product_id and p.product_text IN ("; 
                    
            foreach($_SESSION['cart'] as $id => $value) { 
                $sql1.="'".$id."',"; 
            } 
                    
            $sql1 = substr($sql1, 0, -1).")"; 
            $list1 = DataProvider::execQuery($sql1);

            while($row1 = mysqli_fetch_array($list1, MYSQLI_ASSOC)){
                /* <p><?php echo $row1['name'] ?> x <?php echo $_SESSION['cart'][$row['id_product']]['quantity'] ?></p>  */
                $priceTotal += $row1["price"] * $_SESSION['cart'][$row1['product_text']]['quantity'];
                $priceShow = number_format($row1["price"], 0, ",", ".").' ₫';
                $data .= '<ul>
                            <li>
                                <div class="shopping-cart-img">
                                    <a href="product?item='.$row1["product_text"].'"><img alt="'.$row1["product_name"].'" src="'.$row1["img_thumb"].'"></a>
                                </div>
                                <div class="shopping-cart-title">
                                    <h4><a href="product?item='.$row1["product_text"].'">'.$row1["product_name"].'</a></h4>
                                    <h4><span>'.$_SESSION['cart'][$row1['product_text']]['quantity'].' × </span>'.$priceShow.'</h4> 
                                </div>
                                <div class="shopping-cart-delete">
                                    <button class="btn-delete-cart-product" tyle="button" onclick="remove_from_cart(this.value);" value="'.$row1["product_text"].'"><i class="fi-rs-cross-small"></i></button>
                                </div>
                            </li>
                        </ul>';
            }

            $priceTotalShow = number_format($priceTotal, 0, ",", ".").' ₫';

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
        else{
            echo '<div>Chưa có sản phẩm nào trong giỏ hàng.</div>';
        } 
    }
    else{
        header('Location: /');
    }
?>