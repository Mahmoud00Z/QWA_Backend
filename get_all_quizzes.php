<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $stmt = $connection->prepare("SELECT id, title FROM quizzes");

    if ($stmt === false) {
        echo json_encode(array("status" => "error", "message" => "Failed to prepare the SQL query."));
        exit;
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $quizzes = array();
    while ($row = $result->fetch_assoc()) {
        $quizzes[] = $row;
    }

    echo json_encode(array("status" => "success", "data" => $quizzes));

    $stmt->close();
    exit;
}
?>
