<?php
$pageTitle = "Create Account";
require 'db.php';
include 'header.php';
?>

<div class="content-wrapper">
    <?php include 'sidebar.php'; ?>
    <main class="about-main">
        <h1>Create Account</h1>
        <form method="post" action="signup.php">
            <fieldset>
            <legend>Account Info</legend>
            <p>
            <label for="username">Username:</label>
            <input type="text" name="username" maxlength="30" placeholder="username"required><br>
            </p>
            <p>
            <label for="password">Password:</label>
            <input type="password" name="password" minlength="8" maxlength="16"required><br>
            </p>
            </fieldset>
            <fieldset>
            <input type="submit">
            <input type="reset" value="Clear"> 
            </fieldset>
        </form>
    </main>
</div>

<?php include 'footer.php'; ?>