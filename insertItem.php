<?php
session_start();
require 'db.php';

if ($_SESSION['role'] !== 'Admin') { //handles insertions into database of new items
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $itemName = $_POST['itemName'];
    $itemDescription = $_POST['itemDescription'];
    $imgURL = $_POST['imgURL'];
    $itemPrice = floatval($_POST['itemPrice']);
    $category = $_POST['category'];
    $stockS = intval($_POST['stock_s']);
    $stockM = intval($_POST['stock_m']);
    $stockL = intval($_POST['stock_l']);

    $stmt = $conn->prepare("INSERT INTO ITEMS (itemName, itemDescription, imgURL, itemPrice, category) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$itemName, $itemDescription, $imgURL, $itemPrice, $category]);

    $itemId = $conn->lastInsertId();
    $insertVar = $conn->prepare("INSERT INTO ITEMVARS (itemId, size, stock) VALUES (?, ?, ?)");
    $insertVar->execute([$itemId, 'S', $stockS]);
    $insertVar->execute([$itemId, 'M', $stockM]);
    $insertVar->execute([$itemId, 'L', $stockL]);

    $_SESSION['success'] = "Item added successfully.";
    header("Location: manageItems.php"); //returns user to the manageItems page
    exit;
}
?>
