<?php
session_start();
require "db.php";


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php");
    exit;
}

if (isset($_GET['userId'])) { //prevent main admin account from losing admin privileges
    $userId = intval($_GET['userId']);

    if ($userId === 1) {
    $_SESSION['error'] = "You cannot change the role of main admin.";
    header("Location: manageUsers.php");
    exit;
}

    
    $stmt = $conn->prepare("SELECT role FROM USERS WHERE userId = ?"); //get the current role
    $stmt->execute([$userId]);
    $user = $stmt->fetch();

    if ($user) { 
        $newRole = ($user['role'] === 'Admin') ? 'User' : 'Admin'; //make user admin or admin user

        $update = $conn->prepare("UPDATE USERS SET role = ? WHERE userId = ?");
        $update->execute([$newRole, $userId]);

        $_SESSION['success'] = "User role updated to $newRole.";
    }
}

header("Location: manageUsers.php");
exit;
