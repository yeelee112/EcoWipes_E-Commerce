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

<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <title>EcoWipes | E-Commerce</title>
    <?php require_once 'library.php'; ?>
    
</head>

<body>
<?php 
    require_once 'header.php';

    if($checkAccountSession == false){
        redirect("/");
    }

?>

    <!--End header-->
    <main class="main pages">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href rel="nofollow"><i class="fi-rs-home mr-5"></i>Trang chủ</a>
                    <span></span> Tài khoản
                </div>
            </div>
        </div>
        
        <div class="page-content pt-150 pb-150">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 m-auto">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="dashboard-menu">
                                    <ul class="nav flex-column" role="tablist">
                                        <!-- <li class="nav-item">
                                            <a class="nav-link active" id="dashboard-tab" data-bs-toggle="tab" href="#dashboard" role="tab" aria-controls="dashboard" aria-selected="false"><i class="fi-rs-settings-sliders mr-10"></i>Dashboard</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="orders-tab" data-bs-toggle="tab" href="#orders" role="tab" aria-controls="orders" aria-selected="false"><i class="fi-rs-shopping-bag mr-10"></i>Orders</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="track-orders-tab" data-bs-toggle="tab" href="#track-orders" role="tab" aria-controls="track-orders" aria-selected="false"><i class="fi-rs-shopping-cart-check mr-10"></i>Track Your Order</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="address-tab" data-bs-toggle="tab" href="#address" role="tab" aria-controls="address" aria-selected="true"><i class="fi-rs-marker mr-10"></i>My Address</a>
                                        </li> -->
                                        <li class="nav-item">
                                            <a class="nav-link active" id="account-detail-tab" data-bs-toggle="tab" href="#account-detail" role="tab" aria-controls="account-detail" aria-selected="true"><i class="fi-rs-user mr-10"></i>Thông tin tài khoản</a>
                                        </li>
                                        <!-- <li class="nav-item">
                                            <a class="nav-link" href="page-login.html"><i class="fi-rs-sign-out mr-10"></i>Logout</a>
                                        </li> -->
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="tab-content account dashboard-content pl-50">
                                    <div class="tab-pane fade active show" id="account-detail" role="tabpanel" aria-labelledby="account-detail-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Thông tin tài khoản</h5>
                                            </div>
                                            <div class="card-body">
                                                <form method="post" action="" name="enq">
                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label>Họ tên <span class="required">*</span></label>
                                                            <input required class="form-control" name="name" value="<?php echo $rowUser["fullname"]; ?>" type="text">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Số điện thoại <span class="required">*</span></label>
                                                            <input required class="form-control" name="phone" value="<?php echo $rowUser["phone"]; ?>">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Địa chỉ <span class="required">*</span></label>
                                                            <input required class="form-control" name="address" value="<?php echo $rowUser["address"]; ?>" type="text">
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label>Email <span class="required">*</span></label>
                                                            <input required class="form-control" name="email" value="<?php echo $rowUser["email"]; ?>" type="email">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <button type="submit" class="btn btn-fill-out submit font-weight-bold" name="submit" value="Submit">Lưu</button>
                                                        </div>
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
            </div>
        </div>
    </main>
        <?php require_once 'footer.php' ?>
        <?php require_once 'script.php' ?>

</body>

</html>