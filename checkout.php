<?php
session_start();

$count = 0;
$priceTotalCart = 0;
$setCookieSelect = false;

if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $id => $value) {
        $count += $_SESSION['cart'][$id]['quantity'];
    }
}

if (!isset($_SESSION['cart']) && $count == 0) {
    header('Location: /');
}

$priceTotalWithNoReset = 0;
$totalQuantityProduct = 0;

if (isset($_COOKIE["city"]) && isset($_COOKIE["district"]) && isset($_COOKIE["ward"])) {
    $cityBinding = $_COOKIE["city"];
    $districtBinding = $_COOKIE["district"];
    $wardBinding = $_COOKIE["ward"];
    $setCookieSelect = true;
}
?>
<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <title>Thanh toán - Thế Giới Khăn Ướt | EcoWipes</title>
    <?php require_once 'library.php'; ?>
    <link href="assets/css/plugins/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <style>
        .form-select {
            height: 40px !important;
            font-weight: 500;
            padding: .375rem 2.25rem .375rem 20px;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
        }

        .form-group input {
            height: 40px !important;
        }

        .form-group input {
            font-size: 15px !important;
            font-weight: 500;
            border: 1px solid #e0e0e0;
            font-size: 15px;
        }

        .form-select:focus {
            border-color: #BCE3C9;
            outline: 0;
            box-shadow: none;
        }
        .overlay{
    display: none;
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: 999;
    background: rgba(255,255,255,0.8) url("assets/imgs/loader.gif") center no-repeat;
        }
        /* Turn off scrollbar when body element has the loading class */
        body.loading{
            overflow: hidden;   
        }
        /* Make spinner image visible when body element has the loading class */
        body.loading .overlay{
            display: block;
        }
    </style>
</head>

<body>
    <?php require_once 'header.php' ?>
    <main class="main cart-screen">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Trang chủ</a>
                    <a href="cart"><span></span> Giỏ hàng</a>
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
                        <form method="post" enctype="multipart/form-data" id="orderAccept" class="form-user-info-shipping">
                            <div class="row">
                                <div class="form-group col-lg-4">
                                    <label for="inputName" class="form-label">Họ tên *</label>
                                    <input type="text" id="inputName" required name="name" value="<?php if ($checkAccountSession == true) {
                                                                                                        echo $rowUser["fullname"];
                                                                                                    } ?>">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="inputPhone" class="form-label">Số điện thoại *</label>
                                    <input type="text" class="phone" pattern="\d*" id="inputPhone" value="<?php if ($checkAccountSession == true) {
                                                                                                                echo $rowUser["phone"];
                                                                                                            } ?>" required name="phone">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="inputEmail" class="form-label">Email</label>
                                    <input type="email" id="inputEmail" name="email" value="<?php if ($checkAccountSession == true) {
                                                                                                echo $rowUser["email"];
                                                                                            } ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label for="inputAddress" class="form-label">Địa chỉ cụ thể *</label>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <select class="form-select form-select-sm js-example-basic-single" id="city" name="city" aria-label=".form-select-sm" required>
                                                <option value="" selected>Chọn Tỉnh/Thành</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <select class="form-select form-select-sm js-example-basic-single" id="district" name="district" aria-label=".form-select-sm" required>
                                                <option value="" selected>Chọn Quận/Huyện</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <select class="form-select form-select-sm js-example-basic-single" id="ward" name="ward" aria-label=".form-select-sm" required>
                                                <option value="" selected>Chọn Phường/Xã</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" id="inputAddress" name="address" placeholder="Nhập địa chỉ cụ thể" required value="<?php if ($checkAccountSession == true) {
                                                                                                                                                echo $rowUser["address"];
                                                                                                                                            } ?>">
                                </div>
                                <input type="hidden" class="message-form" name="message">
                                <input type="hidden" class="shipping-fee" name="shipping-fee">
                                <input type="hidden" class="payment-method-form" name="payment-method" value="COD">
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
                            <?php
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
                                    $priceTotalCart += $priceTotal;

                            ?>
                                    <div class="cart-item">
                                        <div class=" d-flex align-items-center text-start row">
                                            <div class="col-md-5 col-12">
                                                <div class="d-flex align-items-center"><a href="product?item=<?php echo $row1["product_text"] ?>"><img class="cart-item-img" src="<?php echo $row1["img_thumb"] ?>" alt="..." /></a>
                                                    <div class="cart-title text-start"><a class="text-uppercase text-dark text-product-cart" href="product?item=<?php echo $row1["product_text"] ?>"><?php echo $row1["product_name"] ?></a>
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
                                                                <div class="first-price"><?php echo number_format($row1["price"], 0, ",", "."); ?> ₫</div>
                                                                <!-- <div class="original-price">40.000 đ</div> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="align-items-center row">
                                                            <div class="d-md-none text-muted col-md-12 col-6">Số lượng</div>
                                                            <div class="col-md-12 col-sm-3 col-5 d-md-flex justify-content-center">
                                                                <div class="detail-qty mb-0">
                                                                    <?php echo $_SESSION['cart'][$row1['product_text']]['quantity'] ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="row">
                                                            <div class="d-md-none text-muted col-6">Tổng</div>
                                                            <div class="text-start col-md-12 col-6 text-total-price d-md-flex justify-content-end">
                                                                <?php echo number_format($priceTotal, 0, ",", "."); ?> ₫
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                    $priceTotal = 0;
                                }
                            } ?>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="confirm-shipping-container">
                        <div class="row g-0">
                            <div class="col-md-6">
                                <div class="feature-checkout-container d-inline-flex align-items-center">
                                    <label for="inputMessage" class="lb-message">Lời nhắn:</label>
                                    <input type="text" id="inputMessage" name="message" placeholder="Lưu ý cho cửa hàng" onchange="messageRedirect(this.value)">
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
                            <div class="col d-md-flex justify-content-end align-items-center">
                                <div class="title-payment-method"> Phương thức thanh toán</div>
                                <div class="payment-method-radio-container">
                                    <input type="radio" class="btn-check" name="payment-method" id="cod" value="COD" checked>
                                    <label class="btn-shipping-method mb-0" for="cod">
                                        Thanh toán khi nhận hàng
                                        <div class="checked-payment-method">
                                            <svg enable-background="new 0 0 12 12" viewBox="0 0 12 12" x="0" y="0" class="tick-svg-icon icon-tick-bold">
                                                <g>
                                                    <path d="m5.2 10.9c-.2 0-.5-.1-.7-.2l-4.2-3.7c-.4-.4-.5-1-.1-1.4s1-.5 1.4-.1l3.4 3 5.1-7c .3-.4 1-.5 1.4-.2s.5 1 .2 1.4l-5.7 7.9c-.2.2-.4.4-.7.4 0-.1 0-.1-.1-.1z"></path>
                                                </g>
                                            </svg>
                                        </div>
                                    </label>

                                    <input type="radio" class="btn-check" name="payment-method" id="banking" value="Banking">
                                    <label class="btn-shipping-method mb-0" for="banking">
                                        Chuyển khoản qua ngân hàng
                                        <div class="checked-payment-method">
                                            <svg enable-background="new 0 0 12 12" viewBox="0 0 12 12" x="0" y="0" class="tick-svg-icon icon-tick-bold">
                                                <g>
                                                    <path d="m5.2 10.9c-.2 0-.5-.1-.7-.2l-4.2-3.7c-.4-.4-.5-1-.1-1.4s1-.5 1.4-.1l3.4 3 5.1-7c .3-.4 1-.5 1.4-.2s.5 1 .2 1.4l-5.7 7.9c-.2.2-.4.4-.7.4 0-.1 0-.1-.1-.1z"></path>
                                                </g>
                                            </svg>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-lg-5 align-self-end">
                                <div class="info-banking-container">
                                    <div class="info-banking-inner">
                                        <div>Ngân hàng: <span>SACOMBANK (Ngân hàng Sài Gòn Thương Tín)</span></div>
                                        <div>STK: <span class="banking-no">060190213679</span></div>
                                        <div>Chủ TK: <span>Công ty CP ECO WIPES VIETNAM</span></div>
                                        <!-- <div class="note-banking-method">(*) Đơn hàng sẽ được chuyển đi ngay sau khi cửa hàng xác nhận chuyển khoản thành công</div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row row-cols-1 price-container">
                            <div class="col d-flex justify-content-md-end align-items-md-center">
                                <div class="title-checkout-container">
                                    Tổng tiền hàng:
                                </div>
                                <div class="total-price-checkout-container text-total-price price-binding-width">
                                    <?php echo number_format($priceTotalCart, 0, ",", "."); ?> ₫
                                </div>
                            </div>
                            <div class="col d-flex justify-content-md-end align-items-md-center">
                                <div class="title-checkout-container">
                                    Phí vận chuyển:
                                </div>
                                <div class="total-price-checkout-container text-total-price shipping-price price-binding-width">
                                    <!-- <?php echo number_format($priceTotalCart, 0, ",", "."); ?> ₫ -->
                                    Chưa xác định
                                </div>
                            </div>
                            <div class="col d-flex justify-content-md-end align-items-md-center">
                                <div class="title-checkout-container discount-shipping-fee">
                                    Giảm giá phí vận chuyển:
                                </div>
                                <div class="total-price-checkout-container text-total-price price-binding-width discount-shipping-fee">
                                    -40.000 ₫
                                </div>
                            </div>
                            <div class="col d-flex justify-content-md-end align-items-md-center pb-20 mt-10">
                                <div class="title-checkout-container total-price-text">
                                    Thành tiền:
                                </div>
                                <div class="total-price-checkout-container total-price">
                                    <?php echo number_format($priceTotalCart, 0, ",", "."); ?> ₫
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col d-flex justify-content-end align-items-center">
                    <div class="btn-order-container">
                        <button class="btn btn-order" type="submit" form="orderAccept">Đặt hàng</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php require_once 'footer.php' ?>
    <?php require_once 'script.php' ?>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js" integrity="sha512-6S5LYNn3ZJCIm0f9L6BCerqFlQ4f5MwNKq+EthDXabtaJvg3TuFLhpno9pcm+5Ynm6jdA9xfpQoMz2fcjVMk9g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        // $("#orderAccept").validate();
        // $('#inputPhone').rules("add", { pattern: "/^(0?)(3[2-9]|5[6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])[0-9]{7}$/" })

        // $.validator.addMethod('phone', function (value) {
        //     return /^(0?)(3[2-9]|5[6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])[0-9]{7}$/.test(value);
        // }, 'Please enter a valid US or Canadian postal code.');


        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });

        function messageRedirect(val) {
            $(".message-form").val(val);
        }

        $('input:radio[name="payment-method"]').change(function() {
            if ($(this).val() == 'Banking') {
                $('.info-banking-container').css("display", "block");
                $(".payment-method-form").val("Banking");
            } else {
                $('.info-banking-container').css("display", "none");
                $(".payment-method-form").val("COD");
            }
        });

        $("#orderAccept").submit(function(e) {
            e.preventDefault();
            $.ajax({
                method: "POST",
                url: "processOrder",
                data: $("#orderAccept").serialize(),
                success: function() {
                    Swal.fire({
                        html: "<strong>Đặt hàng thành công!</strong><br> <div class='mt-10' style='font-size:16px;'>Bạn sẽ tự động trở về trang chủ sau 3 giây<div>",
                        icon: "success",
                        timerProgressBar: true,
                        timer: 3000,
                        didOpen: () => {
                            Swal.showLoading()
                            const b = Swal.getHtmlContainer().querySelector('b')
                            timerInterval = setInterval(() => {
                                // b.textContent = Swal.getTimerLeft()
                            }, 100)
                        },
                        willClose: () => {
                            clearInterval(timerInterval);
                            location.href = "/";
                        }
                    });
                },
                error: function() {
                    Swal.fire({
                        html: "<strong>Đặt hàng không thành công!</strong><br>",
                        icon: "error",
                    });
                }
            })
        });
    </script>

    <script>
        var citis = document.getElementById("city");
        var districts = document.getElementById("district");
        var wards = document.getElementById("ward");
        var total = Number(($('.total-price').text()).replace(/[^0-9,-]+/g, ""));

        var Parameter = {
            url: "vietnam.json", //Đường dẫn đến file chứa dữ liệu hoặc api do backend cung cấp
            method: "POST",
            responseType: "application/json",
        };

        var promise = axios(Parameter);
        //Xử lý khi request thành công
        promise.then(function(result) {
                renderCity(result.data);
            })
            .then(function() {
                <?php
                if ($setCookieSelect == true) {
                    echo '
                        $("#city").val("' . $cityBinding . '").change();
                        $("#district").val("' . $districtBinding . '").change();
                        $("#ward").val("' . $wardBinding . '")  .change();
                        ';
                }
                ?>
            });

        // $(document).ready(function() {
        //     $('#city').val("Thành phố Hồ Chí Minh").change();
        // });
        $(document).on({
            ajaxStart: function(){
                $("body").addClass("loading"); 
            },
            ajaxStop: function(){ 
                $("body").removeClass("loading"); 
            }    
        });

        function renderCity(data) {
            for (const x of data) {
                citis.options[citis.options.length] = new Option(x.Name, x.Name);
            }

            citis.onchange = function() {
                district.length = 1;
                ward.length = 1;
                if (this.value != "") {
                    const result = data.filter(n => n.Name === this.value);

                    for (const k of result[0].Districts) {
                        district.options[district.options.length] = new Option(k.Name, k.Name);
                    }
                    $(this).parent().find('.select2-container--default .select2-selection--single').css('border-bottom', '3px solid #72be44');
                }
                var cityRs = this.value;

                $.ajax({
                    url: "processUpdateShipping",
                    type: "POST",
                    dataType: "json",
                    data: "city=" + cityRs + "&totalPrice=" + total,
                    success: function(dataResult) {
                        $('.price-container').html(dataResult.html);
                        $('.shipping-fee').val(dataResult.shippingFee);
                    },
                });
            };

            district.onchange = function() {
                ward.length = 1;
                const dataCity = data.filter((n) => n.Name === citis.value);
                if (this.value != "") {
                    const dataWards = dataCity[0].Districts.filter(n => n.Name === this.value)[0].Wards;

                    for (const w of dataWards) {
                        wards.options[wards.options.length] = new Option(w.Name, w.Name);
                    }
                    $(this).parent().find('.select2-container--default .select2-selection--single').css('border-bottom', '3px solid #72be44');
                }
            };

            ward.onchange = function() {
                if (this.value != "") {
                    $(this).parent().find('.select2-container--default .select2-selection--single').css('border-bottom', '3px solid #72be44');
                }
            };
        }
    </script>
</body>

</html>