<?php
$priceToFreeShip = 0;
$messageContainerFreeShip = '';
?>


<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <title>Giỏ hàng - Thế Giới Khăn Ướt</title>
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
                    <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Trang chủ</a>
                    <span></span> Giỏ hàng
                    <span></span>
                    <div class="breadcrumb-next-step">Thanh toán</div>
                </div>
            </div>
        </div>
        <div class="container mb-80 mt-50">
            <div class="row">
                <div class="col-lg-8 mb-40">
                    <h1 class="heading-2 mb-10">
                        Giỏ hàng
                    </h1>
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
                            <?php
                            require_once 'DataProvider.php';

                            if ($count > 0) {
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
                                    <div class="cart-item">
                                        <div class=" d-flex align-items-center text-start row">
                                            <div class="col-md-5 col-12">
                                                <div class="d-flex align-items-center"><a href="product?item=<?php echo $row1["product_text"] ?>"><img class="cart-item-img" src="<?php echo $row1["img_thumb"] ?>" alt="..." /></a>
                                                    <div class="cart-title text-start">
                                                        <a class="text-uppercase text-dark text-product-cart" href="product?item=<?php echo $row1["product_text"] ?>"><?php echo $row1["product_name"] ?></a>
                                                        <div class="row align-items-center d-md-none">
                                                            <div class="text-start col-md-12 col-12 price-per-item">
                                                                <input type="hidden" class="hidden-input" value="<?php echo $row1["price"] ?>">
                                                                <div class="first-price"><?php echo number_format($row1["price"], 0, ",", "."); ?> ₫</div>
                                                                <!-- <div class="original-price">40.000 đ</div> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-md-0 col-md-7 col-12">
                                                <div class="align-items-center row">
                                                    <div class="col-md-3 mt-5 mb-5">
                                                        <div class="row align-items-center">
                                                            <div class="text-start col-md-12 col-6 price-per-item d-none d-md-block">
                                                                <input type="hidden" class="hidden-input" value="<?php echo $row1["price"] ?>">
                                                                <div class="first-price"><?php echo number_format($row1["price"], 0, ",", "."); ?> ₫</div>
                                                                <!-- <div class="original-price">40.000 đ</div> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-5 mb-5">
                                                        <div class="align-items-center row">
                                                            <div class="d-md-none text-muted col-md-12 col-6">Số lượng</div>
                                                            <div class="col-md-12 col-sm-3 col-5">
                                                                <div class="detail-qty mb-0">
                                                                    <input type="hidden" class="hidden-product-text" value="<?php echo $row1["product_text"] ?>">
                                                                    <a class="btn-items btn-items-decrease border" style="left: 1px;position: relative;"><i class="fa-solid fa-minus"></i></a>
                                                                    <input class="qty-val border" id="qty-val" value="<?php echo $_SESSION['cart'][$row1['product_text']]['quantity'] ?>" min="1" type="number" inputmode="numeric" max="90" oninput="this.value = Math.abs(this.value)"></input>
                                                                    <a class="btn-items btn-items-increase border" style="left: -1px;position: relative;"><i class="fa-solid fa-plus"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mt-5 mb-5">
                                                        <div class="row">
                                                            <div class="d-md-none text-muted col-6">Tổng</div>
                                                            <div class="text-start col-md-12 col-6 text-total-price">
                                                                <!-- 40.000 ₫-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-none d-md-block text-center col-2">
                                                        <button class="cart-remove" onclick="remove_from_cart(this.value);" value="<?php echo $row1["product_text"] ?>">Xóa</button>
                                                    </div>
                                                    <button class="cart-remove close text-md-center d-md-none" onclick="remove_from_cart(this.value);" value="<?php echo $row1["product_text"] ?>">Xóa</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                }
                            } else {
                                echo '<div class="empty-product-cart">Chưa có sản phẩm nào trong giỏ hàng.</div>';
                            } ?>
                        </div>
                        <div class="my-5 d-flex justify-content-between flex-column flex-lg-row">
                            <div class="cart-action d-flex justify-content-between">
                                <a href="shop" class="continue-purchase-btn">
                                    <ion-icon name="chevron-back-outline"></ion-icon>
                                    <div class="pl-10">Tiếp tục mua sắm</div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="total-cart">
                        <div class="cart-header middle-text">
                            <div class="row">
                                <div class="col-md-12">
                                    Thanh toán
                                </div>
                            </div>
                        </div>
                        <?php
                            if ($priceTotal < $freeShippingUrbanLevel) {
                                $priceToFreeShip = $freeShippingUrbanLevel - $priceTotal;
                                $messageContainerFreeShip = '
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="price-count-free-ship">Chà, chỉ cần mua thêm <strong>' . number_format($priceToFreeShip, 0, ",", ".") . '₫</strong> nữa, bạn sẽ được <span class="free-ship-text">FREESHIP</span> ở TP.HCM hoặc giảm 25% phí ship toàn quốc luôn đó, dạo một vòng nữa nào!<br>
                                                    </div>
                                                </div>
                                            </div>';
                            } else if ($priceTotal < $freeShippingSubUrbanLevel) {
                                $priceToFreeShip = $freeShippingSubUrbanLevel - $priceTotal;
                                $messageContainerFreeShip = '
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="price-count-free-ship">Ngon lành! Bạn đã được <span class="free-ship-text mb-5">FREESHIP</span> tại TP.HCM.<br>
                                                    Giờ mà mua thêm <strong>' . number_format($priceToFreeShip, 0, ",", ".") . '₫</strong> nữa, bạn sẽ được <span class="free-ship-text">FREESHIP</span> toàn quốc luôn đó nha.
                                                    </div>
                                                </div>
                                            </div>';
                            } else if ($priceTotal > $freeShippingUrbanLevel && $priceTotal < $freeShippingSubUrbanLevel) {
                                $messageContainerFreeShip = '
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="price-count-free-ship">YAY bạn đã được FREESHIP ngay tại TP Hồ Chí Minh<br>
                                                    </div>
                                                </div>
                                            </div>';
                            }
                        ?>
                        <div class="total-cart-body">
                            <div class="row">
                                <div class="col-5">
                                    <p class="order-summary-label">Tạm tính</p>
                                </div>
                                <div class="col-7 text-end">
                                    <p class="order-summary-value"><?php echo number_format($priceTotal, 0, ",", "."); ?> ₫</p>
                                    <input type="hidden" class="input-sub-total" value="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    <p class="ship-summary-label">Vận chuyển</p>
                                </div>
                                <div class="col-7 text-end">
                                    <p class="ship-summary-value">Chưa xác định</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    <p class="total-summary-label">Tổng cộng</p>
                                </div>
                                <div class="col-7 text-end">
                                    <p class="total-summary-value"><?php echo number_format($priceTotal, 0, ",", "."); ?> ₫<span> *</span></p>
                                    <p class="sup-total-summary-label">
                                        (Chưa bao gồm phí ship)
                                    </p>
                                    <input type="hidden" class="input-total-summary" value="">
                                </div>
                            </div>
                            <?php echo $messageContainerFreeShip; ?>
                        </div>
                    </div>
                    <div class="coupon-container">
                        <div class="row">
                            <div class="col-12">
                                <label class="coupon-label">Mã giảm giá</label>
                                <form method="post" id="apply-coupon" class="apply-coupon">
                                    <input type="text" style="font-size: 14px;" name="coupon" id="coupon" placeholder="Nhập mã giảm giá">
                                    <button class="btn btn-md" type="submit" form="apply-coupon">Sử dụng</button>
                                </form>
                                <div class="coupon-result"></div>
                            </div>
                        </div>
                    </div>
                    <div class="checkout-cart-btn">
                        <div class="row">
                            <div class="col-12">
                                <div class="go-to-checkout">
                                    <a href="<?php if ($count > 0) {
                                                    echo "checkout";
                                                } else {
                                                    echo "/";
                                                } ?>" class="btn checkout-btn">TÍNH TIỀN SHOP ƠI!</a>
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
    <script>
        // $('#qty-val').on('input', function() {
        //     var maxValue = $(this).parent().children('#qty-val').attr("max");
        //     var value = $(this).val();

        //     if ((value !== '') && (value.indexOf('.') === -1)) {

        //         $(this).val(Math.max(Math.min(value, maxValue), 1));
        //     }
        // });


        $(".apply-coupon").submit(function(e) {
            e.preventDefault();
            var couponValue = $('#coupon').val();
            $.ajax({
                method: "POST",
                url: "processCouponApply",
                data: "coupon="+ couponValue,
                // dataType:"json",
            })
            .done(function(data) {
                $('.coupon-result').html(data);
            });
        });


        $(document).ready(function() {
            var elements = $("input#qty-val");
            $.each($("input#qty-val"), function() {
                var findNumb = $(this).val();

                var totalPrice = $(this).closest(".cart-item").find(".text-total-price");
                var totalPriceText = totalPrice.text();
                var totalPriceNumb = Number(totalPriceText.replace(/[^0-9.-]+/g, ""));

                var pricePerItem = $(this).closest(".cart-item").find(".hidden-input").val();
                var pricePerItemNumb = Number(pricePerItem.replace(/[^0-9.-]+/g, ""));

                totalPriceNumb = pricePerItemNumb * findNumb;

                totalPrice.text(new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                }).format(totalPriceNumb));
            });
        });


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


        $(".btn-items-decrease").click(function() {
            var findNumb = $(this).parent().children(".qty-val").val();
            var maxQuantity = $(this).parent().children('#qty-val').attr("max");

            if (findNumb > 1) {
                $(this).css("visibility", "visible");
                findNumb--;
                $(this).parent().children(".qty-val").val(findNumb);

                if ($(this).parent().children(".qty-val").val() < maxQuantity) {
                    $(this).closest(".cart-item").find(".btn-items-increase").css("visibility", "visible");
                }
            }
            if (findNumb == 1) {
                $(this).css("visibility", "hidden");
            }
            var txtProduct = $(this).parent().children('.hidden-product-text').val();
            var value = $(this).parent().children("#qty-val").val();
            updateQuantity(txtProduct, value);
        });

        $(".btn-items-increase").click(function() {
            var maxQuantity = $(this).parent().children('#qty-val').attr("max");
            var findNumb = $(this).parent().children("#qty-val").val();
            findNumb++;
            $(this).parent().children(".qty-val").val(findNumb);
            if ($(this).parent().children(".qty-val").val() >= maxQuantity) {
                $(this).parent().children(".qty-val").val(maxQuantity);
                $(this).css("visibility", "hidden");
            }

            if (findNumb == 1) {
                $(this).closest(".cart-item").find(".btn-items-decrease").css("visibility", "hidden");
            }

            if (findNumb > 1) {
                $(this).closest(".cart-item").find(".btn-items-decrease").css("visibility", "visible");
            }

            var txtProduct = $(this).parent().children('.hidden-product-text').val();
            var value = $(this).parent().children("#qty-val").val();
            updateQuantity(txtProduct, value);

        });

        $(".qty-val").change(function() {
            var maxQuantity = $(this).parent().children('#qty-val').attr("max");
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

            var txtProduct = $(this).parent().children('.hidden-product-text').val();

            value = $(this).parent().children('#qty-val').val();
            updateQuantity(txtProduct, value);
        });


        function updateQuantity(txtProduct, qtyProduct) {

            // var posting = $.post("processChangeQuantity", {id: txtProduct,qty: qtyProduct});

            // // Put the results in a div
            // posting.done(function(data) {
            //     $(".cart-body").empty().append(data);
            // });

            // jqxhr.always("processChangeQuantity", {id: txtProduct,qty: qtyProduct}, function(data) {
            //     $('.cart-body').html(data);
            // });

            $.ajax({
                method: "POST",
                url: "processChangeQuantity",
                data: "id=" + txtProduct + "&qty=" + qtyProduct,
                success: function(data) {
                    var t = $('a[href="product?item=' + txtProduct + '"]');
                    t.closest(".cart-item").find(".text-total-price").html(data);
                },
                complete: function() {
                    $.ajax({
                        method: "POST",
                        url: "processChangeQuantityUpdateTotal",
                        data: "id=" + txtProduct + "&qty=" + qtyProduct,
                        success: function(data) {
                            $('.total-cart-body').html(data);
                        },
                    })
                }
            });
        }

        // $(this).closest(".cart-item")
        function remove_from_cart(textProduct) {
            var txtProduct = textProduct;
            $.ajax({
                method: "POST", // phương thức dữ liệu được truyền đi 
                url: "processRemoveItemFromCart", // gọi đến file server show_data.php để xử lý
                data: "id=" + txtProduct,
                success: function(data) {
                    var t = $('a[href="product?item=' + txtProduct + '"]');
                    t.closest(".cart-item").hide();
                },
                complete: function() {
                    $.ajax({
                        method: "POST",
                        url: "processChangeQuantityUpdateTotal",
                        data: "id=" + txtProduct,
                        success: function(data) {
                            $('.total-cart-body').html(data);
                        },
                    })
                } //lấy toàn thông tin các fields trong form bằng hàm serialize của jquery
            })
        }
    </script>
</body>

</html>