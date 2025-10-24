<?php
session_start();
require '../config/database.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {

    session_regenerate_id(true);


        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];


        header('Location: dashboard.php');
        exit;
    } else {

        header('Location: index.php?error=1');
        exit;
    }
} else {

    header('Location: index.php');
    exit;
}
