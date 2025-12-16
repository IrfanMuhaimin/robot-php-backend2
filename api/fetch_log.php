<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
// api/fetch_log.php - Fetches recent task history
include 'db_config.php';

$sql = "SELECT log_id, task_name, start_time, 
               pi_status, pi_duration_seconds, 
               unity_status, unity_duration_seconds,
               message
        FROM task_log 
        ORDER BY log_id DESC 
        LIMIT 10"; 

$result = $conn->query($sql);
$logs = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $logs[] = $row;
    }
}
header('Content-Type: application/json');
echo json_encode($logs);

$conn->close();
?>
