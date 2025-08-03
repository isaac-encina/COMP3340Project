<?php 
session_start();
$pageTitle="Your Account";
include 'header.php'; 
require "db.php";
?> 

<div class="content-wrapper">
    <?php include 'sidebar.php'; ?>
    <main class="about-main">
        <a class="button" href="accountHelp.php" style="float: right; padding: 5px 20px;">Help</a> <!--Help page button -->
        <h1>Your Account</h1>
        
        <?php if (!isset($_SESSION["userId"])): ?> <!--if session isnt set then account page shows users the login form -->
            <form method="post" action="login.php"> <!-- login form -->
                <fieldset>
                    <legend>Login</legend>
                    <p>
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" maxlength="30" placeholder="Username" required><br>
                    </p>
                    <p>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" minlength="5" maxlength="16" placeholder="password" required><br>
                    </p>
                </fieldset>
                <fieldset>
                    <input type="submit" value="Login">
                    <input type="reset" value="Clear"> 
                </fieldset>
            </form>
            <p></p>
            <a style="color:blue;" href="signup.php">Create an account.</a> <!-- give option to create account -->
        <?php else: ?> <!-- if user is logged in then proceed here -->
            <p> Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</p>
            <p></p>
            <?php if ($_SESSION['role'] === 'User'): ?> <!-- check role of user, if regular user then display order info -->
                    <h2>Your Orders</h2>
                    <?php
                    $userId = $_SESSION['userId'];

                    $orderStmt = $conn->prepare("SELECT * FROM ORDERS WHERE userId = ? ORDER BY orderDate DESC");
                    $orderStmt->execute([$userId]);
                    $orders = $orderStmt->fetchAll();

                    if ($orders):
                        foreach ($orders as $order):
                            

                            $itemsStmt = $conn->prepare("
                                SELECT OI.quantity, OI.subtotal, IV.size, I.itemName 
                                FROM ORDEREDITEMS OI
                                JOIN ITEMVARS IV ON OI.varId = IV.varId
                                JOIN ITEMS I ON IV.itemId = I.itemId
                                WHERE OI.orderId = ?");
                            $itemsStmt->execute([$order['orderId']]);
                            $items = $itemsStmt->fetchAll();

                            if ($items):
                                echo "<table class='order-table'>
                                        <thead>
                                        <tr>
                                            <th colspan='4'>
                                                Order #{$order['orderId']} on {$order['orderDate']}
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Item</th>
                                            <th>Size</th>
                                            <th>Quantity</th>
                                            <th>Subtotal</th>
                                        </tr>
                                        </thead>";
                                foreach ($items as $item) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($item['itemName']) . "</td>";
                                    echo "<td>" . htmlspecialchars($item['size']) . "</td>";
                                    echo "<td>" . $item['quantity'] . "</td>";
                                    echo "<td>$" . number_format($item['subtotal'], 2) . "</td>";
                                    echo "</tr>";
                                }
                                echo "<tr class='order-total-row'>
                                        <td colspan='3' style='text-align: right;'>Order Total:</td>
                                        <td>$" . number_format($order['total'], 2) . "</td>
                                    </tr>
                                    
                                    </table>";
                            else:
                                echo "<p>No items found in this order.</p>";
                            endif;
                        endforeach;
                    else:
                        echo "<p>You haven't placed any orders yet.</p>";
                    endif;
                    ?>   
                    <?php elseif ($_SESSION['role'] === 'Admin'): ?> <!-- for admin users then allow to change themes, and manage users or items. -->
                        <a class="button" href="manageUsers.php">Manage Users</a>
                        <a class="button" href="manageItems.php">Manage Items</a>
                        <p>Choose a site theme:</p>
                        <button onclick="setTheme('root')">Default</button>
                        <button onclick="setTheme('theme-halloween')">Halloween</button>
                        <button onclick="setTheme('theme-christmas')">Christmas</button>
                        <p></p>
                       
                    <?php endif; ?>
            
            <a class="button" href="logout.php">Log out</a> <!-- log out button -->
        <?php endif; ?>

    </main>
</div>

<?php include 'footer.php'; ?> 