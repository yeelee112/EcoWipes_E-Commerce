<?php 
    $checkSecure = 0;

    if(isset($_POST["email"])){
        $email = $_POST["email"];
        $checkSecure++;
    }

    if($checkSecure > 0){
        require_once 'DataProvider.php';
        
        $sql = "select * from subscribe_email where email = '$email'";
        $list = DataProvider::execQuery($sql);
        $row = mysqli_num_rows($list);
        
        if ($row < 1) {
            $sqlEmailSubscribe = "insert into subscribe_email values ('$email', now());";
            DataProvider::execQuery($sqlEmailSubscribe);
            echo '<script>Swal.fire({
                html: "<strong>Đăng ký thành công!</strong>",
                icon: "success",
            });</script>';
        }
        else{
            echo '<script>Swal.fire({
                html: "<strong>Đăng ký thất bại!</strong>",
                icon: "error",
            });</script>';

        }
    }
?>