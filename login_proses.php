<?php
header('Content-Type: application/json');

include 'config/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Query untuk memeriksa username dan password di database
        $query = "SELECT * FROM users WHERE username=:username AND password=:password";
        $stmt = $koneksi->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password); // Perhatikan: tidak menggunakan hash
        $stmt->execute();

        // Ambil hasil
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Periksa hasil query
        if ($result) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'failed']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    } finally {
        $stmt = null;
    }

    $koneksi = null;
}
?>
