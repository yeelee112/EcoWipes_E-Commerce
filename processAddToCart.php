<?php
    session_start();
    $qtyProduct = 1;
    $data = '';
    $priceTotal = 0;
    $checkSecure = 0;

    if(isset($_POST["id"])){
        $id = $_POST["id"];
        $checkSecure++;
    }
    
    if (isset($_POST["qty"])){
        $qtyProduct = $_POST["qty"];
        $checkSecure++;
    }

    if ($checkSecure >= 1) {
        require_once 'DataProvider.php';
        $sql= "select * from product p, image_product i where p.id = i.product_id and p.product_text = '$id'";
        $list = DataProvider::execQuery($sql);
        $row = mysqli_fetch_array($list, MYSQLI_ASSOC);

        if(isset($_SESSION['cart'][$id])){ 
            $_SESSION['cart'][$id]['quantity']+= $qtyProduct;

            if(isset($_SESSION['cart'])){ 
          
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
                header('Location: /');
            }
        }
        else{ 
            if(mysqli_num_rows($list) > 0){ 
                $_SESSION['cart'][$row['product_text']]=array( 
                    "quantity" => $qtyProduct, 
                    "price" => $row['price'] 
                );

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
                header('Location: /');
            } 
        } 

        // if(mysqli_num_rows($list) > 0){
        //     if(isset($_SESSION['nameUser']) && isset($_SESSION['phoneUser'])){
        //         $uid = $_SESSION['phoneUser'];
                
        //         $sqlUser = "select * from user_account where phone = '$uid'";
        //         $listUser = DataProvider::execQuery($sqlUser);
        //         $rowUser = mysqli_fetch_assoc($listUser);

        //         $sqlCart = "select * from shopping_session where user_id = '".$rowUser["id"]."'";
        //         $listCart = DataProvider::execQuery($sqlCart);
        //         $rowCart = mysqli_fetch_assoc($listCart);

        //         if(mysqli_num_rows($listCart) < 1){
        //             $sqlAddCart = "insert into shopping_session values('','".$rowUser["id"]."','',now(),now());";
        //             DataProvider::execQuery($sqlAddCart);

        //             $sqlFindIdSession = "select id from shopping_session where user_id = '".$rowUser["id"]."'";
        //             $listFindIdSession = DataProvider::execQuery($sqlFindIdSession);
        //             $rowlistFindIdSession = mysqli_fetch_assoc($listFindIdSession);

        //             $sqlAddCartItem = "insert into cart_item values('','".$rowlistFindIdSession["id"]."','".$rowUser["id"]."','$qtyProduct',now(),now());";
        //             DataProvider::execQuery($sqlAddCartItem);

        //         }
        //         else{
        //             $sqlFindIdSession = "select * from cart_item where session_id = '".$rowCart["id"]."' and product_id = '".$row["id"]."'";
        //             $listFindIdSession = DataProvider::execQuery($sqlFindIdSession);
        //             $rowlistFindIdSession = mysqli_fetch_assoc($listFindIdSession);

        //             if(mysqli_num_rows($listFindIdSession) < 1){
        //                 $sqlCartItem = "insert into cart_item values('','".$rowCart["id"]."','".$row["id"]."','$qtyProduct',now(),now());";
        //                 DataProvider::execQuery($sqlCartItem);
        //             }
        //             else{
        //                 $newQty = $rowlistFindIdSession["quantity"] + $qtyProduct;
        //                 $sqlCartItem = "update cart_item set quantity = $newQty, updated_at = now() where product_id = '".$row["id"]."'";
        //                 DataProvider::execQuery($sqlCartItem);
        //             }
        //         }


        //         $sql1 = "select * from shopping_session ss, cart_item ci, product p, image_product ip where ss.id = ci.session_id and ci.product_id = p.id and p.id = ip.product_id and ss.user_id = '".$rowUser["id"]."'";
        //         $list1 = DataProvider::execQuery($sql1);
        //         while ($row1 = mysqli_fetch_array($list1, MYSQLI_ASSOC)) {
        //         $priceTotal += $row1["price"] * $row1["quantity"];
        //         $priceShow = number_format($row1["price"], 0, ",", ".").' ₫';
        //         $data .= '<ul>
        //                     <li>
        //                         <div class="shopping-cart-img">
        //                             <a href="product?item='.$row1["product_text"].'"><img alt="'.$row1["product_name"].'" src="'.$row1["img_thumb"].'"></a>
        //                         </div>
        //                         <div class="shopping-cart-title">
        //                             <h4><a href="product?item='.$row1["product_text"].'">'.$row1["product_name"].'</a></h4>
        //                             <h4><span>'.$row1["quantity"].' × </span>'.$priceShow.'</h4> 
        //                         </div>
        //                         <div class="shopping-cart-delete">
        //                             <button class="btn-delete-cart-product" tyle="button" onclick="remove_from_cart(this.value);" value="'.$row1["product_text"].'"><i class="fi-rs-cross-small"></i></button>
        //                         </div>
        //                     </li>
        //                 </ul>';
        //         }

        //         $priceTotalShow = number_format($priceTotal, 0, ",", ".").' ₫';
        //         $sqlUpdateSessionTotalPrice = "update shopping_session set total_price = $priceTotal, updated_at = now() where user_id = '".$rowUser["id"]."'";
        //         DataProvider::execQuery($sqlUpdateSessionTotalPrice);

        //         echo $data.'
        //         <div class="shopping-cart-footer">
        //             <div class="shopping-cart-total">
        //                 <h4>Tổng cộng <span>'.$priceTotalShow.'</span></h4>
        //             </div>
        //             <div class="shopping-cart-button">
        //                 <a href="cart" class="outline">Xem giỏ hàng</a>
        //                 <a href="checkout">Thanh toán</a>
        //             </div>
        //         </div>';
        //     }
        // }
    }
    else{
        header('Location: /');
    }
?>
