<?php
// api/check_unity_command.php
include 'db_config.php';

// 1. Find the oldest command
$sql = "SELECT log_id, task_name 
        FROM task_log 
        WHERE unity_status = 'PENDING' 
        ORDER BY log_id ASC LIMIT 1";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // 2. Output format: "105|ANGLE:0,45,0,0,0,0"
    echo $row['log_id'] . "|" . $row['task_name'];

    // 3. IMPORTANT: Mark as RUNNING immediately so we don't fetch it again next poll
    $updateSql = "UPDATE task_log SET unity_status = 'RUNNING' WHERE log_id = " . $row['log_id'];
    $conn->query($updateSql);

} else {
    echo "none";
}
$conn->close();
?>
