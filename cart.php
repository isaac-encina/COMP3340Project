<?php 
session_start();
$pageTitle="Cart";
require 'db.php';

include 'header.php'; 

$successMessage = ''; //for feedback on placement of order
if (isset($_SESSION['success'])) {
    $successMessage = $_SESSION['success'];
    unset($_SESSION['success']);
}
?>


<div class="content-wrapper">
    <?php include 'sidebar.php'; ?>
    <main class="about-main">
        <a class="button" href="cartHelp.php" style="float: right; padding: 5px 20px;">Help</a>

        <h1>Cart</h1>
        <?php if (!empty($successMessage)): ?> <!-- for feedback on removal of items-->
        <p style="color: green;"><?php echo htmlspecialchars($successMessage); ?></p>
        <?php endif; ?>
        

        <?php if (!empty($_SESSION['cart'])): ?>
            <table border="1" cellpadding="10">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Item Price</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  
                    $totalPrice = 0;
                    foreach ($_SESSION['cart'] as $varId => $item) {
                        if (!is_array($item) || !isset($item['itemName'], $item['size'], $item['quantity'], $item['price'])) {
                            continue; // Skip invalid or empty items
                        }
                        $subtotal = $item['price'] * $item['quantity'];
                        $totalPrice += $subtotal;

                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($item['itemName']) . "</td>";
                        echo "<td>" . htmlspecialchars($item['size']) . "</td>";
                        echo "<td>" . $item['quantity'] . "</td>";
                        echo "<td>$" . number_format($item['price'], 2) . "</td>";
                        echo "<td>$" . number_format($subtotal, 2) . "</td>";
                        echo "<td><a class='remove-btn' href='remove_cart.php?varId=" . urlencode($varId) ."' onclick=\"return confirm('Remove this item?');\">Remove</a></td>";
                        echo "</tr>";
                    }
                    ?>
                <tr>
                        <td colspan="4" style="text-align:right;"><strong>Total:</strong></td>
                        <td><strong>$<?php echo number_format($totalPrice, 2); ?></strong></td>
                    </tr>
                </tbody>
            </table>
            <form method="post" action="order.php">
                <input type="submit" class="button" value="Place Order">
            </form>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>

    </main>
</div>

<?php include 'footer.php'; ?> 