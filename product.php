<?php
require_once 'functionPhp.php';
require_once 'DataProvider.php';

$oldprice = 0;
if (!isset($_GET["item"])) {
    redirect("shop.php");
    exit();
} else {
    $id = $_GET["item"];
    if (isset($_GET["item"])) {
        $sqlDebug = "select * from product where product_text = '$id'";
        $listDebug = DataProvider::execQuery($sqlDebug);
        $rowDebug = mysqli_fetch_assoc($listDebug);
        if ($rowDebug < 1) {
            redirect("shop.php");
            exit();
        } else {
            $sql = "update product set total_view = total_view + 1 where product_text = '$id'";
            DataProvider::execQuery($sql);

            $sql = "select * from product p, image_product i where product_text = '$id' and p.id = i.product_id";
            $row = DataProvider::execQuery($sql);

            $item = mysqli_fetch_assoc($row);

            $nameProduct = $item["product_name"];
            $idType = $item["type_id"];
            $idProduct = $item["id"];
            $sheetStyle  = $item["sheet_style"];
            $typeStyle = $item["type_style"];
            $price = $item["price"];
            $textProduct = $item["product_text"];
            $totalStore = $item["total_store"];
            $oldprice = $item["price_old"];

            $sqlType = "select * from type_product where id = '$idType'";
            $rowType = DataProvider::execQuery($sqlType);
            $typeProduct = mysqli_fetch_assoc($rowType);

            $sqlGroup = "SELECT * FROM group_product g, type_product t WHERE t.id = '$idType' AND t.group_id = g.id";
            $rowGroup = DataProvider::execQuery($sqlGroup);
            $groupProduct = mysqli_fetch_assoc($rowGroup);

            $sqlBrand = "SELECT * FROM group_product g, type_product t, brand_product b WHERE t.id = '$idType' AND b.id = g.brand_id and g.id = t.group_id";
            $rowBrand = DataProvider::execQuery($sqlBrand);
            $brandProduct = mysqli_fetch_assoc($rowBrand);
        }
    }
}
?>
<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <title>EcoWipes | E-Commerce</title>
    <?php require_once 'library.php'; ?>

</head>

<body class="single-product">
    <!-- Quick view -->
    <?php require_once 'header.php' ?>

    <main class="main" style="color:#253D4E">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Trang chủ</a>
                    <span></span> <a href="shop">Cửa hàng</a>
                    <span></span><a href="shop?pid=<?php echo $brandProduct["brand_text"] ?>"> <?php echo $brandProduct["brand_name"] ?> </a>
                    <span></span><a href="shop?gid=<?php echo $groupProduct["group_text"] ?>"> <?php echo $groupProduct["group_name"] ?> </a>
                    <span></span><a href="shop?cid=<?php echo $typeProduct["type_text"] ?>"> <?php echo $typeProduct["type_name"] ?> </a>
                    <span></span> <?php echo $nameProduct ?>
                </div>
            </div>
        </div>
        <div class="container mb-30">
            <div class="row">
                <div class="col-xl-10 col-lg-12 m-auto">
                    <div class="product-detail accordion-detail">
                        <div class="row mb-50 mt-30">
                            <div class="col-md-6 col-sm-12 col-xs-12 mb-md-0 mb-sm-5">
                                <div class="detail-gallery">
                                    <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                                    <!-- MAIN SLIDES -->
                                    <div class="product-image-slider">
                                        <?php if ($item["img_thumb"] != NULL) { ?>
                                            <figure class="border-radius-10">
                                                <img src="<?php echo $item["img_thumb"] ?>" alt="<?php echo $nameProduct ?>">
                                            </figure>
                                        <?php } ?>

                                        <?php if ($item["img_1"] != NULL) { ?>
                                            <figure class="border-radius-10">
                                                <img src="<?php echo $item["img_1"] ?>" alt="<?php echo $nameProduct ?>">
                                            </figure>
                                        <?php } ?>

                                        <?php if ($item["img_2"] != NULL) { ?>
                                            <figure class="border-radius-10">
                                                <img src="<?php echo $item["img_2"] ?>" alt="<?php echo $nameProduct ?>">
                                            </figure>
                                        <?php } ?>

                                        <?php if ($item["img_3"] != NULL) { ?>
                                            <figure class="border-radius-10">
                                                <img src="<?php echo $item["img_3"] ?>" alt="<?php echo $nameProduct ?>">
                                            </figure>
                                        <?php } ?>

                                        <?php if ($item["img_4"] != NULL) { ?>
                                            <figure class="border-radius-10">
                                                <img src="<?php echo $item["img_4"] ?>" alt="<?php echo $nameProduct ?>">
                                            </figure>
                                        <?php } ?>

                                        <?php if ($item["img_5"] != NULL) { ?>
                                            <figure class="border-radius-10">
                                                <img src="<?php echo $item["img_5"] ?>" alt="<?php echo $nameProduct ?>">
                                            </figure>
                                        <?php } ?>
                                    </div>
                                    <!-- THUMBNAILS -->
                                    <div class="slider-nav-thumbnails">
                                        <?php if ($item["img_thumb"] != NULL) { ?>
                                            <div><img src="<?php echo $item["img_thumb"] ?>" alt="<?php echo $nameProduct ?>"></div>
                                        <?php } ?>

                                        <?php if ($item["img_1"] != NULL) { ?>
                                            <div><img src="<?php echo $item["img_1"] ?>" alt="<?php echo $nameProduct ?>"></div>
                                        <?php } ?>

                                        <?php if ($item["img_2"] != NULL) { ?>
                                            <div><img src="<?php echo $item["img_2"] ?>" alt="<?php echo $nameProduct ?>"></div>
                                        <?php } ?>

                                        <?php if ($item["img_3"] != NULL) { ?>
                                            <div><img src="<?php echo $item["img_3"] ?>" alt="<?php echo $nameProduct ?>"></div>
                                        <?php } ?>

                                        <?php if ($item["img_4"] != NULL) { ?>
                                            <div><img src="<?php echo $item["img_4"] ?>" alt="<?php echo $nameProduct ?>"></div>
                                        <?php } ?>

                                        <?php if ($item["img_5"] != NULL) { ?>
                                            <div><img src="<?php echo $item["img_5"] ?>" alt="<?php echo $nameProduct ?>"></div>
                                        <?php } ?>


                                    </div>
                                </div>
                                <!-- End Gallery -->
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="detail-info pr-30 pl-30">
                                    <span class="stock-status out-stock"> Mới </span>
                                    <h2 class="title-detail"><?php echo $nameProduct; ?></h2>
                                    <div class="clearfix product-price-cover">
                                        <div class="product-price primary-color float-left">
                                            <span class="current-price text-brand"><?php echo number_format($price, 0, ",", "."); ?> ₫</span>
                                            <?php
                                            if ($oldprice != NULL) {
                                                echo '
                                                        <span>  
                                                            <span class="save-price font-md color3 ml-15">Giảm ' . round((($oldprice - $price) / $oldprice * 100), 0, PHP_ROUND_HALF_UP) . '&#37;</span>
                                                            <span class="old-price font-md ml-15">' . number_format($oldprice, 0, ",", ".") . ' ₫</span>
                                                        </span>
                                                    ';
                                            }
                                            ?>
                                            <!-- <span>
                                                <span class="save-price font-md color3 ml-15">Giảm 5%</span>
                                                <span class="old-price font-md ml-15">40.000 đ</span>
                                            </span> -->
                                        </div>
                                    </div>
                                    <div class="attr-detail attr-size mb-10">
                                        <strong class="mr-10 mb-10">Số lượng tờ: </strong>
                                        <ul class="list-filter size-filter font-small">
                                            <?php
                                            require_once 'DataProvider.php';
                                            $sql = "select * from product p, sheets s, type_product t where s.type_id = t.id and p.product_text = '$textProduct' and t.id = p.type_id;";
                                            $list = DataProvider::execQuery($sql);
                                            while ($row = mysqli_fetch_array($list, MYSQLI_ASSOC)) {
                                                $sqlSheet = "select * from type_product t join types tp on t.id = tp.type_id join sheets s on t.id = s.type_id, product p where t.id = '" . $row["type_id"] . "' and p.type_id = t.id and p.sheet_style = s.sheet and tp.type = '" . $row["type_style"] . "' and tp.type = p.type_style and s.sheet = '" . $row["sheet"] . "'";
                                                $listSheet = DataProvider::execQuery($sqlSheet);
                                                $rowSheet = mysqli_fetch_assoc($listSheet);
                                            ?>
                                                <li class="<?php if ($sheetStyle == $row["sheet"]) {
                                                                echo "active disabled";
                                                            } ?>">
                                                    <a href="product?item=<?php
                                                                            echo $rowSheet["product_text"];
                                                                            ?>"><?php echo $row["sheet"] ?>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                    <div class="attr-detail attr-size mb-10">
                                        <strong class="mr-10 mb-10">Kiểu: </strong>
                                        <ul class="list-filter size-filter font-small">
                                            <?php
                                            require_once 'DataProvider.php';
                                            $sql = "select * from product p, types tp, type_product t where tp.type_id = t.id and p.product_text = '$textProduct' and t.id = p.type_id;";
                                            $list = DataProvider::execQuery($sql);
                                            while ($row = mysqli_fetch_array($list, MYSQLI_ASSOC)) {
                                                $sqlStyle = "select * from type_product t join types tp on t.id = tp.type_id join sheets s on t.id = s.type_id, product p where t.id = '" . $row["type_id"] . "' and p.type_id = t.id and p.sheet_style = s.sheet and s.sheet = '" . $row["sheet_style"] . "' and tp.type = p.type_style and tp.type = '" . $row["type"] . "'";
                                                $listStyle = DataProvider::execQuery($sqlStyle);
                                                $rowStyle = mysqli_fetch_assoc($listStyle);
                                            ?>
                                                <li class="<?php if ($typeStyle == $row["type"]) {
                                                                echo "active disabled";
                                                            } ?>">
                                                    <a href="product?item=<?php
                                                                            echo $rowStyle["product_text"];
                                                                            ?>"><?php echo $row["type"] ?>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                            <!-- <li class="active"><a href="#">Không Mùi</a></li> -->
                                        </ul>
                                    </div>
                                    <form method="POST">
                                        <div class="detail-extralink mb-10 mt-20">
                                            <div class="detail-qty">
                                                <strong class="mr-20">Số lượng: </strong>
                                                <a class="qty-down border" style="right: -1px;position: relative;"><i class="fa-solid fa-minus"></i></a>
                                                <input class="qty-val border" id="qty-val" value="1" min="1" type="number" inputmode="numeric" max="<?php echo $totalStore; ?>" oninput="this.value = Math.abs(this.value)"></input>
                                                <a class="qty-up border" style="right: 1px;position: relative;"><i class="fa-solid fa-plus"></i></a>
                                            </div>

                                            <div class="product-extra-link2">
                                                <button type="button" onclick="add_to_cart()" class="button button-add-to-cart"><i class="fi-rs-shopping-cart"></i>Thêm vào giỏ hàng</button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="overview-product-container">
                                        <div class="overview-product-title">
                                            <h4>Thông tin sản phẩm</h4>
                                        </div>
                                        <div class="overview-product-list">
                                            <ul>
                                                <li>Quy cách: 80 tờ/gói - 24 gói/thùng.</li>
                                                <li>Kích thước khăn: Khăn khổ lớn 170x200mm.</li>
                                                <li>Định lượng vải: Vải bi 50gsm với các hạt nổi 3D.</li>
                                                <li>Mùi hương: KHÔNG MÙI.</li>
                                                <li>Hạn sử dụng: 3 năm từ ngày sản xuất.</li>
                                                <li>Ngày sản xuất & hạn sử dụng: In trên bao bì.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- Detail Info -->
                            </div>
                        </div>
                        <div class="product-info">
                            <div class="tab-style3">
                                <div class="title-describe-source">
                                    <h3>MÔ TẢ SẢN PHẨM <?php echo mb_strtoupper($nameProduct); ?></h3>
                                </div>
                                <div class="product-content-describe-source">
                                    <?php
                                    $sql = "select * from product p, product_desc d where p.id = d.product_id and p.product_name = '$nameProduct'";
                                    $list = DataProvider::execQuery($sql);
                                    $row = mysqli_fetch_assoc($list);
                                    echo $row["product_desc"];
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-60">
                        <div class="col-12">
                            <h2 class="section-title style-1 mb-30">Các sản phẩm tương tự</h2>
                        </div>
                        <div class="col-12">
                            <div class="row related-products">
                                <?php
                                    $sqlRelate = "select * from product p, brand_product bp, group_product gp, type_product tp, image_product ip where bp.id = gp.brand_id and gp.id = tp.group_id and p.type_id = tp.id and bp.id = '".$brandProduct["id"]."' and ip.product_id = p.id LIMIT 4";
                                    $listRelate = DataProvider::execQuery($sqlRelate);
                                    while($rowRelate = mysqli_fetch_assoc($listRelate)){
                                ?>
                                <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap hover-up">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img">
                                                <a href="product?item=<?php echo $rowRelate["product_text"] ?>" tabindex="0">
                                                    <img class="default-img" src="<?php echo $rowRelate["img_thumb"] ?>" alt>
                                                    <img class="hover-img" src="<?php echo $rowRelate["img_1"] ?>" alt>
                                                </a>
                                            </div>
                                            <!-- <div class="product-action-1">
                                                <a aria-label="Xem trước" class="action-btn small" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div> -->
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="hot">New</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <h2><a href="shop-product-right.html" tabindex="0"><?php echo $rowRelate["product_name"] ?></a></h2>
                                            <div class="product-price">
                                            <span class="current-price text-brand"><?php echo number_format($rowRelate["price"], 0, ",", "."); ?> ₫</span>
                                            <?php
                                            if ($oldprice != NULL) {
                                                echo '
                                                        <span>  
                                                            <span class="save-price font-md color3 ml-15">Giảm ' . round((($oldprice - $price) / $oldprice * 100), 0, PHP_ROUND_HALF_UP) . '&#37;</span>
                                                            <span class="old-price font-md ml-15">' . number_format($oldprice, 0, ",", ".") . ' ₫</span>
                                                        </span>
                                                    ';
                                            }
                                            ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
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
        $('#qty-val').on('input', function() {
            var maxValue = $(this).parent().children('#qty-val').attr("max");
            var value = $(this).val();

            if ((value !== '') && (value.indexOf('.') === -1)) {

                $(this).val(Math.max(Math.min(value, maxValue), 1));
            }
        });

        var txtProduct = "<?php echo $textProduct; ?>";


        function add_to_cart() {
            cuteToast({
                type: "success", // or 'info', 'error', 'warning'
                message: "Đã thêm vào giỏ hàng",
                timer: 3000
            });
            var qtyProduct = $('.qty-val').val();
            $.ajax({
                method: "POST", // phương thức dữ liệu được truyền đi 
                url: "processAddToCart", // gọi đến file server show_data.php để xử lý
                data: "id=" + txtProduct + "&qty=" + qtyProduct,
                success: function(data) {
                    $('.cart-container').html(data); //Callback Replace the html of your shoppingCart Containe with the response of addtocart.php
                },
                complete: function() {
                    $.ajax({
                        method: "POST",
                        url: "processUpdateCount",
                        success: function(data) {
                            $('.pro-count').text(data);
                        },
                    })
                } //lấy toàn thông tin các fields trong form bằng hàm serialize của jquery
            })

        }
    </script>
</body>

</html>