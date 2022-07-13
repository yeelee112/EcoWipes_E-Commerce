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
    <main class="main cart-screen">
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
                    <h1 class="heading-2 mb-10">
                        Giỏ hàng
                    </h1>
                    <div class="d-flex justify-content-between">
                        <h6 class="text-body">Có tất cả <span class="text-brand">3</span> sản phẩm trong giỏ hàng của bạn</h6>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="cart">
                        <div class="cart-header middle-text">
                            <div class="row">
                                <div class="col-md-5">
                                    Sản phẩm
                                </div>
                                <div class="d-none d-md-block col">
                                    <div class="row">
                                        <div class="col-md-3">Giá</div>
                                        <div class="col-md-4">Số lượng</div>
                                        <div class="col-md-3">Tổng</div>
                                        <div class="col-md-2"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cart-body">
                            <div class="cart-item">
                                <div class=" d-flex align-items-center text-start row">
                                    <div class="col-md-5 col-12">
                                        <div class="d-flex align-items-center"><a href="#"><img class="cart-item-img" src="assets/imgs/product/EW_MALL_ECOBI_80s_BLUE_0Thumb.png" alt="..." /></a>
                                            <div class="cart-title text-start"><a class="text-uppercase text-dark text-product-cart" href="#">Khăn ướt Ecobi 80 tờ - Không Mùi</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4 mt-md-0 col-md-7 col-12">
                                        <div class="align-items-center row">
                                            <div class="col-md-3">
                                                <div class="row">
                                                    <div class="d-md-none text-muted col-6">Giá</div>
                                                    <div class="text-start col-md-12 col-6 price-per-item">38.000 đ
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="align-items-center row">
                                                    <div class="d-md-none text-muted col-md-12 col-6">Số lượng</div>
                                                    <div class="col-md-12 col-sm-3 col-5">
                                                        <div class="detail-qty mb-0">
                                                            <a class="btn-items btn-items-decrease border"><i class="fa-solid fa-minus"></i></a>
                                                            <input class="qty-val border" id="qty-val" value="1" min="1" type="number" inputmode="numeric" max="90" oninput="this.value = Math.abs(this.value)"></input>
                                                            <a class="btn-items btn-items-increase border"><i class="fa-solid fa-plus"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="row">
                                                    <div class="d-md-none text-muted col-6">Tổng</div>
                                                    <div class="text-start col-md-12 col-6 text-total-price">
                                                        <!-- -->38.000 đ
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-none d-md-block text-center col-2">
                                                <a class="cart-remove" href="#">Xóa</a>
                                            </div>
                                            <a class="cart-remove close text-md-center mt-3 d-md-none" href="#">Xóa</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="cart-item">
                                <div class=" d-flex align-items-center text-start row">
                                    <div class="col-md-5 col-12">
                                        <div class="d-flex align-items-center"><a href="#"><img class="cart-item-img" src="assets/imgs/product/EW_MALL_ECOBI_80s_BLUE_0Thumb.png" alt="..." /></a>
                                            <div class="cart-title text-start"><a class="text-uppercase text-dark text-product-cart" href="#">Khăn ướt Ecobi 80 tờ - Không Mùi</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4 mt-md-0 col-md-7 col-12">
                                        <div class="align-items-center row">
                                            <div class="col-md-3">
                                                <div class="row">
                                                    <div class="d-md-none text-muted col-6">Giá</div>
                                                    <div class="text-start col-md-12 col-6 price-per-item">38.000 đ
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="align-items-center row">
                                                    <div class="d-md-none text-muted col-md-12 col-6">Số lượng</div>
                                                    <div class="col-md-12 col-sm-3 col-5 a">
                                                        <div class="detail-qty mb-0">
                                                            <a class="btn-items btn-items-decrease border"><i class="fa-solid fa-minus"></i></a>
                                                            <input class="qty-val border" id="qty-val" value="1" min="1" type="number" inputmode="numeric" max="90" oninput="this.value = Math.abs(this.value)"></input>
                                                            <a class="btn-items btn-items-increase border"><i class="fa-solid fa-plus"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="row">
                                                    <div class="d-md-none text-muted col-6">Tổng</div>
                                                    <div class="text-start col-md-12 col-6 text-total-price">38.000 đ
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-none d-md-block text-center col-2">
                                                <a class="cart-remove" href="#">Xóa</a>
                                            </div>
                                            <a class="cart-remove close text-md-center mt-3 d-md-none" href="#">Xóa</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="my-5 d-flex justify-content-between flex-column flex-lg-row">
                            <div class="cart-action d-flex justify-content-between">
                                <a class="btn "><i class="fi-rs-arrow-left mr-10"></i>Tiếp tục mua sắm</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    
                </div>
            </div>
        </div>
    </main>
    <?php require_once 'footer.php' ?>
    <?php require_once 'script.php' ?>
    <script>
        const maxQuantity = 10000;
        const maxInputQuantity = 99999;

        // $('#qty-val').on('input', function() {
        //     var maxValue = $(this).parent().children('#qty-val').attr("max");
        //     var value = $(this).val();

        //     if ((value !== '') && (value.indexOf('.') === -1)) {

        //         $(this).val(Math.max(Math.min(value, maxValue), 1));
        //     }
        // });

        (function($) {
            $.fn.inputFilter = function(inputFilter) {
                return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
                    if (inputFilter(this.value)) {
                        this.oldValue = this.value;
                        this.oldSelectionStart = this.selectionStart;
                        this.oldSelectionEnd = this.selectionEnd;
                    } else if (this.hasOwnProperty("oldValue")) {
                        this.value = this.oldValue;
                        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                    } else {
                        this.value = "";
                    }
                });
            };
        }(jQuery));

        $("#intLimitTextBox").inputFilter(function(value) {
            return /^\d*$/.test(value) && (value === "" || parseInt(value) <= maxInputQuantity && parseInt(value) > 0);
        });

        $(".btn-items-decrease").click(function() {
            var findNumb = $(this).parent().children("input").val();
            var maxQuantity = $(this).parent().children('#qty-val').attr("max");

            if (findNumb > 1) {
                $(this).css("visibility", "visible");
                findNumb--;
                $(this).parent().children("input").val(findNumb);

                var totalPrice = $(this).closest(".cart-item").find(".text-total-price");
                var totalPriceText = totalPrice.text();
                var totalPriceNumb = Number(totalPriceText.replace(/[^0-9.-]+/g, ""));

                if ($(this).parent().children("input").val() < maxQuantity) {
                    $(this).closest(".cart-item").find(".btn-items-increase").css("visibility", "visible");
                }
                var pricePerItem = $(this).closest(".cart-item").find(".price-per-item").text();
                var pricePerItemNumb = Number(pricePerItem.replace(/[^0-9.-]+/g, ""));

                totalPriceNumb = pricePerItemNumb * findNumb;
                totalPriceNumb = totalPriceNumb.toFixed(3) + ' đ';
                totalPrice.text(totalPriceNumb);
            }
            if (findNumb == 1) {
                $(this).css("visibility", "hidden");
            }
        });

        $(".btn-items-increase").click(function() {
            var maxQuantity = $(this).parent().children('#qty-val').attr("max");
            var findNumb = $(this).parent().children("input").val();
            findNumb++;
            $(this).parent().children("input").val(findNumb);
            if ($(this).parent().children("input").val() >= maxQuantity) {
                $(this).parent().children("input").val(maxQuantity);
                $(this).css("visibility", "hidden");
            }

            if (findNumb == 1) {
                $(this).closest(".cart-item").find(".btn-items-decrease").css("visibility", "hidden");
            }

            if (findNumb > 1) {
                $(this).closest(".cart-item").find(".btn-items-decrease").css("visibility", "visible");
            }

            var totalPrice = $(this).closest(".cart-item").find(".text-total-price");
            var totalPriceText = totalPrice.text();
            var totalPriceNumb = Number(totalPriceText.replace(/[^0-9.-]+/g, ""));

            var pricePerItem = $(this).closest(".cart-item").find(".price-per-item").text();
            var pricePerItemNumb = Number(pricePerItem.replace(/[^0-9.-]+/g, ""));

            totalPriceNumb = pricePerItemNumb * findNumb;
            totalPriceNumb = totalPriceNumb.toFixed(3) + ' đ';
            totalPrice.text(totalPriceNumb);
        });

        $("input").on('input', function() {
            var maxQuantity = $(this).parent().children('#qty-val').attr("max");
            var findQuantity = $(this).parent().children("input").val();
            var value = $(this).val();

            if ((value !== '') && (value.indexOf('.') === -1)) {

                $(this).val(Math.max(Math.min(value, maxQuantity), 1));
            }
            if ($(this).val() < 0) {
                $(this).val("1");
            }

            if ($(this).val() == 1) {
                $(this).closest(".cart-item").find(".btn-items-decrease").css("visibility", "hidden");
            }

            if ($(this).val() > 1) {
                $(this).closest(".cart-item").find(".btn-items-decrease").css("visibility", "visible");
            }

            if ($(this).val() >= maxQuantity) {
                $(this).val(maxQuantity);
                $(this).closest(".cart-item").find(".btn-items-increase").css("visibility", "hidden");
            }

            if ($(this).val() < maxQuantity) {
                $(this).closest(".cart-item").find(".btn-items-increase").css("visibility", "visible");
            }

            var findNumb = $(this).val();

            var totalPrice = $(this).closest(".cart-item").find(".text-total-price");
            var totalPriceText = totalPrice.text();
            var totalPriceNumb = Number(totalPriceText.replace(/[^0-9.-]+/g, ""));

            var pricePerItem = $(this).closest(".cart-item").find(".price-per-item").text();
            var pricePerItemNumb = Number(pricePerItem.replace(/[^0-9.-]+/g, ""));

            totalPriceNumb = pricePerItemNumb * findNumb;
            totalPriceNumb = totalPriceNumb.toFixed(3) + ' đ';

            totalPrice.text(totalPriceNumb);
        });
    </script>
</body>

</html>