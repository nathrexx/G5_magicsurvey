<?php
$mysqli = require __DIR__ . "/database.php";

$sql = "SELECT survey_id, code, name, description, start_datetime, end_datetime, is_deleted FROM surveys";
$result = mysqli_query($mysqli, $sql);

// Construct an SQL query
if ($result) {
    echo "Retrieve surveys successfully";
} else {
    echo "Error: " . mysqli_error($mysqli);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Survey</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <h1>View Survey</h1>
    <form action="answer-survey.php" method="post" id="survey_code" novalidate>
        <label for="availableSurvey">Available Survey:</label>
        <?php
            date_default_timezone_set('America/Los_Angeles');
            $currentDate = date("Y-m-d H:i:s");
            echo "<br>Current time: $currentDate<br>";
            while ($row = mysqli_fetch_assoc($result)) {
                $end_datetime = new DateTime($row["end_datetime"], new DatetimeZone('UTC'));
                $end_datetime->setTimezone(new DateTimeZone('America/Los_Angeles'));
                $end_datetime_string = $end_datetime->format('Y-m-d H:i:s');
                $new_end_datetime = date("Y-m-d H-i-s", strtotime($end_datetime_string));
                if ($new_end_datetime >= $currentDate and $row["is_deleted"] == 0) {
                    $sql_temp = "UPDATE surveys SET is_active = '1' WHERE survey_id = ".$row["survey_id"];
                    mysqli_query($mysqli, $sql_temp);
                    echo "<p>"."Code: ".$row["code"]
                    ."<br>Name: ".$row["name"]
                    ."<br>Description: ".$row["description"]
                    ."<br>Start: ".$row["start_datetime"]
                    ."<br>End: ".$row["end_datetime"]."</p>";
                }
                else {
                    $sql_temp = "UPDATE surveys SET is_active = '0' WHERE survey_id = ".$row["survey_id"];
                    mysqli_query($mysqli, $sql_temp);
                }
            }
        ?>
            <label for="searchSurvey">Enter Survey Code to participate:</label>
            <input type="text" name="code" id="Code">
            <button>Start survey</button>
    </form>

    <form action="delete-survey.php">
            <button type="submit">Delete survey</button>
    </form>

    <form action="homepage.html">
        <button type="submit">Back to homepage</button>
    </form>

</body>
</html>