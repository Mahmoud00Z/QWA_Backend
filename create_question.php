<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'));

    if (empty($data->quiz_id) || empty($data->question) || empty($data->answer)) {
        echo json_encode(array("status" => "error", "message" => "Quiz ID, question, and answer are required."));
        exit;
    }

    $quiz_id = $data->quiz_id;
    $question = $data->question;
    $answer = $data->answer;

    $stmt = $connection->prepare("INSERT INTO questions (quiz_id, question, answer) VALUES (?, ?, ?)");

    if ($stmt === false) {
        echo json_encode(array("status" => "error", "message" => "Failed to prepare the SQL query."));
        exit;
    }

    $stmt->bind_param("iss", $quiz_id, $question, $answer);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(array("status" => "success", "message" => "Question created successfully."));
    } else {
        echo json_encode(array("status" => "error", "message" => "Failed to create question."));
    }

    $stmt->close();
    exit;
}
?>
