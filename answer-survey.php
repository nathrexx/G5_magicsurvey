<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/database.php";
    $survey_code = $_POST["code"];

    #Get survey's id:
    $sql = "SELECT survey_id, is_active FROM surveys WHERE code = $survey_code";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();

    if ($row == NULL) {
        echo "Error: Survey does not exit.<br>";
        exit();
    }
    if ($row["is_active"] == 0) {
        echo "Error: Survey no longer active.<br>";
        exit();
    }

    $survey_id = $row["survey_id"];
    # Add a hidden input field to store the survey code
    echo "<input type='hidden' name='survey_code' value='$survey_code'>";
    
    #Get question's info:
    $sql = "SELECT question_id, description, type, options FROM questions WHERE survey_id = $survey_id";
    $result = $mysqli->query($sql);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Answer Survey</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <form action="insert-answer.php" method="post">
        <?php
            # Add a hidden input field to store the survey code
            echo "<input type='hidden' name='survey_code' value='$survey_code'>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<p>"."Question: ".$row["description"];
                if ($row["type"] == "yes_no") {
                    echo "<br>Type yes or no for answer:";
                    echo "<input type='text' name='answer_{$row['question_id']}'></p>";
                }
                if ($row["type"] == "essay") {
                    echo "<br>Type your answer in sentences:";
                    echo "<input type='text' name='answer_{$row['question_id']}'></p>";
                }
                if ($row["type"] == "multiple_answers" || $row["type"] == "multiple_choice") {
                    echo "<br>Answer choices: ".$row["options"];
                    echo "<br>Enter your answer choices:";
                    echo "<input type='text' name='answer_{$row['question_id']}'></p>";
                }
            }
        ?>
        <button type='submit'>Finish survey</button>
    </form>

</body>
</html>