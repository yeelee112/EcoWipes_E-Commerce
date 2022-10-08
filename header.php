<?php
require_once 'library.php';
require_once 'functionPhp.php';
$activePage = basename($_SERVER['PHP_SELF'], ".php");
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$currentPage = $_SERVER['REQUEST_URI'];
$nameUser = '';
$idUser = '';
$count = 0;
$priceTotal = 0;
$checkAccountSession = false;
$loggedWith = '';
$shippingFee = 0;
$shippingUrbanFee = 20000;
$shippingSubUrbanFee = 40000;

$freeShippingUrbanLevel = 300000;
$freeShippingSubUrbanLevel = 500000;
$avtUser = '';

if (!isset($_SESSION)) {
    session_start();
}

require_once 'DataProvider.php';
require_once 'counterGuest.php';

if (isset($_SESSION['nameUser']) && isset($_SESSION['idUser'])) {
    $nameUser = $_SESSION['nameUser'];
    $idUser = $_SESSION['idUser'];
    $checkAccountSession = true;

    require_once 'DataProvider.php';
    $sqlUser = "select * from user_account where id = '$idUser' or uid = '$idUser'";
    $listUser = DataProvider::execQuery($sqlUser);
    $rowUser = mysqli_fetch_assoc($listUser);

    $priceTotal = 0;
}


echo $idUser;

if(isset($_SESSION['avtUser'])){
    $avtUser = $_SESSION['avtUser'];
}

if(isset($_SESSION['loggedWith'])){
    $loggedWith = $_SESSION['loggedWith'];
}

$logoutAction = $_SERVER['PHP_SELF'] . "?doLogout=true";

if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")) {
    $logoutAction .= "&" . htmlentities($_SERVER['QUERY_STRING']);
}

if ($currentPage != '/login' && (empty($_GET['doLogout']))) {
    $_SESSION['rewindURL'] = NULL;

    unset($_SESSION['rewindURL']);
    $_SESSION['rewindURL'] = $currentPage;
}

if ((isset($_GET['doLogout'])) && ($_GET['doLogout'] == "true")) {
    $_SESSION['nameUser'] = NULL;
    $_SESSION['idUser'] = NULL;

    unset($_SESSION['nameUser']);
    unset($_SESSION['idUser']);

    if(isset($_SESSION['fb_access_token'])){
        unset($_SESSION['fb_access_token']);
    }

    if(isset($_SESSION['avtUser'])){
        unset($_SESSION['avtUser']);
    }

    if(isset($_SESSION['loggedWith'])){
        unset($_SESSION['loggedWith']);
    }

    if(isset($_SESSION['emailUser'])){
        unset($_SESSION['emailUser']);
    }

    redirect($_SESSION['rewindURL']);
}
?>
<header class="header-area header-style-1 header-height-2">
    <div class="header-middle header-middle-ptb-1 d-none d-lg-block">
        <div class="container">
            <div class="header-wrap">
                <div class="logo logo-width-1">
                    <a href="/" style="justify-items: center; display: flex;"><img src="assets/imgs/theme/logo.svg" alt="logo"></a>
                </div>
                <div class="header-right">
                    <div class="search-style-2">
                        <form action="shop" method="get">
                            <select class="select-active">
                                <option>Tất cả danh mục</option>
                                <?php

                                $sql = "SELECT group_name FROM group_product group by group_name";
                                $list = DataProvider::execQuery($sql);
                                while ($row = mysqli_fetch_array($list, MYSQLI_ASSOC)) {
                                    echo "<option>" . $row["group_name"] . "</option>";
                                }
                                ?>
                            </select>
                            <input type="text" name="search" placeholder="Tìm kiếm trên EcoWipes" value="<?php if (isset($_GET["search"])) {
                                                                                                                echo $_GET["search"];
                                                                                                            } ?>">
                        </form>
                    </div>
                    <div class="header-action-right">
                        <div class="header-action-2">

                            <div class="hotline d-none d-lg-flex">
                                <img src="assets/imgs/theme/icons/icon-headphone.svg" alt="hotline">
                                <a href="tel:0909526282"><p>0909 52 62 82<span>Chăm sóc khách hàng</span></p></a>
                            </div>
                            <div class="header-action-icon-2">
                                <div class="signin-block-container">
                                    <?php
                                    if ($checkAccountSession == true) { ?>
                                        <a href="#">
                                            <img class="avt-account" style="height:48px;border-radius: 50%;" src="<?php if($loggedWith == ''){ echo "https://ui-avatars.com/api/?name=$nameUser; &rounded=true&size=48"; } else if($loggedWith == 'Facebook'){  echo "//graph.facebook.com/$idUser/picture"; } else if($loggedWith == 'Google'){ echo $_SESSION['avtUser']; }?> ">
                                        </a>
                                        <a><span class="lable ml-0"><?php echo $nameUser; ?></span></a>
                                    <?php
                                    } else {
                                    ?>
                                        <div class="login-label-header">
                                            <a href="login">Đăng nhập</a>
                                        </div>
                                        <div class="signup-label-header">
                                            <a href="login?action=register">Đăng ký</a>
                                        </div>
                                    <?php } ?>
                                    <!--  -->
                                </div>

                                <?php if ($checkAccountSession == true) { ?>
                                    <div class="cart-dropdown-wrap cart-dropdown-hm2 account-dropdown">
                                        <ul>
                                            <li style="justify-content: center;">
                                                <a href="account" style="display: flex;align-items: center;"><i style="line-height: 0;" class="fi fi-rs-user mr-10"></i>Tài khoản</a>
                                            </li>
                                            <!--<li>
                                                <a href="page-account.html"><i class="fi fi-rs-location-alt mr-10"></i>Order Tracking</a>
                                            </li>
                                            <li>
                                                <a href="page-account.html"><i class="fi fi-rs-label mr-10"></i>My Voucher</a>
                                            </li>
                                            <li>
                                                <a href="shop-wishlist.html"><i class="fi fi-rs-heart mr-10"></i>My Wishlist</a>
                                            </li>
                                            <li>
                                                <a href="page-account.html"><i class="fi fi-rs-settings-sliders mr-10"></i>Setting</a>
                                            </li> -->
                                            <li style="justify-content: center;">
                                                <a style="display: flex;align-items: center;" href="<?php echo $logoutAction; ?>"><i style="line-height: 0;" class="fi fi-rs-sign-out mr-10"></i>Đăng xuất</a>
                                            </li>
                                        </ul>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom header-bottom-bg-color sticky-bar">
        <div class="container">
            <div class="header-wrap header-space-between position-relative">
                <div class="logo logo-width-1 d-block d-lg-none">
                    <a href="/"><img src="assets/imgs/theme/logo.svg" alt="logo"></a>
                </div>
                <div class="header-nav d-none d-lg-flex">
                    <div class="main-categori-wrap d-none d-lg-block">
                        <a class="categories-button-active" href="#">
                            <span class="fi-rs-apps"></span> <span class="et">Danh mục</span> sản phẩm
                            <i class="fi-rs-angle-down"></i>
                        </a>
                        <div class="categories-dropdown-wrap categories-dropdown-active-large font-heading">
                            <div class="d-flex categori-dropdown-inner">
                                <ul>
                                    <?php
                                    require_once 'DataProvider.php';
                                    $sql = "SELECT * FROM type_product order by id ASC LIMIT 5";
                                    $list = DataProvider::execQuery($sql);
                                    while ($row = mysqli_fetch_array($list, MYSQLI_ASSOC)) {
                                        echo '<li><a href="shop?cid=' . $row["type_text"] . '">' . $row["type_name"] . '</a></li>';
                                    }
                                    ?>
                                </ul>
                                <ul class="end">
                                    <?php
                                    $sql = "SELECT * FROM type_product where 1=1 order by id DESC LIMIT 5";
                                    $list = DataProvider::execQuery($sql);
                                    while ($row = mysqli_fetch_array($list, MYSQLI_ASSOC)) {
                                        echo '<li><a href="shop?cid=' . $row["type_text"] . '">' . $row["type_name"] . '</a></li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                            <!-- <div class="more_slide_open" style="display: none">
                                    <div class="d-flex categori-dropdown-inner">
                                        <ul>
                                            <li>
                                                <a href="#">Ecobi</a>
                                            </li>
                                            <li>
                                                <a href="#">Ecobi</a>
                                            </li>
                                        </ul>
                                        <ul class="end">
                                            <li>
                                                <a href="#">Ecobi</a>
                                            </li>
                                            <li>
                                                <a href="#">Ecobi</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div> -->
                            <!-- <div class="more_categories"><span class="icon"></span> <span class="heading-sm-1">Show more...</span></div> -->
                        </div>
                    </div>
                    <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block font-heading">
                        <nav>
                            <ul>
                                <li class="hot-deals"><img src="assets/imgs/theme/icons/icon-hot.svg" alt="hot deals"><a href="#">Deals</a></li>
                                <li>
                                    <a class="<?php echo ($activePage == 'index') ? 'active' : ''; ?>" href="/">Trang chủ</a>
                                </li>
                                <li>
                                    <a href="about-us" class="<?php echo ($activePage == 'about-us') ? 'active' : ''; ?>">Về chúng tôi</a>
                                </li>
                                <li class="position-static">
                                    <a href="shop" class="<?php echo ($activePage == 'shop' || $activePage == 'product') ? 'active' : ''; ?>">Sản phẩm <i class="fi-rs-angle-down"></i></a>
                                    <ul class="mega-menu">
                                        <?php
                                        require_once 'DataProvider.php';
                                        $sql = "SELECT * FROM brand_product where id != 'ETS'";
                                        $list = DataProvider::execQuery($sql);
                                        while ($row = mysqli_fetch_array($list, MYSQLI_ASSOC)) {
                                        ?>
                                            <li class="sub-mega-menu sub-mega-menu-width-22">
                                                <a class="menu-title" href="shop?pid=<?php echo $row["brand_text"]; ?>"><?php echo $row["brand_name"]; ?></a>
                                                <ul>
                                                    <?php
                                                    require_once 'DataProvider.php';
                                                    $sqlChild = "SELECT * FROM type_product t, group_product g, brand_product b where t.group_id = g.id and g.brand_id = b.id and b.id = '" . $row['id'] . "'";
                                                    $listChild  = DataProvider::execQuery($sqlChild);
                                                    while ($rowChild = mysqli_fetch_array($listChild, MYSQLI_ASSOC)) {
                                                        echo '<li><a href="shop?cid=' . $rowChild["type_text"] . '">' . $rowChild["type_name"] . '</a></li>';
                                                    }
                                                    ?>
                                                </ul>
                                                <?php
                                                if ($row["id"] == "EBB") {
                                                ?>
                                                    <a class="menu-title pt-40" href="shop?pid=<?php echo "eco-tissue"; ?>"><?php echo "Eco Tissue" ?></a>
                                                    <ul>
                                                        <?php
                                                        require_once 'DataProvider.php';
                                                        $sqlChild = "SELECT * FROM type_product t, group_product g, brand_product b where t.group_id = g.id and g.brand_id = b.id and b.id = 'ETS'";
                                                        $listChild  = DataProvider::execQuery($sqlChild);
                                                        while ($rowChild = mysqli_fetch_array($listChild, MYSQLI_ASSOC)) {
                                                            echo '<li><a href="shop?cid=' . $rowChild["type_text"] . '">' . $rowChild["type_name"] . '</a></li>';
                                                        }
                                                        ?>
                                                    </ul>
                                                <?php
                                                }
                                                ?>
                                            </li>
                                        <?php } ?>
                                        <!-- <li class="sub-mega-menu sub-mega-menu-width-34">
                                                <div class="menu-banner-wrap">
                                                    <a href="#"><img src="assets/imgs/banner/banner-menu.png" alt="EcoWipes"></a>
                                                    <div class="menu-banner-content">
                                                        <h4>Hot deals</h4>
                                                        <h3>
                                                            Don't miss<br>
                                                            Trending
                                                        </h3>
                                                        <div class="menu-banner-price">
                                                            <span class="new-price text-success">Save to 50%</span>
                                                        </div>
                                                        <div class="menu-banner-btn">
                                                            <a href="#">Shop now</a>
                                                        </div>
                                                    </div>
                                                    <div class="menu-banner-discount">
                                                        <h3>
                                                            <span>25%</span>
                                                            off
                                                        </h3>
                                                    </div>
                                                </div>
                                            </li> -->
                                    </ul>
                                </li>
                                <li>
                                    <a href="contact-us" class="<?php echo ($activePage == 'contact-us') ? 'active' : ''; ?>">Liên hệ</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>

                <div class="header-action-right" <?php if ($activePage == 'cart' || $activePage == 'checkout') {
                                                        echo 'style="visibility: hidden";';
                                                    } ?>>
                    <div class="header-action-2">
                        <div class="header-action-icon-2">
                            <a style="line-height:0" class="mini-cart-icon" href="cart">
                                <ion-icon name="cart-outline"></ion-icon>
                                <span class="pro-count blue">
                                    <?php
                                    $count = 0;
                                    if (isset($_SESSION['cart'])) {
                                        foreach ($_SESSION['cart'] as $id => $value) {
                                            $count += $_SESSION['cart'][$id]['quantity'];
                                        }
                                    } else {
                                        $count = 0;
                                    }
                                    echo $count;
                                    ?>
                                </span>
                            </a>

                            <div class="cart-dropdown-wrap cart-container cart-dropdown-hm2">
                                <?php if ($count == 0) {
                                    echo '<div>Chưa có sản phẩm nào trong giỏ hàng.</div>';
                                } else { ?>
                                    <ul>
                                        <?php
                                        $priceTotal = 0;
                                        $sql1 = "SELECT * FROM product p, image_product i WHERE p.id = i.product_id and p.product_text IN (";

                                        foreach ($_SESSION['cart'] as $id => $value) {
                                            $sql1 .= "'" . $id . "',";
                                        }

                                        $sql1 = substr($sql1, 0, -1) . ")";
                                        $list1 = DataProvider::execQuery($sql1);

                                        while ($row1 = mysqli_fetch_array($list1, MYSQLI_ASSOC)) {
                                            $priceTotal += $row1["price"] * $_SESSION['cart'][$row1['product_text']]['quantity'];
                                        ?>
                                            <li>
                                                <div class="shopping-cart-img">
                                                    <a href="product?item=<?php echo $row1["product_text"] ?>"><img alt="<?php echo $row1["product_name"] ?>" src="<?php echo $row1["img_thumb"] ?>"></a>
                                                </div>
                                                <div class="shopping-cart-title">
                                                    <h4><a href="product?item=<?php echo $row1["product_text"] ?>"><?php echo $row1["product_name"] ?></a></h4>
                                                    <h4><span><?php echo $_SESSION['cart'][$row1['product_text']]['quantity'] ?> × </span><?php echo number_format($row1["price"], 0, ",", ".") ?> ₫</h4>
                                                </div>
                                                <div class="shopping-cart-delete">
                                                    <button class="btn-delete-cart-product" tyle="button" onclick="remove_from_cart(this.value);" value="<?php echo $row1["product_text"] ?>"><i class="fi-rs-cross-small"></i></button>
                                                </div>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                    <div class="shopping-cart-footer">
                                        <div class="shopping-cart-total">
                                            <h4>Tổng cộng <span><?php echo number_format($priceTotal, 0, ",", "."); ?> ₫</span></h4>
                                        </div>
                                        <div class="shopping-cart-button">
                                            <a href="cart" class="outline">Xem giỏ hàng</a>
                                            <a href="checkout">Thanh toán</a>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="header-action-icon-2 d-block d-lg-none">
                    <div class="burger-icon burger-icon-white">
                        <span class="burger-icon-top"></span>
                        <span class="burger-icon-mid"></span>
                        <span class="burger-icon-bottom"></span>
                    </div>
                </div>
                <div class="header-action-right d-block d-lg-none">
                    <div class="header-action-2">
                        <div class="header-action-icon-2">
                            <a style="line-height:0" class="mini-cart-icon" href="cart">
                                <ion-icon name="cart-outline"></ion-icon>
                                <span class="pro-count blue">
                                    <?php
                                    $count = 0;
                                    if (isset($_SESSION['cart'])) {
                                        foreach ($_SESSION['cart'] as $id => $value) {
                                            $count += $_SESSION['cart'][$id]['quantity'];
                                        }
                                    } else {
                                        $count = 0;
                                    }
                                    echo $count;
                                    ?>
                                </span>
                            </a>
                            <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                <?php if ($count == 0) {
                                    echo '<div>Chưa có sản phẩm nào trong giỏ hàng.</div>';
                                } else { ?>
                                    <ul>
                                        <?php
                                        $priceTotal = 0;
                                        $sql1 = "SELECT * FROM product p, image_product i WHERE p.id = i.product_id and p.product_text IN (";

                                        foreach ($_SESSION['cart'] as $id => $value) {
                                            $sql1 .= "'" . $id . "',";
                                        }

                                        $sql1 = substr($sql1, 0, -1) . ")";
                                        $list1 = DataProvider::execQuery($sql1);

                                        while ($row1 = mysqli_fetch_array($list1, MYSQLI_ASSOC)) {
                                            $priceTotal += $row1["price"] * $_SESSION['cart'][$row1['product_text']]['quantity'];
                                        ?>
                                            <li>
                                                <div class="shopping-cart-img">
                                                    <a href="product?item=<?php echo $row1["product_text"] ?>"><img alt="<?php echo $row1["product_name"] ?>" src="<?php echo $row1["img_thumb"] ?>"></a>
                                                </div>
                                                <div class="shopping-cart-title">
                                                    <h4><a href="product?item=<?php echo $row1["product_text"] ?>"><?php echo $row1["product_name"] ?></a></h4>
                                                    <h4><span><?php echo $_SESSION['cart'][$row1['product_text']]['quantity'] ?> × </span><?php echo number_format($row1["price"], 0, ",", ".") ?> ₫</h4>
                                                </div>
                                                <div class="shopping-cart-delete">
                                                    <button class="btn-delete-cart-product" tyle="button" onclick="remove_from_cart(this.value);" value="<?php echo $row1["product_text"] ?>"><i class="fi-rs-cross-small"></i></button>
                                                </div>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                    <div class="shopping-cart-footer">
                                        <div class="shopping-cart-total">
                                            <h4>Tổng cộng <span><?php echo number_format($priceTotal, 0, ",", "."); ?> ₫</span></h4>
                                        </div>
                                        <div class="shopping-cart-button">
                                            <a href="cart" class="outline">Xem giỏ hàng</a>
                                            <a href="checkout">Thanh toán</a>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="mobile-header-active mobile-header-wrapper-style">
    <div class="mobile-header-wrapper-inner">
        <div class="mobile-header-top">
            <div class="mobile-header-logo">
                <a href><img src="assets/imgs/theme/logo.svg" alt="logo"></a>
            </div>
            <div class="mobile-menu-close close-style-wrap close-style-position-inherit">
                <button class="close-style search-close">
                    <i class="icon-top"></i>
                    <i class="icon-bottom"></i>
                </button>
            </div>
        </div>
        <div class="mobile-header-content-area">
            <div class="mobile-search search-style-3 mobile-header-border">
                <form action="shop">
                    <input type="text" name="search" placeholder="Tìm kiếm trên EcoWipes…" value="<?php if (isset($_GET["search"])) {
                                                                                                                echo $_GET["search"];
                                                                                                            } ?>">
                    <button type="submit" ><i class="fi-rs-search"></i></button>
                </form>
            </div>
            <div class="mobile-menu-wrap mobile-header-border">
                <!-- mobile menu start -->
                <nav>
                    <ul class="mobile-menu font-heading">
                        <li class="menu-item-has-children">
                            <a href="/">Trang chủ</a>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="about-us">Về chúng tôi</a>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="shop">Sản phẩm</a>
                            <ul class="dropdown">
                                <?php
                                require_once 'DataProvider.php';
                                $sqlP1 = "SELECT * FROM brand_product";
                                $listP1  = DataProvider::execQuery($sqlP1);
                                while ($rowP1 = mysqli_fetch_array($listP1, MYSQLI_ASSOC)) { ?>
                                <li class="menu-item-has-children">
                                    <a href="shop?pid=<?php echo $rowP1["brand_text"] ?>"><?php echo $rowP1["brand_name"] ?></a>
                                    <ul class="dropdown">
                                    <?php
                                        $sqlP2 = "SELECT * FROM brand_product bp, group_product gp, type_product tp where bp.id = gp.brand_id and gp.id = tp.group_id and bp.id = '".$rowP1["id"]."'";
                                        $listP2  = DataProvider::execQuery($sqlP2);
                                        while ($rowP2 = mysqli_fetch_array($listP2, MYSQLI_ASSOC)) { ?>
                                            <li><a href="shop?cid=<?php echo $rowP2["type_text"] ?>"><?php echo $rowP2["type_name"] ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </li>
                                <?php } ?>
                            </ul>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="contact-us">Liên hệ</a>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="dieu-khoan-dich-vu">Chính sách & Điều khoản</a>
                            <ul class="dropdown">
                                <li><a href="dieu-khoan-dich-vu">Điều khoản dịch vụ</a></li>
                                <li><a href="chinh-sach-bao-mat">Chính sách bảo mật</a></li>
                                <li><a href="chinh-sach-doi-tra">Chính sách đổi trả</a></li>
                                <li><a href="chinh-sach-van-chuyen">Chính sách vận chuyển</a></li>
                                <li><a href="huong-dan-dat-hang">Hướng dẫn đặt hàng</a></li>
                                <li><a href="chinh-sach-doi-tra">Hướng dẫn đổi trả</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- mobile menu end -->
            </div>
            <div class="mobile-header-info-wrap">
                <div class="single-mobile-header-info">
                    <a href="<?php if ($checkAccountSession == true) { echo "account";} else{ echo "login";}?>">
                        <i class="fi-rs-user"></i>
                        <?php if ($checkAccountSession == true) { echo $nameUser; } else{ echo "Đăng ký / Đăng nhập";} ?>
                     </a>
                </div>
                <div class="single-mobile-header-info">
                    <a href="tel:0909526282"><i class="fi-rs-headphones"></i> 0909 52 62 82</a>
                </div>
            </div>
            <div class="site-copyright">Copyright © 2022 Ecowipes Vietnam Corporation, All Rights Reserved.</div>
        </div>
    </div>
</div>


<script>
    function remove_from_cart(textProduct) {
        var txtProduct = textProduct;
        $.ajax({
                method: "POST", // phương thức dữ liệu được truyền đi 
                url: "processRemoveFromCart", // gọi đến file server show_data.php để xử lý
                data: "id=" + txtProduct,
                success: function(data) {
                    $('.cart-container').html(data);
                },
                complete: function() {
                    $.ajax({
                        method: "POST",
                        url: "processUpdateCount",
                        success: function(data) {
                            $('.pro-count').text(data);
                        },
                    })
                }

            }); //Some action to indicate is Failing ;
    }
</script>