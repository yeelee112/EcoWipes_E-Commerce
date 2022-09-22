<?php
    $checkAccountSession = false;
    if (!isset($_SESSION)) {
        session_start();
    }

    if ((empty($_SESSION['idUser']))) {
        header("Location: /");
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

    if (isset($_SESSION['nameUser']) && isset($_SESSION['idUser'])) {
        $nameUser = $_SESSION['nameUser'];
        $idUser = $_SESSION['idUser'];
        $checkAccountSession = true;
    }

    require_once 'DataProvider.php';
    $sqlUser = "select * from user_account where id = '$idUser' or uid = '$idUser'";
    $listUser = DataProvider::execQuery($sqlUser);
    $rowUser = mysqli_fetch_assoc($listUser);

    if ($checkAccountSession == true && $checkSecure > 0) {
        $sqlUpdateAccount = "update user_account set email = '$emailUser', fullname = '$fnameUser', phone = '$phone', address = '$addressUser', updated_at = now() where id = '" . $rowUser["id"] . "' or uid = '" . $rowUser["id"] . "'";
        DataProvider::execQuery($sqlUpdateAccount);

        $_SESSION['nameUser'] = $fnameUser;
        echo "<script>alert('Cập nhật thành công!')</script>";
    }

    if ($checkAccountSession == false) {
        redirect("/");
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
    <?php require_once 'header.php'; ?>
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
        <div class="page-content pt-50 pb-50">
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
                                            <a class="nav-link" id="address-tab" data-bs-toggle="tab" href="#address" role="tab" aria-controls="address" aria-selected="true"><i class="fi-rs-marker mr-10"></i>My Address</a>
                                        </li> -->
                                        <li class="nav-item">
                                            <a class="nav-link active" id="account-detail-tab" data-bs-toggle="tab" href="#account-detail" role="tab" aria-controls="account-detail" aria-selected="true"><i class="fi-rs-user mr-10"></i>Thông tin tài khoản</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="track-orders-tab" data-bs-toggle="tab" href="#track-orders" role="tab" aria-controls="track-orders" aria-selected="false"><i class="fi-rs-shopping-cart-check mr-10"></i>Đơn hàng của tôi</a>
                                        </li>
                                        <!-- <li class="nav-item">
                                            <a class="nav-link" href="page-login.html"><i class="fi-rs-sign-out mr-10"></i>Logout</a>
                                        </li> -->
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="tab-content account dashboard-content">
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
                                    <div class="tab-pane fade" id="track-orders" role="tabpanel" aria-labelledby="account-detail-tab">
                                        <div class="card">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="mb-0">Đơn hàng của tôi</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Đơn hàng</th>
                                                                    <th>Thời gian</th>
                                                                    <th>Tổng</th>
                                                                    <th style="text-align:center;">Trạng thái</th>
                                                                    <th style="text-align:center;">#</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                require_once 'DataProvider.php';
                                                                $sql = "SELECT * from order_detail od where od.user_id = $idUser or od.phone = '".$rowUser["phone"]."' order by created_at DESC";
                                                                $list = DataProvider::execQuery($sql);
                                                                while ($row = mysqli_fetch_array($list, MYSQLI_ASSOC)) {
                                                                ?>
                                                                    <tr>
                                                                        <td><?php echo "#".$row["id"] ?></td>
                                                                        <td><?php echo date("H:i:s d/m/Y", strtotime($row["created_at"])) ?></td>
                                                                        <td><?php echo number_format($row["total_price"] + $row["shipping_fee"], 0, ",", "."); ?> đ</td>
                                                                        <td>
                                                                            <?php
                                                                            if ($row["status_order"] == 0) {
                                                                                echo "<div><div class='unconfirm-order'>Chưa xác nhận</div></div>";
                                                                            } else if ($row["status_order"] == 1) {
                                                                                echo "<div><div class='confirm-order'>Đã xác nhận</div></div>";
                                                                            } else if ($row["status_order"] == 2) {
                                                                                echo "<div><div class='done-order'>Đã hoàn thành</div></div>";
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td style="text-align:center;"><a id="link" data-bs-target="#infoOrder" data-bs-toggle="modal" data-id="<?php echo $row["id"] ?>" class="btn-small d-block">Xem</a></td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
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
            </div>
        </div>
    </main>

    <div class="modal fade" id="infoOrder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thông tin đơn hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
    <?php require_once 'footer.php' ?>
    <?php require_once 'script.php' ?>

    <script>
        $(window).on('shown.bs.modal', function() { 
            var totalPriceWidth = $('.total-price-info-order').width();
            $('.price-binding-width').css("width", totalPriceWidth + 24);
        });
        
    </script>
    <script>
        $('.btn-small.d-block').on('click', function() {
            var id = $(this).data('id');
            $('.modal-body').html('loading');
            $.ajax({
                type: 'POST',
                url: 'processViewOrderDetail',
                data: {
                    id: id
                },
                success: function(data) {
                    $('.modal-body').html(data);
                },
                error: function(err) {
                    alert("error" + JSON.stringify(err));
                }
            })
        });
    </script>
</body>

</html>