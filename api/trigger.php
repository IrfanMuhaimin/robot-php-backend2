<?php
// api/trigger.php
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/plain");
include 'db_config.php';

if (isset($_POST['task'])) {
    $task_name = $conn->real_escape_string($_POST['task']);
    
    // This will now be empty, which is correct
    $message = isset($_POST['message']) ? $conn->real_escape_string($_POST['message']) : '';

    // This will contain the recipe string
    $material = isset($_POST['material']) ? $conn->real_escape_string($_POST['material']) : '';

    $start_time = date('Y-m-d H:i:s');
    $initial_status = 'PENDING';

    $sql = "INSERT INTO task_log (task_name, start_time, message, material, pi_status, unity_status)
             VALUES ('$task_name', '$start_time', '$message', '$material', '$initial_status', '$initial_status')";

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