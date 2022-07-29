<?php
    require_once 'library.php';
    require_once 'functionPhp.php';
    $activePage = basename($_SERVER['PHP_SELF'], ".php");
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $currentPage = $_SERVER['REQUEST_URI'];
    $nameUser = '';
    $phone = '';
    $checkAccountSession = false;

    if (!isset($_SESSION)) {
        session_start();
    }
    require_once 'DataProvider.php';

    if (isset($_SESSION['nameUser']) && isset($_SESSION['phoneUser'])) {
        $nameUser = $_SESSION['nameUser'];
        $phone = $_SESSION['phoneUser'];
        $checkAccountSession = true;

        require_once 'DataProvider.php';
        $sqlUser = "select * from user_account where phone = '$phone'";
        $listUser = DataProvider::execQuery($sqlUser);
        $rowUser = mysqli_fetch_assoc($listUser);

        $priceTotal = 0;
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
        $_SESSION['phoneUser'] = NULL;
        unset($_SESSION['nameUser']);
        unset($_SESSION['phoneUser']);

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
                            <input type="text" name="search" placeholder="Tìm kiếm trên EcoWipes" value="<?php if(isset($_GET["search"])){ echo $_GET["search"]; } ?>">
                        </form>
                    </div>
                    <div class="header-action-right">
                        <div class="header-action-2">

                            <div class="hotline d-none d-lg-flex">
                    <img src="assets/imgs/theme/icons/icon-headphone.svg" alt="hotline">
                    <p>1900 - 1009<span>Chăm sóc khách hàng</span></p>
                </div>
                            <div class="header-action-icon-2">
                                <div class="signin-block-container">
                                    <?php
                                    if ($checkAccountSession == true) { ?>
                                        <a href="#">
                                            <img class="avt-account" src="https://ui-avatars.com/api/?name=<?php echo $nameUser; ?>&rounded=true&size=48">
                                        </a>
                                        <a><span class="lable ml-0"><?php echo $nameUser; ?></span></a>
                                    <?php
                                    } else {
                                    ?>
                                        <div class="login-label-header">
                                            <a href="login">Đăng nhập</a>
                                        </div>
                                        <div class="signup-label-header">
                                            <a href="login">Đăng ký</a>
                                        </div>
                                    <?php } ?>
                                    <!--  -->
                                </div>
                                
                                <?php if ($checkAccountSession == true) { ?>
                                <div class="cart-dropdown-wrap cart-dropdown-hm2 account-dropdown">
                                        <ul>
                                            <!-- <li>
                                                <a href="page-account.html"><i class="fi fi-rs-user mr-10"></i>My Account</a>
                                            </li>
                                            <li>
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
                    <a href><img src="assets/imgs/theme/logo.svg" alt="logo"></a>
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
                                    <a href="about-us" class="<?php echo ($activePage == 'about-us') ? 'active' : ''; ?>" >Về chúng tôi</a>
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
                <div class="header-action-right">
                        <div class="header-action-2">
                            <div class="header-action-icon-2">
                                <a style="line-height:0" class="mini-cart-icon" href="<?php if($checkAccountSession == true){ echo "cart";} else{ echo "login";} ?>">
                                    <ion-icon name="cart-outline"></ion-icon>
                                    <?php if($checkAccountSession == true){ ?>
                                    <span class="pro-count blue">
                                    <?php 
                                        $count = 0;
                                        $sqlCountItem = "select * from shopping_session ss, cart_item ci, user_account ua where ss.id = ci.session_id and ss.user_id = ua.id and ss.user_id = '".$rowUser["id"]."'";
                                        $listCountItem = DataProvider::execQuery($sqlCountItem);
                                        while($rowCountItem = mysqli_fetch_array($listCountItem, MYSQLI_ASSOC)){
                                            $count+= $rowCountItem["quantity"];
                                        }
                                        echo $count;
                                    ?>
                                    </span>
                                    <?php } ?>
                                </a>
                                <?php if($checkAccountSession == true){ ?>
                                <div class="cart-dropdown-wrap cart-container cart-dropdown-hm2">
                                    <?php if($count == 0){   
                                    echo '<div>Chưa có sản phẩm nào trong giỏ hàng.</div>';
                                    }
                                    else{ ?>
                                    <ul>
                                        <?php  
                                        $sql1 = "select * from shopping_session ss, cart_item ci, product p, image_product ip where ss.id = ci.session_id and ci.product_id = p.id and p.id = ip.product_id and ss.user_id = '".$rowUser["id"]."'";
                                        $list1 = DataProvider::execQuery($sql1);
                                        while ($row1 = mysqli_fetch_array($list1, MYSQLI_ASSOC)) {
                                            $priceTotal += $row1["price"] * $row1["quantity"];
                                        ?>
                                        <li>
                                            <div class="shopping-cart-img">
                                                <a href="product?item=<?php echo $row1["product_text"] ?>"><img alt="<?php echo $row1["product_name"] ?>" src="<?php echo $row1["img_thumb"] ?>"></a>
                                            </div>
                                            <div class="shopping-cart-title">
                                                <h4><a href="product?item=<?php echo $row1["product_text"] ?>"><?php echo $row1["product_name"] ?></a></h4>
                                                <h4><span><?php echo $row1["quantity"] ?> × </span><?php echo number_format($row1["price"], 0, ",", ".")?> ₫</h4> 
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
                                <?php } ?>
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
                            <a class="mini-cart-icon" href="#">
                                <img alt="Nest" src="assets/imgs/theme/icons/icon-cart.svg">
                                <span class="pro-count white">1</span>
                            </a>
                            <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                <ul>
                                    <li>
                                        <div class="shopping-cart-img">
                                            <a href="#"><img alt="Nest" src="assets/imgs/shop/thumbnail-3.jpg"></a>
                                        </div>
                                        <div class="shopping-cart-title">
                                            <h4><a href="#">Plain Striola Shirts</a></h4>
                                            <h3><span>1 × </span>$800.00</h3>
                                        </div>
                                        <div class="shopping-cart-delete">
                                            <a href="#"><i class="fi-rs-cross-small"></i></a>
                                        </div>
                                    </li>
                                </ul>
                                <div class="shopping-cart-footer">
                                    <div class="shopping-cart-total">
                                        <h4>Total <span>$383.00</span></h4>
                                    </div>
                                    <div class="shopping-cart-button">
                                        <a href="shop-cart.html">View cart</a>
                                        <a href="shop-checkout.html">Checkout</a>
                                    </div>
                                </div>
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
                <form action="#">
                    <input type="text" placeholder="Search for items…">
                    <button type="submit"><i class="fi-rs-search"></i></button>
                </form>
            </div>
            <div class="mobile-menu-wrap mobile-header-border">
                <!-- mobile menu start -->
                <nav>
                    <ul class="mobile-menu font-heading">
                        <li class="menu-item-has-children">
                            <a href>Home</a>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="#">Mega menu</a>
                            <ul class="dropdown">
                                <li class="menu-item-has-children">
                                    <a href="#">Women's Fashion</a>
                                    <ul class="dropdown">
                                        <li><a href="#">Dresses</a></li>
                                        <li><a href="#">Blouses & Shirts</a></li>
                                        <li><a href="#">Hoodies & Sweatshirts</a></li>
                                        <li><a href="#">Women's Sets</a></li>
                                    </ul>
                                </li>
                                <li class="menu-item-has-children">
                                    <a href="#">Men's Fashion</a>
                                    <ul class="dropdown">
                                        <li><a href="#">Jackets</a></li>
                                        <li><a href="#">Casual Faux Leather</a></li>
                                        <li><a href="#">Genuine Leather</a></li>
                                    </ul>
                                </li>
                                <li class="menu-item-has-children">
                                    <a href="#">Technology</a>
                                    <ul class="dropdown">
                                        <li><a href="#">Gaming Laptops</a></li>
                                        <li><a href="#">Ultraslim Laptops</a></li>
                                        <li><a href="#">Tablets</a></li>
                                        <li><a href="#">Laptop Accessories</a></li>
                                        <li><a href="#">Tablet Accessories</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- mobile menu end -->
            </div>
            <div class="mobile-header-info-wrap">
                <div class="single-mobile-header-info">
                    <a href="page-contact.html"><i class="fi-rs-marker"></i> Our location </a>
                </div>
                <div class="single-mobile-header-info">
                    <a href="page-login.html"><i class="fi-rs-user"></i>Log In / Sign Up </a>
                </div>
                <div class="single-mobile-header-info">
                    <a href="#"><i class="fi-rs-headphones"></i>(+01) - 2345 - 6789 </a>
                </div>
            </div>
            <div class="mobile-social-icon mb-50">
                <h6 class="mb-15">Follow Us</h6>
                <a href="#"><img src="assets/imgs/theme/icons/icon-facebook-white.svg" alt></a>
                <a href="#"><img src="assets/imgs/theme/icons/icon-twitter-white.svg" alt></a>
                <a href="#"><img src="assets/imgs/theme/icons/icon-instagram-white.svg" alt></a>
                <a href="#"><img src="assets/imgs/theme/icons/icon-pinterest-white.svg" alt></a>
                <a href="#"><img src="assets/imgs/theme/icons/icon-youtube-white.svg" alt></a>
            </div>
            <div class="site-copyright">Copyright © 2021 Ecowipes Vietnam Corporation, All Rights Reserved.</div>
        </div>
    </div>
</div>


<script>

function remove_from_cart(textProduct) {
    var txtProduct = textProduct;
    $.ajax({
            method: "POST", // phương thức dữ liệu được truyền đi 
            url: "processRemoveFromCart", // gọi đến file server show_data.php để xử lý
            data: "id=" + txtProduct, //lấy toàn thông tin các fields trong form bằng hàm serialize của jquery
        })
        .done(function(data) {
            $('.cart-container').html(data); //Callback Replace the html of your shoppingCart Containe with the response of addtocart.php
        }).fail(function() {
            alert("failed!");
        }); //Some action to indicate is Failing ;
}
</script>