<?php
    $shippingUrbanFee = 20000;
    $shippingSubUrbanFee = 40000;

    $freeShippingUrbanLevel = 300000;
    $freeShippingSubUrbanLevel = 500000;
    $checkSecure = 0;
    $percentageDecrease = 25;
    $dataDiscount = '';
    $shippingFee = 0;
    $shippingDiscount = 0;
    $shippingFeeText = '';
    $priceTotalCart = 0;
    $data = '';

    if(isset($_POST["city"])){
        $city = $_POST["city"];
        $checkSecure++;
    }
    if(isset($_POST["totalPrice"])){
        $totalPrice = $_POST["totalPrice"];
        $checkSecure++;
    }

    if($checkSecure == 2){
        if($city == 'Thành phố Hồ Chí Minh'){
            if($totalPrice >= $freeShippingUrbanLevel){
                $shippingFee = 'Miễn phí';
            }
            else{
                $shippingFee = $shippingUrbanFee;
            }
        }
        else{
            if($totalPrice >= $freeShippingSubUrbanLevel){
                $shippingFee = 'Miễn phí';
            }
            else if($totalPrice < $freeShippingSubUrbanLevel && $totalPrice > $freeShippingUrbanLevel){
                // echo $shippingSubUrbanFee - ($shippingSubUrbanFee * ($percentageDescrease / 100));
                $shippingFee = $shippingSubUrbanFee;
                $shippingDiscount = ($shippingSubUrbanFee * ($percentageDecrease / 100));
                $dataDiscount = '
                <div class="col d-flex justify-content-md-end align-items-md-center">   
                    <div class="title-checkout-container discount-shipping-fee">
                        Giảm giá phí vận chuyển:
                    </div>
                    <div class="total-price-checkout-container text-total-price price-binding-width discount-shipping-fee">
                        -'.number_format($shippingDiscount, 0, ",", ".").' ₫
                    </div>
                </div>
                ';
            }
            else{
                $shippingFee = $shippingSubUrbanFee;
            }
        }
        
        if(ctype_digit(strval($shippingFee))){
            $shippingFeeText = number_format($shippingFee, 0, ",", ".")." ₫";
        }
        else{
            $shippingFeeText = $shippingFee;
        }
        
        $priceTotalCart  = intval($totalPrice) + intval($shippingFee) - $shippingDiscount;

        $data = '<div class="col d-flex justify-content-md-end align-items-md-center">
                <div class="title-checkout-container">
                    Tổng tiền hàng:
                </div>
                <div class="total-price-checkout-container text-total-price price-binding-width">
                    '.number_format($totalPrice, 0, ",", ".").' ₫
                </div>
            </div>
            <div class="col d-flex justify-content-md-end align-items-md-center">
                <div class="title-checkout-container">
                    Phí vận chuyển:
                </div>
                <div class="total-price-checkout-container text-total-price shipping-price price-binding-width">
                    '.$shippingFeeText.'
                </div>
            </div>
            '.$dataDiscount.'
            <div class="col d-flex justify-content-md-end align-items-md-center pb-20 mt-10">
                <div class="title-checkout-container total-price-text">
                    Thành tiền:
                </div>
                <div class="total-price-checkout-container total-price">
                    '.number_format($priceTotalCart, 0, ",", ".").' ₫
                </div>
            </div>
            <script>
                var totalPrice = $(".total-price").width();
                $(".price-binding-width").width(totalPrice);
            </script>';
            $results = array(
                'html' => $data,
                'shippingFee' => intval($shippingFee),
            );
            $dataReturns = json_encode($results);
            echo $dataReturns;

    }
    else{
        header("Location: /");
    }
?>