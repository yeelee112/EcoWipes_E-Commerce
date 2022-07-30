<?php
    session_start();

    $checkSecure = 0;
    $priceTotal = 0;
    $priceShow = 0;
    $data = '';
    $count = 0;

    if(isset($_POST["id"])){
        $textProduct = $_POST["id"];
        $checkSecure++;
    }

    if($checkSecure > 0){
        require_once 'DataProvider.php';
        unset($_SESSION['cart'][$textProduct]);
        
        foreach($_SESSION['cart'] as $id => $value){
            $count += $_SESSION['cart'][$id]['quantity'];
        }

        if($count > 0){
            $data = '';
        }

        else{
            $data = '<div>Chưa có sản phẩm nào trong giỏ hàng.</div>';

        }
        echo $data;

    }
    else{
        header('Location: /');
    }
?>