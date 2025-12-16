<?php
// api/insert_command.php
include 'db_config.php';

$task_name = $_POST['task_name']; // Python sends "ANGLE:0,0..." or "task1"

if(empty($task_name)) {
    die("Error: No task name provided");
}

// We insert with unity_status='PENDING' so Unity picks it up
$sql = "INSERT INTO task_log (task_name, start_time, unity_status) 
        VALUES ('$task_name', NOW(), 'PENDING')";

if ($conn->query($sql) === TRUE) {
    echo "Success";
} else {
    echo "Error: " . $conn->error;
}
$conn->close();
?>
