<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    $data = json_decode(file_get_contents('php://input'));
    $quiz_id = $_GET['quiz_id'];
    $new_title = $data->title;

    if (empty($new_title)) {
        echo json_encode(array("status" => "error", "message" => "Quiz title is required."));
        exit;
    }

    $stmt = $connection->prepare("UPDATE quizzes SET title = ? WHERE id = ?");

    if ($stmt === false) {
        echo json_encode(array("status" => "error", "message" => "Failed to prepare the SQL query."));
        exit;
    }

    $stmt->bind_param("si", $new_title, $quiz_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(array("status" => "success", "message" => "Quiz updated successfully."));
    } else {
        echo json_encode(array("status" => "error", "message" => "Failed to update quiz."));
    }

    $stmt->close();
    exit;
}
?>
