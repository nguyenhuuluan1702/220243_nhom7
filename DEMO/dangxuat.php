<?php
session_start();
session_unset(); // Hủy tất cả các biến session
session_destroy(); // Hủy session

header("Location: dangnhap.php");
exit;
?>
