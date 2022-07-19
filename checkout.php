<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <title>EcoWipes | E-Commerce</title>
    <?php require_once 'library.php'; ?>
</head>

<body>
    <?php require_once 'header.php' ?>
    <main class="main cart-screen">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href rel="nofollow"><i class="fi-rs-home mr-5"></i>Trang chủ</a>
                    <span></span> Giỏ hàng
                    <span></span>
                    <div>Thanh toán</div>
                </div>
            </div>
        </div>
        <div class="container mb-80 mt-30 pb-80">
            <div class="row">
                <div class="col">
                    <div class="info-user-shipping">
                        <h4 class="info-shipping-title">Thông tin nhận hàng</h4>
                        <form method="post" class="form-user-info-shipping">
                            <div class="row">
                                <div class="form-group col-lg-4">
                                    <label for="inputName" class="form-label">Họ tên *</label>
                                    <input type="text" id="inputName" required name="name">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="inputPhone" class="form-label">Số điện thoại *</label>
                                    <input type="text" pattern="\d*" id="inputPhone" maxlength="10" required name="phone">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="inputEmail" class="form-label">Email</label>
                                    <input required type="email" id="inputEmail" name="email">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label for="inputAddress" class="form-label">Địa chỉ cụ thể *</label>
                                    <input type="text" id="inputAddress" name="address" required>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col">
                    <div class="cart mt-20">
                        <div class="cart-header middle-text">
                            <div class="row">
                                <div class="col-md-5">
                                    Sản phẩm
                                </div>
                                <div class="d-none d-md-block col">
                                    <div class="row">
                                        <div class="col-md-3">Đơn giá</div>
                                        <div class="col-md-4 d-flex justify-content-center">Số lượng</div>
                                        <div class="col-md-5 d-flex justify-content-end">Tổng</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cart-body">
                            <div class="cart-item">
                                <div class=" d-flex align-items-center text-start row">
                                    <div class="col-md-5 col-12">
                                        <div class="d-flex align-items-center"><a href="#"><img class="cart-item-img" src="assets/imgs/product/EW_MALL_ECOBI_80s_PINK_0Thumb.png" alt="..." /></a>
                                            <div class="cart-title text-start"><a class="text-uppercase text-dark text-product-cart" href="#">Khăn ướt Ecobi 80 tờ - Hương Dịu Nhẹ</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4 mt-md-0 col-md-7 col-12">
                                        <div class="align-items-center row">
                                            <div class="col-md-3">
                                                <div class="row align-items-center">
                                                    <div class="d-md-none text-muted col-6">Đơn giá</div>
                                                    <div class="text-start col-md-12 col-6 price-per-item">
                                                        <input type="hidden" class="hidden-input" value="40000">
                                                        <div class="first-price">40.000 ₫</div>
                                                        <!-- <div class="original-price">40.000 đ</div> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="align-items-center row">
                                                    <div class="d-md-none text-muted col-md-12 col-6">Số lượng</div>
                                                    <div class="col-md-12 col-sm-3 col-5 d-md-flex justify-content-center">
                                                        <div class="detail-qty mb-0">
                                                            1
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="row">
                                                    <div class="d-md-none text-muted col-6">Tổng</div>
                                                    <div class="text-start col-md-12 col-6 text-total-price d-md-flex justify-content-end">
                                                        40.000 ₫
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="cart-item">
                                <div class="d-flex align-items-center text-start row">
                                    <div class="col-md-5 col-12">
                                        <div class="d-flex align-items-center"><a href="#"><img class="cart-item-img" src="assets/imgs/product/EW_MALL_ECOBI_80s_BLUE_0Thumb.png" alt="..." /></a>
                                            <div class="cart-title text-start"><a class="text-uppercase text-dark text-product-cart" href="#">Khăn ướt Ecobi 80 tờ - Không Mùi</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4 mt-md-0 col-md-7 col-12">
                                        <div class="align-items-center row">
                                            <div class="col-md-3">
                                                <div class="row align-items-center">
                                                    <div class="d-md-none text-muted col-6">Đơn giá</div>
                                                    <div class="text-start col-md-12 col-6 price-per-item">
                                                        <input type="hidden" class="hidden-input" value="38000">
                                                        <div class="first-price">38.000 ₫</div>
                                                        <div class="second-price">40.000 ₫</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="align-items-center row">
                                                    <div class="d-md-none text-muted col-md-12 col-6">Số lượng</div>
                                                    <div class="col-md-12 col-sm-3 col-5 d-md-flex justify-content-center">
                                                        <div class="detail-qty mb-0">
                                                            2
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="row">
                                                    <div class="d-md-none text-muted col-6">Tổng</div>
                                                    <div class="text-start col-md-12 col-6 text-total-price d-md-flex justify-content-end">
                                                        76.000 ₫
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
                <div class="col">
                    <div class="confirm-shipping-container">
                        <div class="row g-0">
                            <div class="col-md-6">
                                <div class="feature-checkout-container d-inline-flex align-items-center">
                                    <label for="inputMessage" class="lb-message">Lời nhắn:</label>
                                    <input type="text" id="inputMessage" name="message" placeholder="Lưu ý cho cửa hàng" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="feature-checkout-container d-inline-flex align-items-center">
                                    <label for="inputVoucher" class="lb-message"><img class="pr-5" src="assets/imgs/voucher.svg">Voucher: </label>
                                    <input type="text" id="inputVoucher" name="voucher" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col d-flex justify-content-end align-items-center">
                                <div class="title-payment-method"> Phương thức thanh toán</div>
                                <div class="payment-method-radio-container">
                                    <input type="radio" class="btn-check" name="payment-method" id="cod" autocomplete="off" value="COD" checked>
                                    <label class="btn-shipping-method mb-0 ml-20" for="cod">
                                        Thanh toán khi nhận hàng
                                        <div class="checked-payment-method">
                                            <svg enable-background="new 0 0 12 12" viewBox="0 0 12 12" x="0" y="0" class="shopee-svg-icon icon-tick-bold">
                                                <g>
                                                    <path d="m5.2 10.9c-.2 0-.5-.1-.7-.2l-4.2-3.7c-.4-.4-.5-1-.1-1.4s1-.5 1.4-.1l3.4 3 5.1-7c .3-.4 1-.5 1.4-.2s.5 1 .2 1.4l-5.7 7.9c-.2.2-.4.4-.7.4 0-.1 0-.1-.1-.1z"></path>
                                                </g>
                                            </svg>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col d-flex justify-content-end align-items-center">
                                <div class="title-checkout-container">
                                    Thành tiền (3 sản phẩm):
                                </div>
                                <div class="total-price-checkout-container">
                                    116.000 ₫
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col d-flex justify-content-end align-items-center">
                    <div class="btn-order-container">
                        <button class="btn btn-order">Đặt hàng</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php require_once 'footer.php' ?>
    <?php require_once 'script.php' ?>
</body>

</html>