<?php
if (isset($_GET["page"])) {
    $page  = $_GET["page"];
} else {
    $page = 1;
}

$limit = 8;
$start_from = ($page - 1) * $limit;
?>

<?php
require_once 'DataProvider.php';
$sqlChild = "SELECT * from brand_product b, group_product g, type_product t, product p, image_product i where b.id = g.brand_id and g.id = t.group_id and t.id = p.type_id and p.id = i.product_id and p.is_combo = 1 order by p.created_at ASC";
$listChild = DataProvider::execQuery($sqlChild);
while ($rowChild = mysqli_fetch_array($listChild, MYSQLI_ASSOC)) {
?>
    <div class="col-md-3 col-6 col-sm-6">
        <div class="product-cart-wrap">
            <div class="product-img-action-wrap">
                <div class="product-img">
                    <a href="product?item=<?php echo $rowChild["product_text"] ?>">
                        <img class="default-img lazyload" src="<?php echo $rowChild["img_thumb"] ?>" alt>
                        <img class="hover-img lazyload" src="<?php echo $rowChild["img_1"] ?>" alt>
                    </a>
                </div>
                <div class="product-badges product-badges-position product-badges-mrg">
                    <span class="hot">Mới</span>
                </div>
            </div>
            <div class="product-content-wrap">
                <div class="product-category">
                    <a href="shop?gid=<?php echo $rowChild["group_text"] ?>"><?php echo $rowChild["group_name"] ?></a>
                </div>
                <h2><a href="product?item=<?php echo $rowChild["product_text"] ?>"><?php echo $rowChild["product_name"] ?></a></h2>
                <div>
                    <span class="font-small text-muted">Thương hiệu: <a href="shop?pid=<?php echo $rowChild["brand_text"] ?>"><?php echo $rowChild["brand_name"] ?></a></span>
                </div>
                <div class="count-product-sold">
                    Đã bán: <?php echo $rowChild["total_sold"] ?>
                </div>
                <div class="product-card-bottom">
                    <div class="product-price">
                        <span><?php echo number_format($rowChild["price"], 0, ",", "."); ?> ₫</span>
                        <?php if ($rowChild["price_old"] != NULL)
                            echo '<span class="old-price">' . number_format($rowChild["price_old"], 0, ",", ".") . ' ₫</span>';
                        ?>
                    </div>
                    <div class="add-cart">
                        <button class="add" id="toast" onclick="add_to_cart_per_click(this.value)" value="<?php echo $rowChild["product_text"] ?>"><i class="fi-rs-shopping-cart mr-5"></i><span>Thêm</span> </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>