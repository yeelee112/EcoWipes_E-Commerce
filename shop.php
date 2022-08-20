<?php
require_once 'functionPhp.php';
require_once 'DataProvider.php';

$mysqli = DataProvider::getConnection();
$result = '&';
$temp = 0;
$rs = 0;
$sqlListProduct = "";
$searchStatus = 0;

if (isset($_GET["pid"])) {
    $pid = mysqli_real_escape_string($mysqli, $_GET["pid"]);
    $temp++;
    $rs = 1;
}

if (isset($_GET["gid"])) {
    $gid = mysqli_real_escape_string($mysqli, $_GET["gid"]);
    $temp++;
    $rs = 2;
}

if (isset($_GET["cid"])) {
    $cid = mysqli_real_escape_string($mysqli, $_GET["cid"]);
    $temp++;
    $rs = 3;
}

if (isset($_GET["search"])) {
    $search = mysqli_real_escape_string($mysqli, $_GET["search"]);
    $searchStatus = 1;
    $temp++;
}

if (isset($_GET["sort"])) {
    $sort = mysqli_real_escape_string($mysqli, $_GET["sort"]);
}


if (isset($pid)) {
    $sqlListProduct = "SELECT p.id as SKU, p.product_text, p.product_name, p.price, p.total_sold, b.brand_name, b.brand_text, g.group_text, g.group_name, t.type_name, i.img_thumb, i.img_1 from brand_product b, group_product g, type_product t, product p, image_product i where b.id = g.brand_id and g.id = t.group_id and t.id = p.type_id and p.id = i.product_id and b.brand_text = '$pid'";
} else if (isset($gid)) {
    $sqlListProduct = "SELECT p.id as SKU, p.product_text, p.product_name, p.price, p.total_sold, b.brand_name, b.brand_text, g.group_text, g.group_name, t.type_name, i.img_thumb, i.img_1 from brand_product b, group_product g, type_product t, product p, image_product i where b.id = g.brand_id and g.id = t.group_id and t.id = p.type_id and p.id = i.product_id and g.group_text = '$gid'";
} else if (isset($cid)) {
    $sqlListProduct = "SELECT p.id as SKU, p.product_text, p.product_name, p.price, p.total_sold, b.brand_name, b.brand_text, g.group_text, g.group_name, t.type_name, i.img_thumb, i.img_1 from brand_product b, group_product g, type_product t, product p, image_product i where b.id = g.brand_id and g.id = t.group_id and t.id = p.type_id and p.id = i.product_id and t.type_text = '$cid'";
} else if ($searchStatus == 1) {
    $sqlListProduct = "SELECT p.id as SKU, p.product_text, p.product_name, p.price, p.total_sold, b.brand_name, b.brand_text, g.group_text, g.group_name, t.type_name, i.img_thumb, i.img_1 from brand_product b, group_product g, type_product t, product p, image_product i where b.id = g.brand_id and g.id = t.group_id and t.id = p.type_id and p.id = i.product_id and (b.brand_name like '%$search%' or g.group_name like '%$search%' or t.type_name like '%$search%' or p.sheet_style like '%$search%' or p.type_style like '%$search%')";
} else {
    $sqlListProduct = "SELECT p.id as SKU, p.product_text, p.product_name, p.price, p.total_sold, b.brand_name, b.brand_text, g.group_text, g.group_name, t.type_name, i.img_thumb, i.img_1 from brand_product b, group_product g, type_product t, product p, image_product i where b.id = g.brand_id and g.id = t.group_id and t.id = p.type_id and p.id = i.product_id";
}

if ($temp > 1) {
    redirect("shop");
    exit();
}

if ($temp == 0) {
    $result = '?';
}

if (isset($sort)) {
    if ($sort == "porpularity") {
        $sqlListProduct = $sqlListProduct . ' ORDER BY p.total_view DESC';
    } else if ($sort == "price-up") {
        $sqlListProduct = $sqlListProduct . ' ORDER BY p.price ASC';
    } else if ($sort == "price-down") {
        $sqlListProduct = $sqlListProduct . ' ORDER BY p.price DESC';
    } else if ($sort == "newest") {
        $sqlListProduct = $sqlListProduct . ' ORDER BY p.created_at DESC';
    }
}

function removeQueryStringParameter($url, $varname)
{
    $parsedUrl = parse_url($url);
    $query = array();

    if (isset($parsedUrl['query'])) {
        parse_str($parsedUrl['query'], $query);
        unset($query[$varname]);
    }

    $path = isset($parsedUrl['path']) ? $parsedUrl['path'] : '';
    $query = !empty($query) ? '?' . http_build_query($query) : '';

    return $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . $path . $query;
}

?>

<!DOCTYPE html>
<html class="no-js" lang="vi">

<head>
    <meta charset="utf-8">
    <title>EcoWipes | E-Commerce</title>
    <?php require_once 'library.php'; ?>
</head>

<body>
    <?php require_once 'header.php' ?>
    <!--End header-->
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Trang chủ</a>
                    <span></span> <a href="shop">Cửa hàng</a>
                    <?php
                    $listProduct = DataProvider::execQuery($sqlListProduct);
                    $rowTitle = mysqli_fetch_assoc($listProduct);
                    $countRow = mysqli_num_rows($listProduct);

                    if ($rs == 1 && $countRow > 1) { ?>
                        <span></span><?php echo $rowTitle["brand_name"] ?>
                    <?php } else if ($rs == 2 && $countRow > 1) { ?>
                        <span></span><a href="shop?pid=<?php echo $rowTitle["brand_text"] ?>"> <?php echo $rowTitle["brand_name"] ?> </a>
                        <span></span><?php echo $rowTitle["group_name"] ?>
                    <?php } else if ($rs == 3 && $countRow > 1) { ?>
                        <span></span><a href="shop?pid=<?php echo $rowTitle["brand_text"] ?>"> <?php echo $rowTitle["brand_name"] ?> </a>
                        <span></span><a href="shop?gid=<?php echo $rowTitle["group_text"] ?>"> <?php echo $rowTitle["group_name"] ?> </a>
                        <span></span><?php echo $rowTitle["type_name"] ?>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="container mb-30">
            <div class="row">
                <div class="col-lg-1-5 primary-sidebar sticky-sidebar">
                    <div class="modal-filter-catalogue mb-30" style="">
                        <div class="section-title style-2" style="margin-bottom: 0px !important">
                            <h3 style="margin-bottom: 0px !important">Danh mục</h3>
                        </div>

                        <button type="button" class="btn btn-modal-filter" data-bs-toggle="modal" data-bs-target="#modalFilter">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#fff" class="bi bi-sliders" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M11.5 2a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM9.05 3a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0V3h9.05zM4.5 7a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM2.05 8a2.5 2.5 0 0 1 4.9 0H16v1H6.95a2.5 2.5 0 0 1-4.9 0H0V8h2.05zm9.45 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm-2.45 1a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0v-1h9.05z" />
                            </svg>
                        </button>
                    </div>

                    <div class="categories-container">
                        <div class="categories-inner">
                            <div class="accordion">
                                <ul class="categories-parent-container">
                                    <?php
                                    require_once 'DataProvider.php';
                                    $sqlBrandAccordion = "select * from brand_product order by created_at DESC";
                                    $listBrandAccordion = DataProvider::execQuery($sqlBrandAccordion);
                                    while ($rowBrandAccordion = mysqli_fetch_array($listBrandAccordion, MYSQLI_ASSOC)) {
                                    ?>
                                        <li>
                                            <a href="shop?pid=<?php echo $rowBrandAccordion["brand_text"] ?>"><?php echo $rowBrandAccordion["brand_name"] ?></a>
                                            <ul class="categories-child-container">
                                                <?php
                                                require_once 'DataProvider.php';
                                                $sqlTypeAccordion = "select * from brand_product bp, group_product gp, type_product tp where bp.id = gp.brand_id and gp.id = tp.group_id and bp.id = '" . $rowBrandAccordion["id"] . "'";
                                                $listTypeAccordion = DataProvider::execQuery($sqlTypeAccordion);
                                                while ($rowTypeAccordion = mysqli_fetch_array($listTypeAccordion, MYSQLI_ASSOC)) {
                                                ?>
                                                    <li>
                                                        <a href="shop?cid=<?php echo $rowTypeAccordion["type_text"] ?>"><?php echo $rowTypeAccordion["type_name"] ?></a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Product sidebar Widget -->
                    <div class="sidebar-widget product-sidebar mt-50 mb-30 p-30 bg-grey border-radius-10">
                        <h5 class="section-title style-1 mb-30">Sản phẩm mới</h5>
                        <?php
                        require_once 'DataProvider.php';
                        $sql = "select p.product_name, p.price, i.img_thumb, p.product_text from brand_product b, group_product g, type_product t, product p, image_product i where b.id = g.brand_id and g.id = t.group_id and t.id = p.type_id and p.id = i.product_id LIMIT 3";
                        $list = DataProvider::execQuery($sql);
                        while ($row = mysqli_fetch_array($list, MYSQLI_ASSOC)) {
                        ?>
                            <div class="single-post clearfix">
                                <div class="image">
                                    <img src="<?php echo $row['img_thumb'] ?>" alt="<?php echo $row['product_name'] ?>">
                                </div>
                                <div class="content pt-10">
                                    <h6><a href="product?item=<?php echo $row["product_text"] ?>"><?php echo $row['product_name'] ?></a></h6>
                                    <p class="price mb-0 mt-5"><?php echo number_format($row["price"], 0, ",", "."); ?> ₫</p>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <!-- <div class="banner-img wow fadeIn mb-lg-0 animated d-lg-block d-none">
                        <img src="assets/imgs/banner/banner-11.png" alt>
                        <div class="banner-text">
                            <span>Oganic</span>
                            <h4>
                                Save 17% <br>
                                on <span class="text-brand">Oganic</span><br>
                                Juice
                            </h4>
                        </div>
                    </div> -->
                </div>
                <div class="col-lg-4-5">
                    <div class="shop-product-fillter">
                        <div class="totall-product">
                            <p>Chúng tôi tìm thấy <strong class="text-brand">
                                    <?php
                                    require_once 'DataProvider.php';
                                    $sqlCount = "select count(*) as CountProduct from (" . $sqlListProduct . ") as subquery";
                                    $listCount = DataProvider::execQuery($sqlCount);
                                    $row = mysqli_fetch_array($listCount, MYSQLI_ASSOC);
                                    echo $row["CountProduct"];
                                    ?>
                                </strong> sản phẩm cho bạn</p>
                        </div>
                        <div class="sort-by-product-area">
                            <div class="sort-by-cover">
                                <div class="sort-by-product-wrap">
                                    <div class="sort-by">
                                        <span><i class="fi-rs-apps-sort"></i>Sắp xếp:</span>
                                    </div>
                                    <div class="sort-by-dropdown-wrap">
                                        <span class="pr-5"> Phố biến nhất</span> <i class="fi-rs-angle-small-down"></i>
                                    </div>
                                </div>
                                <div class="sort-by-dropdown">
                                    <ul>
                                        <li><a class="<?php if ($sort == 'porpularity' || !isset($sort)) {
                                                            echo 'active';
                                                        } ?>" href="<?php echo removeQueryStringParameter($actual_link, 'sort') . $result . 'sort=porpularity'; ?>">Phổ biến nhất</a></li>
                                        <li><a class="<?php if ($sort == 'price-up') {
                                                            echo 'active';
                                                        } ?>" href="<?php echo removeQueryStringParameter($actual_link, 'sort') . $result . 'sort=price-up'; ?>">Giá: Thấp tới Cao</a></li>
                                        <li><a class="<?php if ($sort == 'price-down') {
                                                            echo 'active';
                                                        } ?>" href="<?php echo removeQueryStringParameter($actual_link, 'sort') . $result . 'sort=price-down'; ?>">Giá: Cao tới Thấp</a></li>
                                        <li><a class="<?php if ($sort == 'newest') {
                                                            echo 'active';
                                                        } ?>" href="<?php echo removeQueryStringParameter($actual_link, 'sort') . $result . 'sort=newest'; ?>">Mới Nhất</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row product-grid">
                        <?php
                        $listProduct = DataProvider::execQuery($sqlListProduct);
                        while ($row = mysqli_fetch_array($listProduct, MYSQLI_ASSOC)) {
                        ?>
                            <div class="col-md-3 col-6 col-sm-6 g-3">
                                <div class="product-cart-wrap">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img">
                                            <a href="product?item=<?php echo $row["product_text"] ?>">
                                                <img class="default-img" src="<?php echo $row["img_thumb"] ?>" alt>
                                                <img class="hover-img" src="<?php echo $row["img_1"] ?>" alt>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="product-category mt-5">
                                            <a href="shop?pid=<?php echo $row["brand_text"] ?>"><?php echo $row["brand_name"] ?></a>
                                        </div>
                                        <h2><a href="product?item=<?php echo $row["product_text"] ?>"><?php echo $row["product_name"] ?></a></h2>
                                        <div class="count-product-sold">
                                            Đã bán: <?php echo $row["total_sold"] ?>
                                        </div>
                                        <div class="product-card-bottom">

                                            <div class="product-price">
                                                <span><?php echo number_format($row["price"], 0, ",", "."); ?> ₫</span>
                                                <!-- <span class="old-price">40.000 đ</span> -->
                                            </div>
                                            <div class="add-cart">
                                                <button class="add" onclick="add_to_cart_per_click(this.value)" value="<?php echo $row["product_text"] ?>"><i class="fi-rs-shopping-cart mr-5"></i> <span>Thêm</span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <!--end product card-->
                    </div>
                    <!--product grid-->
                </div>

                <div class="modal fade" id="modalFilter" tabindex="-1" aria-labelledby="modalFilterLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Danh mục</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="categories-inner">
                                    <div class="accordion">
                                        <ul class="categories-parent-container">
                                            <?php
                                            require_once 'DataProvider.php';
                                            $sqlBrandAccordion = "select * from brand_product order by created_at DESC";
                                            $listBrandAccordion = DataProvider::execQuery($sqlBrandAccordion);
                                            while ($rowBrandAccordion = mysqli_fetch_array($listBrandAccordion, MYSQLI_ASSOC)) {
                                            ?>
                                                <li>
                                                    <a href="shop?pid=<?php echo $rowBrandAccordion["brand_text"] ?>"><?php echo $rowBrandAccordion["brand_name"] ?></a>
                                                    <ul class="categories-child-container">
                                                        <?php
                                                        require_once 'DataProvider.php';
                                                        $sqlTypeAccordion = "select * from brand_product bp, group_product gp, type_product tp where bp.id = gp.brand_id and gp.id = tp.group_id and bp.id = '" . $rowBrandAccordion["id"] . "'";
                                                        $listTypeAccordion = DataProvider::execQuery($sqlTypeAccordion);
                                                        while ($rowTypeAccordion = mysqli_fetch_array($listTypeAccordion, MYSQLI_ASSOC)) {
                                                        ?>
                                                            <li>
                                                                <a href="shop?cid=<?php echo $rowTypeAccordion["type_text"] ?>"><?php echo $rowTypeAccordion["type_name"] ?></a>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </main>
    <?php require_once 'footer.php' ?>

    <?php require_once 'script.php' ?>
    <!-- <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=geometry"></script>

    <script>
        var p1 = new google.maps.LatLng(10.8615861, 106.697854);
        var p2 = new google.maps.LatLng(10.8520538, 106.6626652);

        alert(calcDistance(p1, p2));

        //calculates distance between two points in km's
        function calcDistance(p1, p2) {
            return (google.maps.geometry.spherical.computeDistanceBetween(p1, p2) / 1000).toFixed(2);
        }
    </script> -->

    <script>
        function add_to_cart_per_click(txtProduct) {
            cuteToast({
                type: "success", // or 'info', 'error', 'warning'
                message: "Đã thêm vào giỏ hàng",
                timer: 3000
            });

            $.ajax({
                method: "POST", // phương thức dữ liệu được truyền đi 
                url: "processAddToCart", // gọi đến file server show_data.php để xử lý
                data: "id=" + txtProduct,
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
            }) //Some action to indicate is Failing ;
        }

        var txtSort = $('.sort-by-product-area .sort-by-cover a.active').text();
        $('.sort-by-dropdown-wrap span').text(txtSort);
    </script>
</body>

</html>