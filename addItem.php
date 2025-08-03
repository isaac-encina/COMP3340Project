<?php
session_start();
require 'db.php';
$pageTitle = "Add New Item";
include 'header.php';

if ($_SESSION['role'] !== 'Admin') { //verify that user has admin role
    echo "<p>Access denied.</p>";
    include 'footer.php';
    exit;
}
?>

<div class="content-wrapper">
    <?php include 'sidebar.php'; ?>
    <main class="about-main">
        <a class="button" href="addItemHelp.php" style="float: right; padding: 5px 20px;">Help</a> <!-- help button -->

        <h1>Add New Item</h1>
        <form action="insertItem.php" method="post"> <!-- new item form -->
            <label>Item Name:</label><br>
            <input type="text" name="itemName" required><br><br>

            <label>Description:</label><br>
            <textarea name="itemDescription" required></textarea><br><br>

            <label>Image URL:</label><br>
            <input type="text" name="imgURL" required><br><br>

            <label>Price:</label><br>
            <input type="number" name="itemPrice" step="0.01" required><br><br>

            <label>Category:</label><br>
            <input type="text" name="category" required><br><br>

            <fieldset>
                <legend>Stock per Size</legend>
                <label for="stock_s">S:</label>
                <input type="number" name="stock_s" id="stock_s" min="0" value="0" required><br><br>

                <label for="stock_m">M:</label>
                <input type="number" name="stock_m" id="stock_m" min="0" value="0" required><br><br>

                <label for="stock_l">L:</label>
                <input type="number" name="stock_l" id="stock_l" min="0" value="0" required><br><br>
            </fieldset>

            <input type="submit" value="Add Item" class="button">
        </form>
    </main>
</div>

<?php include 'footer.php'; ?>
