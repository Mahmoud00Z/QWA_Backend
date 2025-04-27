<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $question_id = $_GET['question_id'];

    if (empty($question_id)) {
        echo json_encode(array("status" => "error", "message" => "Question ID is required."));
        exit;
    }

    $stmt = $connection->prepare("DELETE FROM questions WHERE id = ?");

    if ($stmt === false) {
        echo json_encode(array("status" => "error", "message" => "Failed to prepare the SQL query."));
        exit;
    }

    $stmt->bind_param("i", $question_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(array("status" => "success", "message" => "Question deleted successfully."));
    } else {
        echo json_encode(array("status" => "error", "message" => "Failed to delete question."));
    }

    $stmt->close();
    exit;
}
//ez abl bse3a w noss mn l deadline 
?>
