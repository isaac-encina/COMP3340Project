<?php
if(session_status() === PHP_SESSION_NONE){ //checking for session to keep track of cart
    session_start();
}
$pageTitle = "Product Details";
require 'db.php';
include 'header.php';


$itemId = intval($_GET['itemId']);//getting the itemId from url

$stmt = $conn->prepare("SELECT * FROM ITEMS WHERE itemId = ?");
$stmt->execute([$itemId]); 
$item = $stmt->fetch();//get item details 

if (!$item) {
    echo "<p>Item not found.</p>";
    include 'footer.php';
    exit;
}

$varStmt = $conn->prepare("SELECT * FROM ITEMVARS WHERE itemId = ?");
$varStmt->execute([$itemId]);
$variants = $varStmt->fetchAll(); //get info from the different sizes of the item
?>

<div class="content-wrapper">
    <?php include 'sidebar.php'; ?>
    <main class="about-main">
        <div class="product-detail">
            <img src="<?php echo htmlspecialchars($item['imgURL']); ?>" alt="<?php echo htmlspecialchars($item['itemName']); ?>">
            <h1><?php echo htmlspecialchars($item['itemName']); ?></h1>
            <p><?php echo htmlspecialchars($item['itemDescription']); ?></p>
            <p class="price">$<?php echo number_format($item['itemPrice'], 2); ?></p>
            
            <?php if (count($variants) > 0): ?>
                
                    <?php if ($_SESSION['role'] === 'User'): ?>
                       <form action="add_cart.php" method="post">
                        <input type="hidden" name="itemId" value="<?php echo $itemId; ?>">

                        <label for="varId">Choose a size:</label>
                        <select name="varId" id="varId" required>
                            <?php foreach ($variants as $variant): ?>
                                <option value="<?php echo $variant['varId']; ?>"
                                    dstock="<?php echo $variant['stock']; ?>"
                                    <?php if ($variant['stock'] == 0) echo 'disabled style="color: gray;"';//grey out if no stock is left  ?>>
                                    <?php echo htmlspecialchars($variant['size']) . " (Stock: " . $variant['stock'] . ")"; ?> 
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <label for="quantity">Quantity:</label>
                        <input type="number" name="quantity" min="1" value="1" required>
                        <p></p>
                       <input type="submit" value="Add to Cart" class="button">     
                       </form>
                        <script src="js/item.js"></script>
                    <?php elseif ($_SESSION['role'] === 'Admin'): ?>
                        <table class='order-table'>
                                <thead>
                                <tr>
                                    <th>Size</th>
                                    <th>Quantity</th>
                                </tr>
                                </thead>
                                <?php foreach ($variants as $variant): ?>
                                    <tr>
                                    <?php echo "<td>" .  htmlspecialchars($variant['size']) . "</td>" ;
                                    echo "<td>" .  htmlspecialchars($variant['stock']) . "</td>" ;
                                    ?>
                                    </tr>
                                <?php endforeach; ?>
                        </table>

                    <?php endif; ?>
                    
                
            <?php else: ?>
                <p style="color: red;">This item is currently out of stock.</p>
            <?php endif; ?>
    
        </div>
    </main>
</div>

<?php include 'footer.php'; ?>
