<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require "db.php";

$varId = intval($_POST['varId']);
$quantity = intval($_POST['quantity']); 

$stmt = $conn->prepare("
    SELECT ITEMVARS.varId, ITEMVARS.itemId, ITEMVARS.size, ITEMVARS.stock, ITEMS.itemName, ITEMS.itemPrice
    FROM ITEMVARS 
    JOIN ITEMS ON ITEMVARS.itemId = ITEMS.itemId 
    WHERE ITEMVARS.varId = ?");
$stmt->execute([$varId]);
$variant = $stmt->fetch();

if ($variant['stock'] < $quantity) { //check in case stock changed since form was sent
    $_SESSION['error'] = "Not enough stock available.";
    header("Location: item.php?varId=$varId");
    exit;
}

if (!isset($_SESSION['cart'])) { //creating cart array if it doesnt exist
    $_SESSION['cart'] = [];
}

if (isset($_SESSION['cart'][$varId])) {//if the item is alrady in cart update it, otherwise add it. 
    $_SESSION['cart'][$varId]+= $quantity;
} else {
    $_SESSION['cart'][$varId] = ['itemId' => $variant['itemId'], 'varId' => $variant['varId'], 'itemName' => $variant['itemName'], 'size' => $variant['size'], 'price' => $variant['itemPrice'], 'quantity' => $quantity];
}

$_SESSION['success'] = "{$variant['itemName']} added to cart.";
header("Location: cart.php");
exit;

?>