<?php

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['idUser'])) {
    header("Location: /");
}

require_once 'DataProvider.php';

$mysqli = DataProvider::getConnection();

if (isset($_GET['email'])) {
    $email = mysqli_real_escape_string($mysqli, $_GET["email"]);
}

if (isset($_GET['token'])) {
    $token = mysqli_real_escape_string($mysqli, $_GET["token"]);
}

$sql = "select * from account_admin where admin_email = '$email' and token = '$token'";
$list = DataProvider::execQuery($sql);
$numRow = mysqli_num_rows($list);

if ($numRow == 0) {
    header("Location: /");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Quên mật khẩu - Thế Giới Khăn Ướt | EcoWipes</title>
    <?php require_once 'library.php'; ?>
    <style>
        .loading-gif {
            background-image: url("assets/imgs/icon/loading.gif");
            background-position: left;
            background-repeat: no-repeat;
            background-size: contain;
            float: left;
            width: 24px;
            height: 24px;
            margin-right: 10px;
            display: none;
        }
    </style>
</head>

<body>
    <?php require_once 'header.php' ?>
    <main class="main pages">
        <div class="page-content pt-50 pb-150">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-8 col-md-12 m-auto">
                        <div class="row">
                            <div class="heading_s1">
                                <img class="border-radius-15" src="assets/imgs/page/reset_password.svg" alt>
                                <h2 class="mb-15 mt-15">Đặt lại mật khẩu mới</h2>
                                <p class="mb-30">Lần này hãy nhớ kỹ mật khẩu nhé!</p>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="login_wrap widget-taber-content background-white">
                                    <div class="padding_eight_all bg-white">
                                        <form method="post" id="new-password">
                                            <div class="mb-3">
                                                <label for="password" class="form-label">Mật khẩu *</label>
                                                <div class="input-group mb-3">
                                                    <input type="password" class="form-control" id="password" name="password" value="<?php echo !empty($postData['password']) ? $postData['password'] : ''; ?>" required>
                                                    <span class="input-group-text">
                                                        <i class="far fa-eye-slash togglePassword" style="cursor: pointer"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <input type="hidden" name="email" value="<?php echo $email ?>">
                                            <input type="hidden" name="token" value="<?php echo $token ?>">
                                            <div class="mb-3">
                                                <label for="confirm-password" class="form-label">Xác nhận lại mật khẩu *</label>
                                                <div class="input-group mb-3">
                                                    <input type="password" class="form-control" id="confirm-password" name="confirm-password" value="<?php echo !empty($postData['confirm_password']) ? $postData['confirm_password'] : ''; ?>" required>
                                                    <span class="input-group-text">
                                                        <i class="far fa-eye-slash togglePassword" style="cursor: pointer"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-heading btn-block hover-up" name="login">Đặt lại mật khẩu</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>
<?php require_once 'footer.php' ?>
<?php require_once 'script.php' ?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $("#new-password").submit(function(e) {
        e.preventDefault();
        $.ajax({
                method: "POST",
                url: "processNewPassword",
                data: $("#new-password").serialize(),
                // dataType:"json",
            })
            .done(function(data) {
                if (data == true) {
                    Swal.fire({
                        html: "<strong>Cập nhật mật khẩu thành công</strong><br> <div class='mt-10' style='font-size:16px;'>Bạn sẽ tự động trở về trang đăng nhập sau 3 giây<div>",
                        icon: "success",
                        timerProgressBar: true,
                        timer: 3000,
                        didOpen: () => {
                            Swal.showLoading()
                            const b = Swal.getHtmlContainer().querySelector('b')
                            timerInterval = setInterval(() => {
                                // b.textContent = Swal.getTimerLeft()
                            }, 100)
                        },
                        willClose: () => {
                            clearInterval(timerInterval);
                            location.href = "/login";
                        }
                    });
                }
                if (data == false) {
                    Swal.fire({
                        html: "<strong>Cập nhật mật khẩu thành công!</strong><br>",
                        icon: "error",
                    });
                }
            });
    });
</script>

</html>