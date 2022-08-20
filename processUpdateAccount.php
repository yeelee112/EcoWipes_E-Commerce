<?php
    $checkAccountSession = false;
    if (!isset($_SESSION)) {
        session_start();
    }

    $uid = '';
    $checkSecure = 0;
    $priceTotal = 0;
    if (isset($_POST["name"])) {
        $fnameUser = $_POST["name"];
        $checkSecure++;
    }
    if (isset($_POST["phone"])) {
        $phoneUser = $_POST["phone"];
        $checkSecure++;
    }
    if (isset($_POST["email"])) {
        $emailUser = $_POST["email"];
        $checkSecure++;
    }
    if (isset($_POST["address"])) {
        $addressUser = $_POST["address"];
        $checkSecure++;
    }

    if (isset($_SESSION['nameUser']) && isset($_SESSION['phoneUser'])) {
        $nameUser = $_SESSION['nameUser'];
        $phone = $_SESSION['phoneUser'];
        $checkAccountSession = true;
    }
    require_once 'DataProvider.php';
    $sqlUser = "select * from user_account where phone = '$phone'";
    $listUser = DataProvider::execQuery($sqlUser);
    $rowUser = mysqli_fetch_assoc($listUser);

    if($checkAccountSession == true && $checkSecure > 0){
        $sqlUpdateAccount = "update user_account set email = '$emailUser', fullname = '$fnameUser', phone = '$phone', address = '$addressUser', updated_at = now() where id = '".$rowUser["id"]."'";
        DataProvider::execQuery($sqlUpdateAccount);

        $_SESSION['nameUser'] = $fnameUser;
        $_SESSION['phoneUser'] = $phone;
        echo "<script>alert('Cập nhật thành công!')</script>";
    }

?>