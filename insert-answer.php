<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    session_start();
    session_regenerate_id();
    $respondent_id = $_SESSION["user_id"];

    $mysqli = require __DIR__ . "/database.php";
    $survey_code = $_POST["survey_code"];
    $sql = "SELECT survey_id FROM surveys WHERE code = $survey_code";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $survey_id = $row["survey_id"];

    #Insert answers into database
    foreach ($_POST as $key => $value) {
        if (strpos($key, "answer_") !== false) {
            $question_id = substr($key, strlen("answer_"));
            $answer = mysqli_real_escape_string($mysqli, $value);
            $sql = "INSERT INTO answers (survey_id, question_id, respondent_id, answer) 
            VALUES ('$survey_id', '$question_id', '$respondent_id', '$answer')";
            $result = mysqli_query($mysqli, $sql);
            if (!$result) {
                echo "Error inserting answer for question $question_id: " . mysqli_error($mysqli);
            }
        }
    }
}
header("Location: homepage.html");
exit();
?>