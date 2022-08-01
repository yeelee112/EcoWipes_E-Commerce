<?php 
    session_start();
    $count = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $id => $value) {
            $count += $_SESSION['cart'][$id]['quantity'];
        }
    } else {
        $count = 0;
    }
    echo $count;
?>