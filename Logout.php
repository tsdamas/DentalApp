<?php
session_start();
$_SESSION = [];
session_destroy();
header("Content-Type: application/json");
echo json_encode(['status' => 'success', 'message' => 'Successfully logged out!']);
exit;
?>