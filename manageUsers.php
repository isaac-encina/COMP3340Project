<?php 
session_start();
$pageTitle="Manage Users";
include 'header.php'; 
require "db.php";
?> 

<div class="content-wrapper">
    <?php include 'sidebar.php'; ?>
    <main class="about-main">
            <a class="button" href="manageUsersHelp.php" style="float: right; padding: 5px 20px;">Help</a>

        <h1>Manage Users</h1>
            <?php if (isset($_SESSION['error'])): ?>
                <p style="color:red;"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></p>
            <?php endif; ?>
            <?php if ($_SESSION['role'] === 'User'): ?>
                    <h2>Dont have the proper user role.</h2>
                    
            <?php elseif ($_SESSION['role'] === 'Admin'): ?>
                <?php
                    $stmt = $conn->prepare("SELECT * FROM USERS"); //get all users from database
                    $stmt->execute();
                    $users = $stmt->fetchAll();

                    if ($users): //if there are users then create the table
                        echo "<table class='order-table'>
                        <thead>
                        <tr>
                            <th colspan='5'>
                                Users
                            </th>
                        </tr>
                        <tr>
                            <th>User ID</th>
                            <th>User Name</th>
                            <th>Password</th>
                            <th>Role</th>
                            <th>Swap Role</th>
                        </tr>
                        </thead>";


                        foreach ($users as $user):
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($user['userId']) . "</td>";
                            echo "<td>" . htmlspecialchars($user['username']) . "</td>";
                            echo "<td>" . htmlspecialchars($user['password']) . "</td>";
                            echo "<td>" . htmlspecialchars($user['role']) . "</td>";
                            echo "<td><a class='button' href='swapRole.php?userId=" . urlencode($user['userId']) . "' onclick=\"return confirm('Switch role for this user?');\">Switch Role</a></td>"; //references the swap role page to change from user to admin or viceversa
                            echo "</tr>";
                                
                
                            
                        endforeach;
                        echo "</table>";
                        else:
                            echo "<p>No users.</p>";
                        endif; ?>
                
            <?php endif; ?>
            

    </main>
</div>

<?php include 'footer.php'; ?> 