<!DOCTYPE html>
<html class="no-js" lang="vi">

<head>
    <meta charset="utf-8">
    <title>EcoWipes | E-Commerce</title>
    <?php 
        require_once 'library.php';
    ?>
</head>

<body>
    <?php require_once 'header.php' ?>

    <main class="main">
        <section class="home-slider position-relative mb-30">
            <div class="container">
                <div class="home-slide-cover mt-30">
                    <div class="hero-slider-1 style-4 dot-style-1 dot-style-1-position-1">
                        <div class="single-hero-slider single-animation-wrap" style="background-image: url(assets/imgs/slider/EW_SlideBanner_KitchenWipes_W1920xH770px.png)">
                            <div class="slider-content">
                                <h1 class="display-2 mb-40 animate__animated animate__fadeInLeft animate__slow">
                                    Khăn ướt Lau bếp<br>
                                </h1>
                                <p class="mb-65 animate__animated animate__fadeInLeft text-shadow-light" style="font-weight:600;color:white">Sự lựa chọn <span style="color:#72be44;font-weight:700;">tốt nhất</span> cho nội trợ</p>
                            </div>
                        </div>
                        <div class="single-hero-slider single-animation-wrap lazyload" style="background-image: url(assets/imgs/slider/EW_SlideBanner_MakeupRemover_W1920xH770px.png)">
                            <div class="slider-content">
                                <h1 class="display-2 mb-40">
                                    Khăn ướt <br>Tẩy trang
                                </h1>
                                <p class="mb-65">Sạch sạch sạch sạch</p>
                            </div>
                        </div>
                    </div>
                    <div class="slider-arrow hero-slider-1-arrow"></div>
                </div>
            </div>
        </section>

        <section class="popular-categories section-padding">
            <div class="container wow animate__animated animate__fadeIn">
                <div class="section-title">
                    <div class="title">
                        <h3>Thương hiệu nổi bật</h3>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="banner-img wow animate__animated animate__fadeInUp" data-wow-delay=".1s">
                            <img src="assets/imgs/banner/banner-1.png" alt>
                            <div class="banner-text">
                                <h4>
                                    Ecobi<br>
                                </h4>
                                <a href="#" class="btn btn-xs">Xem ngay <i class="fi-rs-arrow-small-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="banner-img wow animate__animated animate__fadeInUp" data-wow-delay=".15s">
                            <img src="assets/imgs/banner/banner-2.png" alt>
                            <div class="banner-text">
                                <h4>
                                    Eco Bamboo
                                </h4>
                                <a href="#" class="btn btn-xs">Xem ngay <i class="fi-rs-arrow-small-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 d-md-none d-lg-flex">
                        <div class="banner-img mb-sm-0 wow animate__animated animate__fadeInUp" data-wow-delay=".2s">
                            <img src="assets/imgs/banner/banner-3.png" alt>
                            <div class="banner-text">
                                <h4>EcoWipes</h4>
                                <a href="#" class="btn btn-xs">Xem ngay <i class="fi-rs-arrow-small-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 d-md-none d-lg-flex">
                        <div class="banner-img mb-sm-0 wow animate__animated animate__fadeInUp" data-wow-delay=".25s">
                            <img src="assets/imgs/banner/banner-4.png" alt>
                            <div class="banner-text">
                                <h4>Eco Tissue</h4>
                                <a href="#" class="btn btn-xs">Xem ngay <i class="fi-rs-arrow-small-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-padding pb-5">
            <div class="container">
                <div class="section-title wow animate__animated animate__fadeIn" style="display:flex;align-items:center;">
                    <h3 class>Best Sells Mỗi ngày</h3>
                    <ul class="nav nav-tabs links" id="myTab-2" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" style="display:flex;align-items:center;" id="nav-tab-one-1" data-bs-toggle="tab" data-bs-target="#tab-one-1" type="button" role="tab" aria-controls="tab-one" aria-selected="true">
                                <div class="" style="background: linear-gradient(to right, purple, red);-webkit-background-clip: text;-webkit-mask-clip: text;-webkit-text-fill-color: transparent;">
                                    Kết thúc trong:
                                </div>
                                <div class="deals-countdown pl-5" id="clock" data-countdown="2022/07/20 00:00:00">
                                    <span class="countdown-section">
                                        <span class="countdown-amount hover-up">03</span>
                                        <span class="countdown-period"> ngày </span>
                                    </span>
                                    <span class="countdown-section">
                                        <span class="countdown-amount hover-up">02</span>
                                        <span class="countdown-period"> giờ </span>
                                    </span>
                                    <span class="countdown-section">
                                        <span class="countdown-amount hover-up">43</span>
                                        <span class="countdown-period"> phút </span>
                                    </span>
                                    <span class="countdown-section">
                                        <span class="countdown-amount hover-up">29</span>
                                        <span class="countdown-period"> giây </span>
                                    </span>
                                </div>
                                <div class="" style="background: linear-gradient(to bottom, purple, red);-webkit-background-clip: text;-webkit-mask-clip: text;-webkit-text-fill-color: transparent;">
                                    Flash Sale
                                </div>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation" style="display:flex;">
                            <button class="nav-link" id="nav-tab-two-1" data-bs-toggle="tab" data-bs-target="#tab-two-1" type="button" role="tab" aria-controls="tab-two" aria-selected="false">Bán chạy</button>
                        </li>
                        <li class="nav-item" role="presentation" style="display:flex;">
                            <button class="nav-link" id="nav-tab-three-1" data-bs-toggle="tab" data-bs-target="#tab-three-1" type="button" role="tab" aria-controls="tab-three" aria-selected="false">Mới</button>
                        </li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-lg-3 d-none d-lg-flex wow animate__animated animate__fadeIn">
                        <div class="banner-img style-2">
                            <div class="banner-text">
                                <h2 class="mb-100" style="font-size:42px;color:white;">Bring nature into your home</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-12 wow animate__animated animate__fadeIn" data-wow-delay=".4s">
                        <!-- TAB PANE START-->
                        <div class="tab-content" id="myTabContent-1">
                            <!-- TAB PANE 1-->
                            <div class="tab-pane fade show active" id="tab-one-1" role="tabpanel" aria-labelledby="tab-one-1">
                                <div class="carausel-4-columns-cover arrow-center position-relative">
                                    <div class="slider-arrow slider-arrow-2 carausel-4-columns-arrow" id="carausel-4-columns-arrows"></div>
                                    <div class="carausel-4-columns carausel-arrow-center" id="carausel-4-columns">
                                        <div class="product-cart-wrap">
                                            <div class="product-img-action-wrap">
                                                <div class="product-img">
                                                    <a href="shop-product-right.html">
                                                        <img class="default-img" src="assets/imgs/product/EW_MALL_ECOBI_80s_BLUE_0Thumb.png" alt>
                                                        <img class="hover-img" src="assets/imgs/product/EW_MALL_ECOBI_80s_BLUE_Features_01.png" alt>
                                                    </a>
                                                </div>
                                                <div class="product-action-1">
                                                    <a aria-label="Xem trước" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                                </div>
                                                <div class="product-badges product-badges-position product-badges-mrg">
                                                    <span class="hot">Save 15%</span>
                                                </div>
                                            </div>
                                            <div class="product-content-wrap">
                                                <div class="product-category">
                                                    <a href="shop-grid-right.html">Khăn Gia Đình</a>
                                                </div>
                                                <h2><a href="shop-product-right.html">Khăn ướt Ecobi 80 tờ - Không Mùi</a></h2>
                                                <div class="product-price mt-10">
                                                    <span>38.000 đ </span>
                                                    <span class="old-price">40.000 đ</span>
                                                </div>
                                                <div class="sold mt-15 mb-15">
                                                    <div class="progress mb-5">
                                                        <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <span class="font-xs text-heading"> Đã bán: 90/120</span>
                                                </div>
                                                <a href="shop-cart.html" class="btn w-100 hover-up" style="padding: 12px 8px !important;"><i class="fi-rs-shopping-cart mr-5"></i>Thêm vào giỏ hàng</a>
                                            </div>
                                        </div>
                                        <!--End product Wrap-->
                                        <div class="product-cart-wrap">
                                            <div class="product-img-action-wrap">
                                                <div class="product-img">
                                                    <a href="shop-product-right.html">
                                                        <img class="default-img" src="assets/imgs/product/EW_MALL_ECOBI_80s_PINK_0Thumb.png" alt>
                                                        <img class="hover-img" src="assets/imgs/product/EW_MALL_ECOBI_80s_PINK_Feature1.png" alt>
                                                    </a>
                                                </div>
                                                <div class="product-action-1">
                                                    <a aria-label="Xem trước" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                                </div>
                                                <div class="product-badges product-badges-position product-badges-mrg">
                                                    <span class="new">Save 35%</span>
                                                </div>
                                            </div>
                                            <div class="product-content-wrap">
                                                <div class="product-category">
                                                    <a href="shop-grid-right.html">Khăn Gia Đình</a>
                                                </div>
                                                <h2><a href="shop-product-right.html">Khăn ướt Ecobi 80 tờ - Hương Dịu Nhẹ</a></h2>
                                                <div class="product-price mt-10">
                                                    <span>38.000 đ </span>
                                                    <span class="old-price">40.000 đ</span>
                                                </div>
                                                <div class="sold mt-15 mb-15">
                                                    <div class="progress mb-5">
                                                        <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <span class="font-xs text-heading"> Đã bán: 90/120</span>
                                                </div>
                                                <a href="shop-cart.html" class="btn w-100 hover-up" style="padding: 12px 8px !important;"><i class="fi-rs-shopping-cart mr-5"></i>Thêm vào giỏ hàng</a>
                                            </div>
                                        </div>
                                        <!--End product Wrap-->
                                        <div class="product-cart-wrap">
                                            <div class="product-img-action-wrap">
                                                <div class="product-img">
                                                    <a href="shop-product-right.html">
                                                        <img class="default-img" src="assets/imgs/product/EW_MALL_KITCHEN_42Wipes_01.jpg" alt>
                                                        <img class="hover-img" src="assets/imgs/product/EW_MALL_KITCHEN_42Wipes_03.jpg" alt>
                                                    </a>
                                                </div>
                                                <div class="product-action-1">
                                                    <a aria-label="Xem trước" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                                </div>
                                                <div class="product-badges product-badges-position product-badges-mrg">
                                                    <span class="sale">Sale</span>
                                                </div>
                                            </div>
                                            <div class="product-content-wrap">
                                                <div class="product-category">
                                                    <a href="shop-grid-right.html">Khăn Chức Năng</a>
                                                </div>
                                                <h2><a href="shop-product-right.html">Khăn lau bếp 42 tờ</a></h2>
                                                <div class="product-price mt-10">
                                                    <span>48.000 đ </span>
                                                    <span class="old-price">54.000 đ</span>
                                                </div>
                                                <div class="sold mt-15 mb-15">
                                                    <div class="progress mb-5">
                                                        <div class="progress-bar" role="progressbar" style="width: 47.5%" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <span class="font-xs text-heading"> Đã bán: 57/120</span>
                                                </div>
                                                <a href="shop-cart.html" class="btn w-100 hover-up" style="padding: 12px 8px !important;"><i class="fi-rs-shopping-cart mr-5"></i>Thêm vào giỏ hàng</a>
                                            </div>
                                        </div>
                                        <!--End product Wrap-->
                                        <div class="product-cart-wrap">
                                            <div class="product-img-action-wrap">
                                                <div class="product-img">
                                                    <a href="shop-product-right.html">
                                                        <img class="default-img" src="assets/imgs/product/EW_MALL_SneakerWipes_0Thumb.png" alt>
                                                        <img class="hover-img" src="assets/imgs/product/EW_MALL_SneakerWipes_Features_05.png" alt>
                                                    </a>
                                                </div>
                                                <div class="product-action-1">
                                                    <a aria-label="Xem trước" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                                </div>
                                                <div class="product-badges product-badges-position product-badges-mrg">
                                                    <span class="best">Best sale</span>
                                                </div>
                                            </div>
                                            <div class="product-content-wrap">
                                                <div class="product-category">
                                                    <a href="shop-grid-right.html">Khăn Chức Năng</a>
                                                </div>
                                                <h2><a href="shop-product-right.html">Khăn lau giày 25 tờ</a></h2>
                                                <div class="product-price mt-10">
                                                    <span>40.000 đ </span>
                                                    <span class="old-price">44.000 đ</span>
                                                </div>
                                                <div class="sold mt-15 mb-15">
                                                    <div class="progress mb-5">
                                                        <div class="progress-bar" role="progressbar" style="width: 92%" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <span class="font-xs text-heading"> Đã bán: 110/120</span>
                                                </div>
                                                <a href="shop-cart.html" class="btn w-100 hover-up" style="padding: 12px 8px !important;"><i class="fi-rs-shopping-cart mr-5"></i>Thêm vào giỏ hàng</a>
                                            </div>
                                        </div>
                                        <!--End product Wrap-->
                                    </div>
                                </div>
                            </div>
                            <!-- END TAB PANE-->
                        </div>
                        <!--End tab-content-->
                    </div>
                    <!--End Col-lg-9-->
                </div>
            </div>
        </section>

        <section class="product-tabs section-padding position-relative">
            <div class="container">
                <div class="section-title style-2 wow animate__animated animate__fadeIn">
                    <h3>Sản phẩm nổi bật</h3>
                    <ul class="nav nav-tabs links" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="nav-tab-one" data-bs-toggle="tab" data-bs-target="#tab-one" type="button" role="tab" aria-controls="tab-one" aria-selected="true">Tất cả</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="nav-tab-two" data-bs-toggle="tab" data-bs-target="#tab-two" type="button" role="tab" aria-controls="tab-two" aria-selected="false">EcoWipes</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="nav-tab-three" data-bs-toggle="tab" data-bs-target="#tab-three" type="button" role="tab" aria-controls="tab-three" aria-selected="false">Ecobi</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="nav-tab-four" data-bs-toggle="tab" data-bs-target="#tab-four" type="button" role="tab" aria-controls="tab-four" aria-selected="false">Eco Bamboo</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="nav-tab-five" data-bs-toggle="tab" data-bs-target="#tab-five" type="button" role="tab" aria-controls="tab-five" aria-selected="false">Eco Tissue</button>
                        </li>
                    </ul>
                </div>
                <!--End nav-tabs-->
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="tab-one" role="tabpanel" aria-labelledby="tab-one">
                        <div class="row product-grid-4">
                            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".1s">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img">
                                            <a href="#">
                                                <img class="default-img" src="assets/imgs/product/EW_MALL_MakeupRemover_0Thumb.png" alt>
                                                <img class="hover-img" src="https://media2.giphy.com/media/QxA4AwZ79J6SlFCmHD/giphy.gif?cid=ecf05e47pxt6ypv31fw33dmv3rxqdcuxhxyumr3mv6i5fhrw&rid=giphy.gif&ct=g" alt>
                                            </a>
                                        </div>
                                        <div class="product-action-1">
                                            <a aria-label="Xem trước" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                        </div>
                                        <div class="product-badges product-badges-position product-badges-mrg">
                                            <span class="hot">Hot</span>
                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="product-category">
                                            <a href="shop-grid-right.html">Khăn Chức Năng</a>
                                        </div>
                                        <h2><a href="#">Khăn tẩy trang 25 tờ</a></h2>
                                        <div>
                                            <span class="font-small text-muted">Thương hiệu: <a href="vendor-details-1.html">EcoWipes</a></span>
                                        </div>
                                        <div class="product-card-bottom">
                                            <div class="product-price">
                                                <span>38.000 đ</span>
                                                <span class="old-price">40.000 đ</span>
                                            </div>
                                            <div class="add-cart">
                                                <a class="add" href="shop-cart.html"><i class="fi-rs-shopping-cart mr-5"></i><span>Thêm</span> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end product card-->
                            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".2s">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img">
                                            <a href="#">
                                                <img class="default-img" src="assets/imgs/product/EW_MALL_ECOBI_80s_BLUE_0Thumb.png" alt>
                                                <img class="hover-img" src="assets/imgs/product/EW_MALL_ECOBI_80s_BLUE_Features_01.png" alt>
                                            </a>
                                        </div>
                                        <div class="product-action-1">
                                            <a aria-label="Xem trước" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                        </div>
                                        <div class="product-badges product-badges-position product-badges-mrg">
                                            <span class="sale">Sale</span>
                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="product-category">
                                            <a href="shop-grid-right.html">Khăn Gia Đình</a>
                                        </div>
                                        <h2><a href="#">Khăn ướt Ecobi 80 tờ - Không Mùi</a></h2>
                                        <div>
                                            <span class="font-small text-muted">Thương hiệu: <a href="vendor-details-1.html">Ecobi</a></span>
                                        </div>
                                        <div class="product-card-bottom">
                                            <div class="product-price">
                                                <span>38.000 đ</span>
                                                <span class="old-price">40.000 đ</span>
                                            </div>
                                            <div class="add-cart">
                                                <a class="add" href="shop-cart.html"><i class="fi-rs-shopping-cart mr-5"></i><span>Thêm</span> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end product card-->
                            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".3s">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img">
                                            <a href="#">
                                                <img class="default-img" src="assets/imgs/product/EW_MALL_Ecobi_DryWipes_270s_Combo3_1.jpg" alt>
                                                <img class="hover-img" src="assets/imgs/product/EW_MALL_Ecobi_DryWipes_270s_Combo3_2.jpg" alt>
                                            </a>
                                        </div>
                                        <div class="product-action-1">
                                            <a aria-label="Xem trước" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                        </div>
                                        <div class="product-badges product-badges-position product-badges-mrg">
                                            <span class="new">New</span>
                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="product-category">
                                            <a href="shop-grid-right.html">Khăn Gia Đình</a>
                                        </div>
                                        <h2><a href="#">Combo 3 túi Khăn Khô Đa Năng 270 tờ</a></h2>
                                        <div>
                                            <span class="font-small text-muted">Thương hiệu: <a href="vendor-details-1.html">Ecobi</a></span>
                                        </div>
                                        <div class="product-card-bottom">
                                            <div class="product-price">
                                                <span>145.500 đ</span>
                                                <span class="old-price">150.000 đ</span>
                                            </div>
                                            <div class="add-cart">
                                                <a class="add" href="shop-cart.html"><i class="fi-rs-shopping-cart mr-5"></i><span>Thêm</span> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end product card-->
                            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".4s">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img">
                                            <a href="#">
                                                <img class="default-img" src="assets/imgs/product/EW_MALL_ECOBI_80s_PINK_0Thumb.png" alt>
                                                <img class="hover-img" src="assets/imgs/product/EW_MALL_ECOBI_80s_PINK_Features_01.png" alt>
                                            </a>
                                        </div>
                                        <div class="product-action-1">
                                            <a aria-label="Xem trước" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                        </div>
                                        <div class="product-badges product-badges-position product-badges-mrg">
                                            <span class=""></span>
                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="product-category">
                                            <a href="shop-grid-right.html">Khăn Gia Đình</a>
                                        </div>
                                        <h2><a href="#">Khăn ướt Ecobi 80 tờ - Không Mùi</a></h2>
                                        <div>
                                            <span class="font-small text-muted">Thương hiệu: <a href="vendor-details-1.html">Ecobi</a></span>
                                        </div>
                                        <div class="product-card-bottom">
                                            <div class="product-price">
                                                <span>38.000 đ</span>
                                                <span class="old-price"></span>

                                            </div>
                                            <div class="add-cart">
                                                <a class="add" href="shop-cart.html"><i class="fi-rs-shopping-cart mr-5"></i><span>Thêm</span> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end product card-->
                            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".5s">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img">
                                            <a href="#">
                                                <img class="default-img" src="assets/imgs/product/EW_EcoTissue_FacialTissue_Blue_01.png" alt>
                                                <img class="hover-img" src="assets/imgs/product/EW_EcoTissue_FacialTissue_Blue_03.png" alt>
                                            </a>
                                        </div>
                                        <div class="product-action-1">
                                            <a aria-label="Xem trước" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                        </div>
                                        <div class="product-badges product-badges-position product-badges-mrg">
                                            <span class="best">-5%</span>
                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="product-category">
                                            <a href="shop-grid-right.html">Giấy</a>
                                        </div>
                                        <h2><a href="#">Giấy lụa cao cấp Hộp rút 180 tờ</a></h2>
                                        <div>
                                            <span class="font-small text-muted">Thương hiệu: <a href="vendor-details-1.html">EcoTissue</a></span>
                                        </div>
                                        <div class="product-card-bottom">
                                            <div class="product-price">
                                                <span>38.000 đ</span>
                                                <span class="old-price">40.000 đ</span>
                                            </div>
                                            <div class="add-cart">
                                                <a class="add" href="shop-cart.html"><i class="fi-rs-shopping-cart mr-5"></i><span>Thêm</span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end product card-->
                        </div>
                        <!--End product-grid-4-->
                    </div>
                    <!--En tab one-->
                </div>
                <!--End tab-content-->
            </div>
        </section>
        <!--Products Tabs-->

        <section class="newsletter mb-15 wow animate__animated animate__fadeIn">
            <div class="container">
                <div class="position-relative newsletter-inner">
                    <div class="newsletter-content">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h2 class="mb-20 text-white">
                                    Nhận ưu đãi và<br> coupon mới nhất!
                                </h2>
                                <p class="mb-45 text-white">Đăng ký để nhận được thông báo mới nhất</p>

                            </div>
                            <div class="col-md-6">
                                <form class="form-subcriber d-flex">
                                    <input type="email" placeholder="Nhập địa chỉ email của bạn">
                                    <button class="btn" type="submit" style="width: 200px;">Đăng ký</button>
                                </form>
                            </div>
                            <!-- <img src="assets/imgs/banner/banner-1.png" alt="newsletter"> 72be44   AEEB88 -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="featured section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-1-4 col-md-3 col-6 col-sm-6 mb-md-4 mb-xl-0">
                        <div class="banner-left-icon d-flex align-items-center wow animate__animated animate__fadeInUp" data-wow-delay="0">
                            <div class="banner-icon">
                                <img src="assets/imgs/theme/icons/icon-3.svg" alt>
                            </div>
                            <div class="banner-text">
                                <h3 class="icon-box-title">Hỗ trợ trực tiếp</h3>
                                <p>Khi khách hàng cần</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1-4 col-md-3 col-6 col-sm-6">
                        <div class="banner-left-icon d-flex align-items-center wow animate__animated animate__fadeInUp" data-wow-delay=".1s">
                            <div class="banner-icon">
                                <img src="assets/imgs/theme/icons/icon-2.svg" alt>
                            </div>
                            <div class="banner-text">
                                <h3 class="icon-box-title">Nhiều ưu đãi</h3>
                                <p>Giỏ hàng to, ưu đãi lớn</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1-4 col-md-3 col-6 col-sm-6">
                        <div class="banner-left-icon d-flex align-items-center wow animate__animated animate__fadeInUp" data-wow-delay=".2s">
                            <div class="banner-icon">
                                <img src="assets/imgs/theme/icons/icon-1.svg" alt>
                            </div>
                            <div class="banner-text">
                                <h3 class="icon-box-title">Bảo hành</h3>
                                <p>Đừng ngại đặt hàng</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1-4 col-md-3 col-6 col-sm-6">
                        <div class="banner-left-icon d-flex align-items-center wow animate__animated animate__fadeInUp" data-wow-delay=".3s">
                            <div class="banner-icon">
                                <img src="assets/imgs/theme/icons/icon-4.svg" alt>
                            </div>
                            <div class="banner-text">
                                <h3 class="icon-box-title">Đổi trả dễ dàng</h3>
                                <p>Bảo đảm an toàn</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php require_once 'footer.php' ?>
    </main>


    <!-- Preloader Start -->
    <!-- <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="text-center">
                    <img src="assets/imgs/theme/loading.gif" alt>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Vendor JS-->
    <?php require_once 'script.php' ?>

    <script>
        $('#clock').countdown('2022/07/21 00:00:00').on('update.countdown',
            function(event) {
                var $this = $(this).html(event.strftime('' +
                    '<span class="countdown-section"><span class="countdown-amount hover-up">%D</span><span class="countdown-period"> Ngày </span></span>' +
                    '<span class="countdown-section"><span class="countdown-amount hover-up">%H</span><span class="countdown-period"> Giờ </span></span>' +
                    '<span class="countdown-section"><span class="countdown-amount hover-up">%M</span><span class="countdown-period"> Phút </span></span>' +
                    '<span class="countdown-section"><span class="countdown-amount hover-up">%S</span><span class="countdown-period"> Giây </span></span>'));
            });
    </script>

    <!-- <script type="text/javascript">
    $("#clock").countdown("2022/07/09 00:00:00", function(event) {
        $(this).text(
            event.strftime(''
                    +'<span class="countdown-section"><span class="countdown-amount hover-up">%-d</span><span class="countdown-period"> Ngày%!d </span></span>' 
                    +'<span class="countdown-section"><span class="countdown-amount hover-up">%H</span><span class="countdown-period"> Giờ </span></span>' 
                    +'<span class="countdown-section"><span class="countdown-amount hover-up">%M</span><span class="countdown-period"> Phút </span></span>' 
                    +'<span class="countdown-section"><span class="countdown-amount hover-up">%S</span><span class="countdown-period"> Giây </span></span>')
        );
    });
    </script> -->

</body>

</html>