<?php
// fetch_log.php - Fetches recent task logs from the database
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'db_config.php';

// --- THIS IS THE KEY CHANGE ---
// The SQL query now explicitly selects the new 'material' column.
// We also order by 'log_id' in descending order and limit the results to the latest 100.
$sql = "SELECT 
            log_id, 
            task_name, 
            start_time, 
            pi_status, 
            pi_duration_seconds, 
            unity_status, 
            unity_duration_seconds, 
            message,
            material 
        FROM task_log 
        ORDER BY log_id DESC 
        LIMIT 100";

$result = $conn->query($sql);

$logs = array();

if ($result && $result->num_rows > 0) {
    // Fetch all results into an associative array
    while($row = $result->fetch_assoc()) {
        $logs[] = $row;
    }
}

// Even if there are no results, return a valid empty JSON array
echo json_encode($logs);

$conn->close();
?>