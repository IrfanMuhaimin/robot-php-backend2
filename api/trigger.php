<?php
// api/trigger.php - Inserts a new task and returns its ID
header("Access-Control-Allow-Origin: *"); // Allow request from anywhere
header("Content-Type: text/plain");
include 'db_config.php';

if (isset($_POST['task'])) {
    $task_name = $conn->real_escape_string($_POST['task']);
    $start_time = date('Y-m-d H:i:s');
    
    // 🚨 CRITICAL FIX: Explicitly set the initial status to 'PENDING' for both clients.
    $initial_status = 'PENDING';

    $sql = "INSERT INTO task_log (task_name, start_time, pi_status, unity_status)
             VALUES ('$task_name', '$start_time', '$initial_status', '$initial_status')";

    if ($conn->query($sql) === TRUE) {
        $new_task_id = $conn->insert_id;
        echo $new_task_id;
    } else {
        http_response_code(500);
        echo "Error inserting record: " . $conn->error;
    }
} else {
    http_response_code(400);
    echo "No task specified.";
}
$conn->close();
?>
