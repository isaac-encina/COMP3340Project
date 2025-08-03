
<?php $pageTitle = "Clothes Store"; 
include 'header.php'; 
require 'db.php';
?> 

<div class="content-wrapper">
    <?php include 'sidebar.php'; ?>
    <main class="about-main">
        <h1>Store Front</h1>
        <p class="about-text">Welcome to the shop!</p>
        <div class="product-grid">
            <?php
            $stmt = $conn->query("SELECT * FROM ITEMS"); //get the info on all items in the database
            $items = $stmt->fetchAll();

            foreach ($items as $item): ?> <!-- for every item, set up a display card with the item image, price  and its name -->
                <div class="product-card">
                    <a href="item.php?itemId=<?php echo $item['itemId']; ?>">
                        <img src="<?php echo htmlspecialchars($item['imgURL']); ?>" alt="<?php echo htmlspecialchars($item['itemName']); ?>">
                        <h2><?php echo htmlspecialchars($item['itemName']); ?></h2>
                    </a>
                    <p><?php echo htmlspecialchars($item['itemDescription']); ?></p>
                    <p class="price">$<?php echo number_format($item['itemPrice'], 2); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</div>

<?php include 'footer.php'; ?> 