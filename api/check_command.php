<?php
// api/check_command.php - Finds the oldest task where both clients are PENDING
include 'db_config.php';

// Selects the oldest task that hasn't started yet (both clients PENDING)
$sql = "SELECT log_id, task_name 
        FROM task_log 
        WHERE pi_status = 'PENDING' AND unity_status = 'PENDING' 
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
