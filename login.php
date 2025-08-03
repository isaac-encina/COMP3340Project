<?php
session_start();
require "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT userId, password, role FROM USERS WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && $user['password'] === $password) { //verifies password and usernames match.
        $_SESSION['userId'] = $user['userId'];
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $user['role'];
        header("Location: account.php");
        exit;
    } else {
        echo "<p style='color: red;'>Invalid username or password.</p>";
        echo "<p><a href='account.php'>Try again</a></p>";
    }
}
?>