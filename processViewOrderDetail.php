<?php
    $checkSecure = 0;
    require_once "DataProvider.php";
    $dataHeader = '';
    $dataContent = '';
    $dataFooter = '';
    $priceTotal = 0;
    $priceTotalOrder = 0;
    $shippingFee = 0;
    $name = '';
    $phone = '';
    $address = '';
    $addressDetail = '';
    $statusOrder = 0;
    $paymentMethod = '';
    $dataStatus = '';

    if (isset($_POST["id"])) {
        $idOrder = $_POST["id"];
        $checkSecure++;
    }

    if ($checkSecure > 0) {


            $sql = "select * from order_detail od, order_items ot, product p, image_product ip where od.id = '$idOrder' and od.id = ot.order_id and ot.product_id = p.id and ip.product_id = p.id";
            $list = DataProvider::execQuery($sql);
            while ($row = mysqli_fetch_array($list, MYSQLI_ASSOC)) {
                $priceTotal += $row["price"] * $row["quantity"];
                $priceTotalOrder += $priceTotal;
                $shippingFee = $row["shipping_fee"];
                $name = $row["fullname"];
                $phone = $row["phone"];
                $address = $row["address"];
                $addressDetail = $row["address_detail"];
                $paymentMethod = $row["payment_method"];
                $statusOrder = $row["status_order"];
                $dataContent .= '<div class="cart-item">
                                <div class=" d-flex align-items-center text-start row">
                                    <div class="col-md-8 col-12">
                                        <div class="d-flex align-items-center"><a href="product?item='.$row["product_text"].'"><img class="cart-item-img" src="'.$row["img_thumb"].'" alt="'.$row["product_name"].'" /></a>
                                            <div class="cart-title text-start"><a class="text-uppercase text-dark text-product-cart" href="product?item='.$row["product_text"].'">'.$row["product_name"].'</a><span> x '.$row["quantity"].'</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4 mt-md-0 col-md-4 col-12">
                                        <div class="align-items-center row">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="d-md-none text-muted col-4">Tổng</div>
                                                    <div class="text-start col-md-12 col-8 text-total-price d-md-flex justify-content-end">
                                                    '.number_format($priceTotal, 0, ",", ".").' ₫
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                $priceTotal = 0;
            }

            $dataFooter = '<div class="cart-item">
                        <div class="row row-cols-1 price-container">
                            <div class="col d-flex justify-content-md-end align-items-md-center justify-content-between">
                                <div class="title-info-order-container">
                                    Tổng tiền hàng:
                                </div>
                                <div class="total-price-info-container text-total-price price-binding-width">
                                '.number_format($priceTotalOrder, 0, ",", ".").' ₫
                                </div>
                            </div>
                            <div class="col d-flex justify-content-md-end align-items-md-center justify-content-between">
                                <div class="title-info-order-container">
                                    Phí vận chuyển:
                                </div>
                                <div class="total-price-info-container text-total-price price-binding-width">
                                '.number_format($shippingFee, 0, ",", ".").' ₫
                                </div>
                            </div>
                            <div class="col d-flex justify-content-md-end align-items-md-center pb-20 mt-10">
                                <div class="title-info-order-container total-price-text">
                                    Thành tiền:
                                </div>
                                <div class="total-price-info-container total-price-info-order">
                                '.number_format($priceTotalOrder + $shippingFee, 0, ",", ".").' ₫
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';

            if($statusOrder == 2){
                $dataStatus = '<h4><div class="done-order mb-20">Đã hoàn thành</div></h4>';
            }
            else if($statusOrder == 1){
                $dataStatus = '<h4><div class="confirm-order mb-20">Đã xác nhận</div></h4>';
            }
            else{
                $dataStatus = '<h4><div class="unconfirm-order mb-20">Chưa xác nhận</div></h4>';
            }

            $dataHeader = '
            <div class="info-order-user">
                <div class="row">
                    <div class="col-12 pb-10">
                        '.$dataStatus.'
                        <h4>Thông tin nhận hàng<span></h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h6 style="font-weight:500">'.$name.' - '.$phone.'</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 pt-10">
                        <h6 style="font-weight:500">'.$addressDetail.' - '.$address.'</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 pt-10">
                        <h6 style="font-weight:500">Phương thức thanh toán: '.$paymentMethod.'</h6>
                    </div>
                </div>
            </div>

            <div class="cart">
                <div class="cart-header middle-text">
                    <div class="row">
                        <div class="col-md-5">
                            <div>Đơn hàng</div>
                        </div>
                        <div class="d-none d-md-block col">
                            <div class="row">
                                <div class="col-12 d-flex justify-content-end">Tổng</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cart-body">';

            echo $dataHeader.$dataContent.$dataFooter;
        }
?>