<?php //removes from cart and returns user to cart page.
session_start();

if (isset($_GET['varId'])) {
    $varId = intval($_GET['varId']);
    if (isset($_SESSION['cart'][$varId])) {
        unset($_SESSION['cart'][$varId]);
        $_SESSION['success'] = "Item removed from cart.";
    }
}

header("Location: cart.php");
exit;
?>