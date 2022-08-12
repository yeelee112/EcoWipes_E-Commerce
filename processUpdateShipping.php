<?php
    $shippingFee = 0;
    $shippingUrbanFee = 20000;
    $shippingSubUrbanFee = 40000;

    $freeShippingUrbanLevel = 300000;
    $freeShippingSubUrbanLevel = 500000;
    $checkSecure = 0;
    $percentageDescrease = 25;

    if(isset($_GET["city"])){
        $city = $_GET["city"];
        $checkSecure++;
    }
    if(isset($_GET["totalPrice"])){
        $totalPrice = $_GET["totalPrice"];
        $checkSecure++;
    }

    if($checkSecure == 2){
        if($city == 'Thành phố Hồ Chí Minh'){
            if($totalPrice >= $freeShippingUrbanLevel){
                echo 'Miễn phí';
            }
            else if($totalPrice < $freeShippingUrbanLevel){
                echo $shippingUrbanFee;
            }
            else{
                echo $shippingUrbanFee;
            }
        }
        else{
            if($totalPrice >= $freeShippingSubUrbanLevel){
                echo 'Miễn phí';
            }
            else if($totalPrice < $freeShippingSubUrbanLevel && $totalPrice > $freeShippingUrbanLevel){
                echo $shippingSubUrbanFee - ($shippingSubUrbanFee * ($percentageDescrease / 100));
            }
            else{
                echo $shippingSubUrbanFee;
            }
        }
    }
    else{
        header("Location: /");
    }
?>