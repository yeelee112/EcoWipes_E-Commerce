<?php
    session_start();

    $checkSecure = 0;
    $priceTotal = 0;
    $priceShow = 0;
    $data = '';
    $checkSecure = 0;
    $priceTotalProduct = 0;

    if(isset($_POST["id"])){
        $id = $_POST["id"];
        $checkSecure++;
    }
    if (isset($_POST["qty"])){
        $qtyProduct = $_POST["qty"];
        $checkSecure++;
    }

    if($checkSecure > 0){

        require_once 'DataProvider.php';

        if (isset($_SESSION['cart'])) {

            $sqlBind = "SELECT * FROM product p, image_product i WHERE p.id = i.product_id and p.product_text ='$id'";
            $listBind = DataProvider::execQuery($sqlBind);
            $rowBind = mysqli_fetch_array($listBind);

            if (mysqli_num_rows($listBind) > 0) {
                $_SESSION['cart'][$id]['quantity'] = $qtyProduct;
                
                $priceTotalProduct = $rowBind["price"] * $_SESSION['cart'][$id]['quantity'];

                $data = number_format($priceTotalProduct, 0, ",", ".") . ' ₫';
            }

            echo $data;
        }
        else{
            header('Location: /');
        }
    }
    else{
        header('Location: /');
    }
?>
