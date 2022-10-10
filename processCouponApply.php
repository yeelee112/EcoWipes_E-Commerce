<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    if (isset($_POST["coupon"])) {
        $coupon = $_POST["coupon"];
    }

    require_once "DataProvider.php";

    $sql = "select * from coupon where coupon_code = '$coupon'";
    $list = DataProvider::execQuery($sql);
    $row = mysqli_fetch_assoc($list);

    if (mysqli_num_rows($list) > 0) {
        $_SESSION['coupon'] = $row["coupon_code"];
        
        echo '<strong style="color:#72be44;">Áp dụng mã thành công<strong>';
    }
    else{
        echo '<strong style="color:red">Áp dụng mã thất bại</strong>';
    }
?>