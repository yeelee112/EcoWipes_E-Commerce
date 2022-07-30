<?php
    session_start();

    $checkSecure = 0;
    $priceTotal = 0;
    $priceShow = 0;
    $data = '';
    $checkSecure = 0;
    $count = 0;
    if(isset($_POST["id"])){
        $id = $_POST["id"];
        $checkSecure++;
    }

    if ($checkSecure > 0) {
        require_once 'DataProvider.php';

        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $id => $value) {
                $count += $_SESSION['cart'][$id]['quantity'];
            }
            
            if ($count > 0) {

                $sql1 = "SELECT * FROM product p, image_product i WHERE p.id = i.product_id and p.product_text IN (";

                foreach ($_SESSION['cart'] as $id => $value) {
                    $sql1 .= "'" . $id . "',";
                }

                $sql1 = substr($sql1, 0, -1) . ")";
                $list1 = DataProvider::execQuery($sql1);

                while ($row1 = mysqli_fetch_array($list1, MYSQLI_ASSOC)) {
                    /* <p><?php echo $row1['name'] ?> x <?php echo $_SESSION['cart'][$row['id_product']]['quantity'] ?></p>  */
                    $priceTotal += $row1["price"] * $_SESSION['cart'][$row1['product_text']]['quantity'];
                }

                $priceShow = number_format($priceTotal, 0, ",", ".") . ' ₫';
                $data = '<div class="row">
                            <div class="col-6">
                                <p class="order-summary-label">Tạm tính</p>
                            </div>
                            <div class="col-6 text-end">
                                <p class="order-summary-value">' . $priceShow . '</p>
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
                                <p class="total-summary-value">' . $priceShow . '<span> *</span></p>
                                <p class="sup-total-summary-label">(Không bao gồm phí ship)</p>
                                <input type="hidden" class="input-total-summary" value="">
                            </div>
                        </div>';

                echo $data;
            }
            else{
                $priceShow = number_format('0', 0, ",", ".") . ' ₫';
                $data = '<div class="row">
                            <div class="col-6">
                                <p class="order-summary-label">Tạm tính</p>
                            </div>
                            <div class="col-6 text-end">
                                <p class="order-summary-value">' . $priceShow . '</p>
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
                                <p class="total-summary-value">' . $priceShow . '<span> *</span></p>
                                <p class="sup-total-summary-label">(Không bao gồm phí ship)</p>
                                <input type="hidden" class="input-total-summary" value="">
                            </div>
                        </div>';

                echo $data;
            }
        } else {
            header('Location: /');
        }
    }
?>