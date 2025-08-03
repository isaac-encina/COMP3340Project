<?php 
$pageTitle="Shirts";
include 'header.php';
require "db.php"; 
?> 
<div class="content-wrapper">
    <?php include 'sidebar.php'; ?>
    <main class="about-main">
        <h1>Socks</h1>
        <p class="about-text"> Look at our socks.</p>
        <div class="product-grid">
            <?php
            $stmt = $conn->query("SELECT * FROM ITEMS where category = 'sock'"); //gets all items that are in the sock categories, for display.
            $items = $stmt->fetchAll();

            foreach ($items as $item): ?>
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