<?php
header('Content-Type: application/json');

$host = 'localhost';
$db   = 'jinnah15_confer';
$user = 'jinnah15_admin';
$pass = 'Qau@2026';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $author      = $_POST['author_name'] ?? '';
        $email       = $_POST['email'] ?? '';
        $institution = $_POST['institution'] ?? '';
        $title       = $_POST['title'] ?? '';
        $subTheme    = $_POST['sub_theme'] ?? '';
        $abstract    = $_POST['abstract_text'] ?? '';
        $filePath    = null;

        // Handle PDF File Upload
        if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $fileName = time() . '_' . basename($_FILES['pdf_file']['name']);
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['pdf_file']['tmp_name'], $targetPath)) {
                $filePath = $targetPath;
            }
        }

        $sql = "INSERT INTO abstract_submissions (author_name, email, institution, title, sub_theme, abstract_text, file_path) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$author, $email, $institution, $title, $subTheme, $abstract, $filePath]);

        echo json_encode(['success' => true]);
    }
} catch (\PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>