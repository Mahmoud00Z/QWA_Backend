<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $quiz_id = $_GET['quiz_id']; 

    if (empty($quiz_id)) {
        echo json_encode(array("status" => "error", "message" => "Quiz ID is required."));
        exit;
    }

    $stmt = $connection->prepare("SELECT id, question, answer FROM questions WHERE quiz_id = ?");

    if ($stmt === false) {
        echo json_encode(array("status" => "error", "message" => "Failed to prepare the SQL query."));
        exit;
    }

    $stmt->bind_param("i", $quiz_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $questions = array();
    while ($row = $result->fetch_assoc()) {
        $questions[] = $row;
    }

    if (count($questions) > 0) {
        echo json_encode(array("status" => "success", "data" => $questions));
    } else {
        echo json_encode(array("status" => "error", "message" => "No questions found for this quiz."));
    }

    $stmt->close();
    exit;
}
?>
