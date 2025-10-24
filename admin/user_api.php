<?php
session_start();
require_once '../config/database.php';
header('Content-Type: application/json');


if (!isset($_SESSION['loggedin'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'You must be logged in to perform this action.']);
    exit;
}

$response = ['success' => false, 'message' => 'An unknown error occurred.'];
$action = $_POST['action'] ?? null;

try {
    switch ($action) {

        case 'change_role':
            if ($_SESSION['role'] !== 'admin') {
                throw new Exception('Forbidden: You do not have permission to change user roles.');
            }
            $userIdToChange = $_POST['user_id'];
            $newRole = $_POST['new_role'];


            $stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
            $stmt->execute([$userIdToChange]);
            $user = $stmt->fetch();
            if ($user && $user['username'] === 'admin') {
                throw new Exception('The primary admin role cannot be changed.');
            }

            $stmt = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
            $stmt->execute([$newRole, $userIdToChange]);
            $response = ['success' => true, 'message' => 'User role updated successfully.'];
            break;


        case 'delete_user':
            if ($_SESSION['role'] !== 'admin') {
                throw new Exception('Forbidden: You do not have permission to delete users.');
            }
            $userIdToDelete = $_POST['user_id'];


            $stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
            $stmt->execute([$userIdToDelete]);
            $user = $stmt->fetch();
            if ($user && $user['username'] === 'admin') {
                throw new Exception('The primary admin account cannot be deleted.');
            }

            $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$userIdToDelete]);
            $response = ['success' => true, 'message' => 'User deleted successfully.'];
            break;


        case 'change_password':
            $currentPassword = $_POST['current_password'];
            $newPassword = $_POST['new_password'];
            $userId = $_SESSION['user_id'];


            $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
            $stmt->execute([$userId]);
            $user = $stmt->fetch();


            if ($user && password_verify($currentPassword, $user['password'])) {

                $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
                $stmt->execute([$newPasswordHash, $userId]);
                $response = ['success' => true, 'message' => 'Password updated successfully.'];
            } else {
                throw new Exception('Incorrect current password.');
            }
            break;

        default:
            throw new Exception('Invalid action specified.');
    }
} catch (Exception $e) {

    $statusCode = ($e->getMessage() === 'Forbidden: You do not have permission to change user roles.' || $e->getMessage() === 'Forbidden: You do not have permission to delete users.') ? 403 : 400;
    http_response_code($statusCode);
    $response = ['success' => false, 'message' => $e->getMessage()];
}

echo json_encode($response);
