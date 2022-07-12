<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <title>EcoWipes | E-Commerce</title>
    <?php require_once 'library.php'; ?>

</head>

<body>
    <!-- Quick view -->
    <?php require_once 'header.php' ?>
    <!--End header-->
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href rel="nofollow"><i class="fi-rs-home mr-5"></i>Trang chủ</a>
                    <span></span> <a href="shop">Cửa hàng</a>
                    <span></span> Giỏ hàng
                </div>
            </div>
        </div>
        <div class="container mb-80 mt-50">
            <div class="row">
                <div class="col-lg-8 mb-40">
                    <h1 class="heading-2 mb-10">Giỏ hàng

                    </h1>
                    <div class="d-flex justify-content-between">
                        <h6 class="text-body">Có tất cả <span class="text-brand">3</span> sản phẩm trong giỏ hàng của bạn</h6>
                        <h6 class="text-body"><a href="#" class="text-muted"><i class="fi-rs-trash mr-5"></i>Clear Cart</a></h6>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="table-responsive shopping-summery">
                        <table class="table table-wishlist">
                            <thead>
                                <tr class="main-heading">
                                    <th class="custome-checkbox start pl-30">
                                        <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox11" value>
                                        <label class="form-check-label" for="exampleCheckbox11"></label>
                                    </th>
                                    <th scope="col" colspan="2">Product</th>
                                    <th scope="col">Unit Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Subtotal</th>
                                    <th scope="col" class="end">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="pt-30">
                                    <td class="custome-checkbox pl-30">
                                        <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox1" value>
                                        <label class="form-check-label" for="exampleCheckbox1"></label>
                                    </td>
                                    <td class="image product-thumbnail pt-40"><img src="assets/imgs/product/EW_MALL_ECOBI_80s_BLUE_0Thumb.png" alt="#"></td>
                                    <td class="product-des product-name">
                                        <h6 class="mb-5"><a class="product-name mb-10 text-heading" href="shop-product-right.html">Khăn ướt Ecobi 80 tờ - Không Mùi</a></h6>

                                    </td>
                                    <td class="price" data-title="Price">
                                        <h4 class="text-body">38.000 đ </h4>
                                    </td>
                                    <td class="text-center detail-info" data-title="Stock">
                                        <div class="detail-extralink mr-15">
                                            <div class="detail-qty">
                                                <a class="qty-down border"><i class="fa-solid fa-minus"></i></a>
                                                <input class="qty-val border" id="qty-val" value="1" min="1" type="number" inputmode="numeric" max="90" oninput="this.value = Math.abs(this.value)"></input>
                                                <a class="qty-up border"><i class="fa-solid fa-plus"></i></a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="price" data-title="Price">
                                        <h4 class="text-brand">38.000 đ </h4>
                                    </td>
                                    <td class="action text-center" data-title="Remove"><a href="#" class="text-body"><i class="fi-rs-trash"></i></a></td>
                                </tr>
                                <tr>
                                    <td class="custome-checkbox pl-30">
                                        <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox2" value>
                                        <label class="form-check-label" for="exampleCheckbox2"></label>
                                    </td>
                                    <td class="image product-thumbnail"><img src="assets/imgs/product/EW_MALL_ECOBI_80s_BLUE_0Thumb.png" alt="#"></td>
                                    <td class="product-des product-name">
                                        <h6 class="mb-5"><a class="product-name mb-10 text-heading" href="shop-product-right.html">Khăn ướt Ecobi 80 tờ - Không Mùi</a></h6>
                                    </td>
                                    <td class="price" data-title="Price">
                                        <h4 class="text-body">38.000 đ </h4>
                                    </td>
                                    <td class="text-center detail-info" data-title="Stock">
                                        <div class="detail-extralink mr-15">
                                            <div class="detail-qty">
                                                <a class="qty-down border"><i class="fa-solid fa-minus"></i></a>
                                                <input class="qty-val border" id="qty-val" value="1" min="1" type="number" inputmode="numeric" max="90" oninput="this.value = Math.abs(this.value)"></input>
                                                <a class="qty-up border"><i class="fa-solid fa-plus"></i></a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="price" data-title="Price">
                                        <h4 class="text-brand">38.000 đ </h4>
                                    </td>
                                    <td class="action text-center" data-title="Remove"><a href="#" class="text-body"><i class="fi-rs-trash"></i></a></td>
                                </tr>
                                <tr>
                                    <td class="custome-checkbox pl-30">
                                        <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox3" value>
                                        <label class="form-check-label" for="exampleCheckbox3"></label>
                                    </td>
                                    <td class="image product-thumbnail"><img src="assets/imgs/product/EW_MALL_ECOBI_80s_BLUE_0Thumb.png" alt="#"></td>
                                    <td class="product-des product-name">
                                        <h6 class="mb-5"><a class="product-name mb-10 text-heading" href="shop-product-right.html">Khăn ướt Ecobi 80 tờ - Không Mùi</a></h6>
                                    </td>
                                    <td class="price" data-title="Price">
                                        <h4 class="text-body">38.000 đ </h4>
                                    </td>
                                    <td class="text-center detail-info" data-title="Stock">
                                        <div class="detail-extralink mr-15">
                                            <div class="detail-qty">
                                                <a class="qty-down border"><i class="fa-solid fa-minus"></i></a>
                                                <input class="qty-val border" id="qty-val" value="1" min="1" type="number" inputmode="numeric" max="90" oninput="this.value = Math.abs(this.value)"></input>
                                                <a class="qty-up border"><i class="fa-solid fa-plus"></i></a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="price" data-title="Price">
                                        <h4 class="text-brand">38.000 đ </h4>
                                    </td>
                                    <td class="action text-center" data-title="Remove"><a href="#" class="text-body"><i class="fi-rs-trash"></i></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="divider-2 mb-30"></div>
                    <div class="cart-action d-flex justify-content-between">
                        <a class="btn "><i class="fi-rs-arrow-left mr-10"></i>Continue Shopping</a>
                        <a class="btn  mr-10 mb-sm-15"><i class="fi-rs-refresh mr-10"></i>Update Cart</a>
                    </div>
                    <div class="row mt-50">
                        <div class="col-lg-7">
                            <div class="calculate-shiping p-40 border-radius-15 border">
                                <h4 class="mb-10">Calculate Shipping</h4>
                                <p class="mb-30"><span class="font-lg text-muted">Flat rate:</span><strong class="text-brand">5%</strong></p>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="p-40">
                                <h4 class="mb-10">Apply Coupon</h4>
                                <p class="mb-30"><span class="font-lg text-muted">Using A Promo Code?</span></p>
                                <form action="#">
                                    <div class="d-flex justify-content-between">
                                        <input class="font-medium mr-15 coupon" name="Coupon" placeholder="Enter Your Coupon">
                                        <button class="btn"><i class="fi-rs-label mr-10"></i>Apply</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="border p-md-4 cart-totals ml-30">
                        <div class="table-responsive">
                            <table class="table no-border">
                                <tbody>
                                    <tr>
                                        <td class="cart_total_label">
                                            <h6 class="text-muted">Subtotal</h6>
                                        </td>
                                        <td class="cart_total_amount">
                                            <h4 class="text-brand text-end">$12.31</h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="col" colspan="2">
                                            <div class="divider-2 mt-10 mb-10"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="cart_total_label">
                                            <h6 class="text-muted">Shipping</h6>
                                        </td>
                                        <td class="cart_total_amount">
                                            <h5 class="text-heading text-end">Free </h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="cart_total_label">
                                            <h6 class="text-muted">Estimate for</h6>
                                        </td>
                                        <td class="cart_total_amount">
                                            <h5 class="text-heading text-end">United Kingdom </h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="col" colspan="2">
                                            <div class="divider-2 mt-10 mb-10"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="cart_total_label">
                                            <h6 class="text-muted">Total</h6>
                                        </td>
                                        <td class="cart_total_amount">
                                            <h4 class="text-brand text-end">$12.31</h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <a href="#" class="btn mb-20 w-100">Proceed To CheckOut<i class="fi-rs-sign-out ml-15"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php require_once 'footer.php' ?>
    <?php require_once 'script.php' ?>
</body>

</html>