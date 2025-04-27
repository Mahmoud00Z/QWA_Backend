<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $quiz_id = $_GET['quiz_id'];

    $stmt = $connection->prepare("DELETE FROM quizzes WHERE id = ?");

    if ($stmt === false) {
        echo json_encode(array("status" => "error", "message" => "Failed to prepare the SQL query."));
        exit;
    }

    $stmt->bind_param("i", $quiz_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(array("status" => "success", "message" => "Quiz deleted successfully."));
    } else {
        echo json_encode(array("status" => "error", "message" => "Failed to delete quiz."));
    }

    $stmt->close();
    exit;
}
?>
