<?php
// clear_command.php - Called by the Raspberry Pi after execution

// Clear the command file
file_put_contents('command.txt', ''); 
echo "Command cleared.";
?>
