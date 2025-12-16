<?php
// api/check_pi_command.php - Finds the oldest task where PI_STATUS is PENDING
include 'db_config.php';

$sql = "SELECT log_id, task_name 
        FROM task_log 
        WHERE pi_status = 'PENDING' 
        ORDER BY log_id ASC LIMIT 1";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo $row['log_id'] . "|" . $row['task_name'];
} else {
    echo "none";
}
$conn->close();
?>
