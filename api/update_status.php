<?php
// api/update_status.php - Handles status updates for PI or UNITY clients
include 'db_config.php';

if (isset($_POST['log_id']) && isset($_POST['new_status']) && isset($_POST['client_type'])) {
    $log_id = intval($_POST['log_id']);
    $new_status = $conn->real_escape_string($_POST['new_status']);
    $client_type = $conn->real_escape_string($_POST['client_type']); // 'pi' or 'unity'
    $message = isset($_POST['message']) ? $conn->real_escape_string($_POST['message']) : '';

    $update_sql = "";

    $status_col = $client_type . '_status';
    $duration_col = $client_type . '_duration_seconds';
    
    if (!in_array($client_type, ['pi', 'unity'])) {
        http_response_code(400);
        die("Invalid client_type.");
    }

    if ($new_status == 'RUNNING') {
        $update_sql = "UPDATE task_log SET $status_col = 'RUNNING' WHERE log_id = $log_id";
    }
    elseif (in_array($new_status, ['FINISHED', 'BROKEN', 'ERROR'])) {
        
        $fetch_sql = "SELECT start_time FROM task_log WHERE log_id = $log_id";
        $result = $conn->query($fetch_sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $start_time_ts = strtotime($row['start_time']);
            $stop_time_ts = time();
            $duration = $stop_time_ts - $start_time_ts;
            
            $update_sql = "UPDATE task_log SET 
                           $status_col = '$new_status', 
                           $duration_col = $duration";
            
            if ($message) {
                 $update_sql .= ", message = CONCAT(IFNULL(message, ''), ' | $client_type: $message')";
            }
                           
            $update_sql .= " WHERE log_id = $log_id";
        }
    }
    
    if (!empty($update_sql) && $conn->query($update_sql) === TRUE) {
        echo "$client_type Task $log_id status updated to $new_status.";
    } else {
        http_response_code(500);
        echo "Error updating record: " . $conn->error;
    }

} else {
    http_response_code(400);
    echo "Missing log_id, new_status, or client_type.";
}
$conn->close();
?>
