<?php
session_start();
require "db.php";

if (!isset($_SESSION['userId']) || empty($_SESSION['cart'])) {
    $_SESSION['error'] = "You must be logged in and have items in your cart.";
    header("Location: cart.php");
    exit;
}

$userId = $_SESSION['userId'];
$cart = $_SESSION['cart'];

$conn->beginTransaction();


// Get total cost of order
$total = 0;
foreach ($cart as $item) {
    $subtotal = $item['price'] * $item['quantity'];
    $total += $subtotal;

    // Check stock is available
    $stockStmt = $conn->prepare("SELECT stock FROM ITEMVARS WHERE varId = ?");
    $stockStmt->execute([$item['varId']]);
    $currentStock = $stockStmt->fetchColumn();

    if ($currentStock === false || $currentStock < $item['quantity']) {
        throw new Exception("Not enough stock for item: " . $item['itemName']);
    }
}

// Insert into ORDERS table
$orderStmt = $conn->prepare("INSERT INTO ORDERS (userId, total, orderDate) VALUES (?, ?, NOW())");
$orderStmt->execute([$userId, $total]);
$orderId = $conn->lastInsertId();

// Insert into ORDEREDITEMS table and update the stock in ITEMVARS
$itemStmt = $conn->prepare("INSERT INTO ORDEREDITEMS (orderId, varId, quantity, subtotal) VALUES (?, ?, ?, ?)");
$stockUpdate = $conn->prepare("UPDATE ITEMVARS SET stock = stock - ? WHERE varId = ?");

foreach ($cart as $item) {
    $subtotal = $item['price'] * $item['quantity'];
    $itemStmt->execute([$orderId, $item['varId'], $item['quantity'], $subtotal]);
    $stockUpdate->execute([$item['quantity'], $item['varId']]);
}

$conn->commit();
unset($_SESSION['cart']);
$_SESSION['success'] = "Order placed successfully!";


header("Location: cart.php");
exit;

?>