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
        $fullName    = $_POST['full_name'] ?? '';
        $email       = $_POST['email'] ?? '';
        $phone       = $_POST['phone'] ?? '';
        $institution = $_POST['institution'] ?? '';
        $regType     = $_POST['registration_type'] ?? 'Delegate';

        $sql = "INSERT INTO delegate_registrations (full_name, email, phone, institution, registration_type) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$fullName, $email, $phone, $institution, $regType]);

        echo json_encode(['success' => true]);
    }
} catch (\PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>