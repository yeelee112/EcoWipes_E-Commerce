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
            $sqlUpdateQuantity = "update cart_item set quantity = $qtyProduct, updated_at = now() where product_id = '".$rowProduct["id"]."'";
            DataProvider::execQuery($sqlUpdateQuantity);
            
            $priceTotalWithNoReset = 0;
            $priceTotal = 0;
            $sql1 = "select * from shopping_session ss, cart_item ci, product p, image_product ip where ss.id = ci.session_id and ci.product_id = p.id and p.id = ip.product_id and ss.user_id = '".$rowUser["id"]."'";
            $list1 = DataProvider::execQuery($sql1);
            while ($row1 = mysqli_fetch_array($list1, MYSQLI_ASSOC)) {
            $priceTotal += $row1["price"] * $row1["quantity"];
            $priceTotalWithNoReset += $row1["price"] * $row1["quantity"];
            $priceTotalShow = number_format($priceTotal, 0, ",", ".").' ₫';
            $priceShow = number_format($row1["price"], 0, ",", ".").' ₫';
            $data .= '
            <div class="cart-item">
                <div class=" d-flex align-items-center text-start row">
                    <div class="col-md-5 col-12">
                        <div class="d-flex align-items-center"><a href="product?item='.$row1["product_text"].'"><img class="cart-item-img" src="'.$row1["img_thumb"] .'" alt="..." /></a>
                            <div class="cart-title text-start"><a class="text-uppercase text-dark text-product-cart" href="product?item='.$row1["product_text"].'">'.$row1["product_name"].'</a>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 mt-md-0 col-md-7 col-12">
                        <div class="align-items-center row">
                            <div class="col-md-3 mt-5 mb-5">
                                <div class="row align-items-center">
                                    <div class="d-md-none text-muted col-6">Giá</div>
                                    <div class="text-start col-md-12 col-6 price-per-item">
                                        <input type="hidden" class="hidden-input" value="'.$row1["price"].'">
                                        <div class="first-price">'.$priceShow.'</div>
                                        <!-- <div class="original-price">40.000 đ</div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mt-5 mb-5">
                                <div class="align-items-center row">
                                    <div class="d-md-none text-muted col-md-12 col-6">Số lượng</div>
                                    <div class="col-md-12 col-sm-3 col-5">
                                        <div class="detail-qty mb-0">
                                            <input type="hidden" class="hidden-product-text" value="'.$row1["product_text"].'">
                                            <a class="btn-items btn-items-decrease border"><i class="fa-solid fa-minus"></i></a>
                                            <input class="qty-val border" id="qty-val" value="'.$row1["quantity"].'" min="1" type="number" inputmode="numeric" max="90" oninput="this.value = Math.abs(this.value)"></input>
                                            <a class="btn-items btn-items-increase border"><i class="fa-solid fa-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mt-5 mb-5">
                                <div class="row">
                                    <div class="d-md-none text-muted col-6">Tổng</div>
                                    <div class="text-start col-md-12 col-6 text-total-price">
                                        '.$priceTotalShow.'
                                    </div>
                                </div>
                            </div>
                            <div class="d-none d-md-block text-center col-2">
                                <a class="cart-remove" href="#">Xóa</a>
                            </div>
                            <a class="cart-remove close text-md-center mt-3 d-md-none" href="#">Xóa</a>
                        </div>
                    </div>
                </div>
            </div>';
            $priceTotal = 0;
            }

            $sqlUpdateSessionTotalPrice = "update shopping_session set total_price = $priceTotalWithNoReset, updated_at = now() where user_id = '".$rowUser["id"]."'";
            DataProvider::execQuery($sqlUpdateSessionTotalPrice);

            echo $data;
        }
    }

    else{
        header('Location: /');
    }
?>