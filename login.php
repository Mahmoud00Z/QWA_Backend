<?php
include 'connection.php';
if ($_SERVER["REQUEST_METHOD"]== "POST") {
    $data = json_decode(file_get_contents('php://input'));
    if (empty($data->username) || empty($data->password)) {
        echo json_encode(["error" => "Username and password are required."]);
        exit;
    }
    $username = $data->username;
    $password = $data->password;
    $stmt = $connection->prepare("SELECT id, password FROM users WHERE username = ?");
    
    if ($stmt === false) {
        echo json_encode(array("status" => "error", "message" => "Failed to prepare the SQL query."));
        exit;
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($user_id, $hashed_password);

    if ($stmt->num_rows == 0) {
        echo json_encode(array("status" => "error", "message" => "Invalid username or password."));
    } else {
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            echo json_encode(array("status" => "success", "message" => "Login successful.", "user_id" => $user_id));
        } else {
            echo json_encode(array("status" => "error", "message" => "Invalid username or password."));
        }
    }

    $stmt->close();
    exit;
}
?>