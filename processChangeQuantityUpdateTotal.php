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
            
            $sqlTotal = "select * from shopping_session ss where ss.user_id = '".$rowUser["id"]."'";
            $listTotal = DataProvider::execQuery($sqlTotal);
            $rowTotal = mysqli_fetch_assoc($listTotal); 

            $totalPrice = number_format($rowBind["total_price"], 0, ",", ".").' ₫';
            $data .= '<div class="row">
                                <div class="col-6">
                                    <p class="order-summary-label">Tạm tính</p>
                                </div>
                                <div class="col-6 text-end">
                                    <p class="order-summary-value">'.$totalPrice.'</p>
                                    <input type="hidden" class="input-sub-total" value="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <p class="ship-summary-label">Vận chuyển</p>
                                </div>
                                <div class="col-6 text-end">
                                    <p class="ship-summary-value">Chưa xác định</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <p class="total-summary-label">Tổng cộng</p>
                                </div>
                                <div class="col-6 text-end">
                                    <p class="total-summary-value">'.$totalPrice.'<span> *</span></p>
                                    <p class="sup-total-summary-label">(Không bao gồm phí ship)</p>
                                    <input type="hidden" class="input-total-summary" value="">
                                </div>
                            </div>';

            echo $data;
        }
    }
?>