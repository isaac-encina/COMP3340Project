<?php //sign up page for creating new accounts.
session_start();
$pageTitle = "Sign up";
require 'db.php';

$error = "";
$success = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") { //script to handle account creation in database.
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (empty($username) || empty($password)) {
        $error = "Both fields are needed.";
    } else {
        $stmt = $conn->prepare("SELECT userId FROM USERS WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->rowCount() != 0) {
            $error = "Username not available.";
        }else {
            $stmt = $conn->prepare("INSERT INTO USERS (username, password) VALUES (?, ?)");
            $stmt->execute([$username, $password]);
            $success = "Account created! You can now <a href='login.php'>log in</a>.";
        }
    }
}

include 'header.php';
?>

<div class="content-wrapper">
    <?php include 'sidebar.php'; ?>
    <main class="about-main">
        <h1>Create Account</h1>
        <?php if ($error): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php elseif ($success): ?>
            <p style="color: green;"><?php echo $success; ?></p>
        <?php endif; ?>
        <form method="post" action="signup.php"> <!--form to input account information -->
            <fieldset>
            <legend>Account Info</legend>
            <p>
            <label for="username">Username:</label>
            <input type="text" name="username" maxlength="30" placeholder="username" required><br>
            </p>
            <p>
            <label for="password">Password:</label>
            <input type="password" name="password" minlength="8" maxlength="16" required><br>
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