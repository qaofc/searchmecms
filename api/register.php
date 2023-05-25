<?php
require_once 'config.php';
header('Content-Type: application/json');

$headers = apache_request_headers();

if (isset($headers['X-THM-API-Key']) && $headers['X-THM-API-Key'] === 'ffe60ecaa8bba2f12b43d1a4b15b8f39') {
    $input = json_decode(file_get_contents('php://input'), true);

    $stmt = $mysqli->prepare("INSERT INTO users (username, password, email, name) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $input['username'], password_hash($input['password'], PASSWORD_DEFAULT), $input['email'], $input['name']);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Registration successful.']);
    } else {
        echo json_encode(['error' => 'Registration failed: ' . $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(array('error' => 'Invalid or Expired API key'));
  }

?>
