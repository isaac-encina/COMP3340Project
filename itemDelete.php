<?php
session_start();
require 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php");
    exit;
}

if (isset($_GET['itemId'])) {
    $itemId = intval($_GET['itemId']);
    
    $stmt1 = $conn->prepare("DELETE FROM ITEMVARS WHERE itemId = ?"); //Deleting variants first to not get sql errors
    $stmt1->execute([$itemId]);

    $stmt2 = $conn->prepare("DELETE FROM ITEMS WHERE itemId = ?"); //Then deleting items 
    $stmt2->execute([$itemId]);

    $_SESSION['success'] = "Item deleted from system.";
}

header("Location: manageItems.php"); 
exit;
?>
