<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"]== "POST") {
    $data = json_decode(file_get_contents('php://input'));
    
    if (empty($data->username) || empty($data->password)) {
        echo json_encode(array("status" => "error", "message" => "Username and password are required."));
        exit;
    }
    $username = $data->username;
    $password = password_hash($data->password, PASSWORD_DEFAULT);
    $insert_query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    $stmt = $connection->prepare($insert_query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        echo json_encode(array("status" => "success", "message" => "User registered successfully."));
    } else {
        echo json_encode(array("status" => "error", "message" => "Registration failed. Username may already exist."));
    }
    $stmt->close();
    exit;
}
?>
