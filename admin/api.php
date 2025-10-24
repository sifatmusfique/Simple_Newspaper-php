<?php

session_start();

if (!isset($_SESSION['loggedin']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'moderator')) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'You do not have permission to perform this action.']);
    exit;
}

require_once '../config/database.php';
header('Content-Type: application/json');

$response = ['success' => false, 'message' => 'An unknown error occurred.'];
$action = $_POST['action'] ?? $_GET['action'] ?? null;

define('UPLOAD_DIR', '../uploads/');
define('MAX_FILE_SIZE', 10 * 1024 * 1024); 
$allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

try {
    switch ($action) {
        case 'get_article':
   
            $id = $_GET['id'] ?? null;
            if (!$id) {
                throw new Exception('Article ID is required.');
            }
            $stmt = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
            $stmt->execute([$id]);
            $article = $stmt->fetch();
            if ($article) {
                 
                $response = ['success' => true, 'data' => $article];
            } else {
                throw new Exception('Article not found.');
            }
            break;

        case 'save_article':
            $id = $_POST['id'] ?? null;
            $title = $_POST['title'];
            $content = $_POST['content'];
            $category = $_POST['category'];
            $existing_image_path = $_POST['existing_image_path'] ?? null;
            $image_path_to_save = $existing_image_path; 
            // --- Validate Image Upload ---           
            if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['image_file'];

                // Validate type
                if (!in_array($file['type'], $allowed_types)) {
                    throw new Exception('Invalid file type. Only JPG, PNG, GIF, WEBP allowed.');
                }

                // Validate size
                if ($file['size'] > MAX_FILE_SIZE) {
                    throw new Exception('File size exceeds the limit of 5MB.');
                }

                // Generate filename
                $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $unique_filename = uniqid('img_', true) . '.' . $extension;
                $target_path = UPLOAD_DIR . $unique_filename;

                // Create uploads directory
                if (!is_dir(UPLOAD_DIR)) {
                    mkdir(UPLOAD_DIR, 0755, true);
                }

                // Move the uploaded file
                if (!move_uploaded_file($file['tmp_name'], $target_path)) {
                    throw new Exception('Failed to move uploaded file.');
                }
                
                $image_path_to_save = 'uploads/' . $unique_filename; 

                if ($id && $existing_image_path && $existing_image_path !== $image_path_to_save && file_exists('../' . $existing_image_path)) {
                     unlink('../' . $existing_image_path);
                }

            } elseif (empty($id) && (!isset($_FILES['image_file']) || $_FILES['image_file']['error'] !== UPLOAD_ERR_OK)) {
                 
                 throw new Exception('Image file is required when adding a new article.');
            }

            // --- Save Article to Database ---
            if (empty($id)) { 
                $stmt = $pdo->prepare("INSERT INTO articles (title, content, category, image_url) VALUES (?, ?, ?, ?)");
                $stmt->execute([$title, $content, $category, $image_path_to_save]);
                $response = ['success' => true, 'message' => 'Article added successfully.'];
            } else { 
                $stmt = $pdo->prepare("UPDATE articles SET title = ?, content = ?, category = ?, image_url = ? WHERE id = ?");
                $stmt->execute([$title, $content, $category, $image_path_to_save, $id]);
                $response = ['success' => true, 'message' => 'Article updated successfully.'];
            }
            break;

        case 'delete_article':
            $id = $_POST['id'] ?? null;
            if (!$id) {
                throw new Exception('Article ID is required.');
            }
            $stmt = $pdo->prepare("SELECT image_url FROM articles WHERE id = ?");
            $stmt->execute([$id]);
            $image_path_to_delete = $stmt->fetchColumn();

            $stmt = $pdo->prepare("DELETE FROM articles WHERE id = ?");
            $stmt->execute([$id]);

            if ($stmt->rowCount() > 0 && $image_path_to_delete && file_exists('../' . $image_path_to_delete)) {
                unlink('../' . $image_path_to_delete);
            }
            $response = ['success' => true, 'message' => 'Article deleted successfully.'];
            break;
            
        default:
            throw new Exception('Invalid action specified.');
    }
} catch (Exception $e) {
    http_response_code(400);
    $response = ['success' => false, 'message' => $e->getMessage()];
}

echo json_encode($response);
?>

