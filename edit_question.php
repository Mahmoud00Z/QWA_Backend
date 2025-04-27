<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    $data = json_decode(file_get_contents('php://input'));
    $question_id = $_GET['question_id'];

    if (empty($data->question) || empty($data->answer)) {
        echo json_encode(array("status" => "error", "message" => "Question and answer are required."));
        exit;
    }

    $question = $data->question;
    $answer = $data->answer;

    $stmt = $connection->prepare("UPDATE questions SET question = ?, answer = ? WHERE id = ?");

    if ($stmt === false) {
        echo json_encode(array("status" => "error", "message" => "Failed to prepare the SQL query."));
        exit;
    }

    $stmt->bind_param("ssi", $question, $answer, $question_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(array("status" => "success", "message" => "Question updated successfully."));
    } else {
        echo json_encode(array("status" => "error", "message" => "Failed to update question."));
    }

    $stmt->close();
    exit;
}
?>
