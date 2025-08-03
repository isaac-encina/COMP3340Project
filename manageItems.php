<?php 
session_start();
$pageTitle="Manage Items";
include 'header.php'; 
require "db.php";
?> 

<div class="content-wrapper">
    <?php include 'sidebar.php'; ?>
    <main class="about-main">
        <?php if (!empty($_SESSION['success'])): ?>
        <p style="color: green;"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></p>
        <?php endif; ?>
        <a class="button" href="manageItemsHelp.php" style="float: right; padding: 5px 20px;">Help</a>

        <h1>Manage Items</h1>
    
            <?php if ($_SESSION['role'] === 'User'): ?>
                    <h2>Dont have the proper user role.</h2>
                    
            <?php elseif ($_SESSION['role'] === 'Admin'): ?>
                <?php
                    $stmt = $conn->prepare("SELECT * FROM ITEMS"); //get info from all items
                    $stmt->execute(); 
                    $items = $stmt->fetchAll(); ?>

                    <div style="margin-bottom: 20px;">
                    <a href="addItem.php" class="button">Add New Item</a> <!--sends user to add item form-->
                    </div> 
                    <?php
                    if($items): //if there are items in the system then the item table is created.
                        echo "<table class='order-table'>
                        <thead>
                        <tr>
                            <th colspan='9'>
                                items
                            </th>
                        </tr>
                        <tr>
                            <th>Item ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>imgURL</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Size</th>
                            <th>Stock</th>
                            <th>Remove</th>

                        </tr>
                        </thead>";

                        foreach ($items as $item):
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($item['itemId']) . "</td>";
                            echo "<td><a href='item.php?itemId=" . urlencode($item['itemId']) . "'>" . htmlspecialchars($item['itemName']) . "</a></td>";
                            echo "<td>" . htmlspecialchars($item['itemDescription']) . "</td>";
                            echo "<td>" . htmlspecialchars($item['imgURL']) . "</td>";
                            echo "<td>" . number_format($item['itemPrice'], 2) . "</td>";
                            echo "<td>" . htmlspecialchars($item['category']) . "</td>";
                            echo "<td></td><td></td>";
                            echo "<td><a href='itemDelete.php?itemId=" . urlencode($item['itemId']) . "' onclick=\"return confirm('Are you sure you want to delete this item and its variants?');\">Delete</a></td>";
                            
                            echo "</tr>";
                            $varStmt = $conn->prepare("SELECT * FROM ITEMVARS WHERE itemId = ?");
                            $varStmt->execute([$item['itemId']]);
                            $variants = $varStmt->fetchAll();
                            foreach ($variants as $variant):
                                echo "<tr>";
                                echo "<td></td><td></td><td></td><td></td><td></td><td></td>";
                                echo "<td>" . htmlspecialchars($variant['size']) . "</td>";
                                echo "<td>" . htmlspecialchars($variant['stock']) . "</td>";
                                echo "<td></td>";                              
                                echo "</tr>";
                            endforeach;
                        endforeach;
                        echo "</table>";
                    else:
                            echo "<p>No Items.</p>";
                    endif;
                ?>

                
            <?php endif; ?>
            

    </main>
</div>

<?php include 'footer.php'; ?> 