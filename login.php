<?php 
    require_once 'functionPhp.php';
    require_once 'DataProvider.php';
    $postData = $statusLogin = $statusRegister = $status = '';
    $msgClass = 'errordiv';
    $expire = 365*24*3600; // We choose a one year duration
    ini_set('session.gc_maxlifetime', $expire);
    session_start();
    setcookie(session_name(),session_id(),time()+$expire); 
    if (isset($_SESSION['nameUser']) && isset($_SESSION['phoneUser'])) {
        header("Location: /");
    }

    $errorForm = 0;

    $mysqli = DataProvider::getConnection();
    $postData = $_POST;
    if(isset($_POST['submitSignin'])){
        $phone = $_POST['phone'];
        $password = $_POST['password'];

        if (!empty($phone) && !empty($password)) {
            $phone = mysqli_real_escape_string($mysqli, $phone);
            $password = md5($password);


            require_once 'DataProvider.php';
            $sql = "select * from user_account a where a.phone = '$phone' and a.user_password = '$password'";
            $list = DataProvider::execQuery($sql);

            $row = mysqli_fetch_assoc($list);

            $numRow = mysqli_num_rows($list);

            if($numRow === 1){
                if($row["phone"] == $phone && $row["user_password"] == $password){
                    $_SESSION['nameUser'] = $row["fullname"];
                    $_SESSION['phoneUser'] = $row['phone'];
                    if(isset($_SESSION['rewindURL']) && !empty($_SESSION['rewindURL'])){
                        $rewindUrl = $_SESSION['rewindURL'];
                        header("Location: $rewindUrl");
                    }
                    else{
                        header("Location: /");
                    }
                }
                else{
                    $statusLogin = 'Số điện thoại hoặc mật khẩu không hợp lệ. Vui lòng thử lại.';
                }
            }
            else{
                $statusLogin = 'Số điện thoại hoặc mật khẩu không hợp lệ. Vui lòng thử lại.';
            }
        }
        else{
            $statusLogin = 'Số điện thoại hoặc mật khẩu không hợp lệ. Vui lòng thử lại.';
        }
    }

    if (isset($_POST['submitSignup'])) {
        $errorForm = 1;
        $fullname = $_POST['name'];
        $email  = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $repassword = $_POST['confirm_password'];

        if (!empty($fullname) && !empty($email) && !empty($password) && !empty($repassword)) {
            $email = mysqli_real_escape_string($mysqli, $email);

            require_once 'DataProvider.php';
            $sql = "select * from user_account a where a.phone = '$phone'";
            $list = DataProvider::execQuery($sql);
            $numRow = mysqli_num_rows($list);

            if ($numRow === 0) {
                if ($password == $repassword) {
                    $password = md5($password);

                    $sql = "insert into user_account values ('','$email','$password','$fullname','$phone',NOW(),NOW())";
                    $list = DataProvider::execQuery($sql);
                    $_SESSION['nameUser'] = $fullname;
                    $_SESSION['phoneUser'] = $phone;
                    header("Location: /");
                } 
                else {
                    $statusRegister = 'Mật khẩu và xác nhận mật khẩu không trùng nhau. Vui lòng thử lại.';
                }
            } 
            else {
                $statusRegister = 'Email này đã được đăng ký. Vui lòng thử với email khác.';
            }
        }
        else {
            $statusRegister = 'Vui lòng điền đầy đủ thông tin.';
        }
    }
?>

<!DOCTYPE html>
<html class="no-js" lang="vi">

<head>
    <meta charset="utf-8">
    <title>EcoWipes | E-Commerce</title>
    <?php
    require_once 'library.php';
    ?>
    <link rel="stylesheet" href="assets/css/eco.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/regular.min.css" integrity="sha512-YoxvmIzlVlt4nYJ6QwBqDzFc+2aXL7yQwkAuscf2ZAg7daNQxlgQHV+LLRHnRXFWPHRvXhJuBBjQqHAqRFkcVw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .nav-tabs {
            margin-bottom: 0px;
        }

        .nav-tabs .nav-link:hover {
            transform: translateY(0px);
        }

        .nav-tabs .nav-link {
            margin-bottom: -1px;
            background: 0 0;
            border: 1px solid transparent;
            border-top-left-radius: .25rem;
            border-top-right-radius: .25rem;
            padding: 15px 24px !important;
        }

        .nav-tabs .nav-link:first-child {
            padding: 15px 24px !important;

        }

        .nav-tabs .nav-link:focus,
        .nav-tabs .nav-link:hover {
            border-color: #e9ecef #e9ecef #dee2e6;
            isolation: isolate
        }

        .nav-tabs .nav-link.disabled {
            color: #6c757d;
            background-color: transparent;
            border-color: transparent;
        }

        .nav-tabs .nav-item.show .nav-link,
        .nav-tabs .nav-link.active {
            color: #495057;
            background-color: #fff;
            border-color: #dee2e6 #dee2e6 #fff;
            font-weight: 800 !important;
        }

        .nav-tabs .nav-link:hover {
            background: white;
        }

        .form-control:focus {
            border: 1px solid #72be44;
        }

        .form-control {
            border: 1px solid #d7dcd5;
        }
    </style>

</head>

<body>
    <?php
    require_once 'header.php';
    ?>

    <body>
        <?php require_once 'header.php' ?>
        <div class="cart-heading">
            <div class="container">
                <div class="cart-heading-container">
                    <div class="heading-cart middle-text">
                        <h1 class="cart-title">Tài khoản</h1>
                        <p>Đăng nhập tài khoản, đăng ký tài khoản mới</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="login-container">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-8">
                        <ul class="nav nav-tabs d-flex justify-content-center" id="loginPage" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?php if ($errorForm == 0) {
                                                            echo "active";
                                                        } ?>" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab" aria-controls="home" aria-selected="true">
                                    ĐĂNG NHẬP
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?php if ($errorForm == 1) {
                                                            echo "active";
                                                        } ?>" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab" aria-controls="profile" aria-selected="false">
                                    ĐĂNG KÝ
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content" id="loginTab">
                            <div class="tab-pane <?php if ($errorForm == 0) {
                                                        echo "show active";
                                                    } ?>" id="login" role="tabpanel" aria-labelledby="login-tab">
                                <form method="POST" action="login" class="form-container" enctype="multipart/form-data">
                                    <div class="mb-3 pt-3">
                                        <?php
                                        if (!empty($statusLogin)) { ?>
                                            <p class="statusLogin <?php echo !empty($msgClass) ? $msgClass : ''; ?>"><?php echo $statusLogin; ?></p>
                                        <?php } ?>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Số điện thoại</label>
                                        <input type="number" class="form-control" id="phone" name="phone" aria-describedby="emailHelp" value="<?php echo !empty($postData['phone']) ? $postData['phone'] : ''; ?>" required="">
                                        <div id="emailHelp" class="form-text">
                                            Chúng tôi sẽ không bao giờ tiết lộ thông tin của bạn.
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Mật khẩu</label>
                                        <div class="input-group mb-3">
                                            <input class="form-control password" id="password" class="block mt-1 w-full" type="password" name="password" required />
                                            <span class="input-group-text">
                                                <i class="far fa-eye-slash togglePassword" style="cursor: pointer"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <button name="submitSignin" id="submit-login" class="btn-full-width">ĐĂNG NHẬP</button>
                                </form>
                            </div>
                            <div class="tab-pane <?php if ($errorForm == 1) {
                                                        echo "show active";
                                                    } ?>" id="register" role="tabpanel" aria-labelledby="register-tab">
                                <form method="POST" action="" class="form-container" enctype="multipart/form-data">
                                    <div class="mb-3 pt-3">
                                        <?php
                                        if (!empty($statusRegister)) { ?>
                                            <p class="statusRegister <?php echo !empty($msgClass) ? $msgClass : ''; ?>"><?php echo $statusRegister; ?></p>
                                        <?php } ?>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Số điện thoại *</label>
                                        <input type="number" class="form-control" id="phone" name="phone" value="<?php echo !empty($postData['phone']) ? $postData['phone'] : ''; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="fullname" class="form-label">Họ tên *</label>
                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo !empty($postData['name']) ? $postData['name'] : ''; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Địa chỉ Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo !empty($postData['email']) ? $postData['email'] : ''; ?>" required="">
                                        <div id="emailHelp" class="form-text">
                                            Bạn sẽ nhận được nhiều ưu đãi hơn nhờ Email nhé!!
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Mật khẩu *</label>
                                        <div class="input-group mb-3">
                                            <input type="password" class="form-control" id="password" name="password" value="<?php echo !empty($postData['password']) ? $postData['password'] : ''; ?>" required>
                                            <span class="input-group-text">
                                                <i class="far fa-eye-slash togglePassword" style="cursor: pointer"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="confirm_password" class="form-label">Xác nhận lại mật khẩu *</label>
                                        <div class="input-group mb-3">
                                            <input type="password" class="form-control" id="password" name="confirm_password" value="<?php echo !empty($postData['confirm_password']) ? $postData['confirm_password'] : ''; ?>" required>
                                            <span class="input-group-text">
                                                <i class="far fa-eye-slash togglePassword" style="cursor: pointer"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <button name="submitSignup" class="btn-full-width">ĐĂNG KÝ</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php require_once 'footer.php' ?>
        <?php require_once 'script.php' ?>
        <script>
            $(".togglePassword").click(function(e) {
                e.preventDefault();
                var type = $(this).parent().parent().find("#password").attr("type");
                if (type == "password") {
                    $(this).removeClass("fa-eye-slash");
                    $(this).addClass("fa-eye");
                    $(this).parent().parent().find("#password").attr("type", "text");
                } else if (type == "text") {
                    $(this).removeClass("fa-eye");
                    $(this).addClass("fa-eye-slash");
                    $(this).parent().parent().find("#password").attr("type", "password");
                }
            });
        </script>

    </body>

</html>