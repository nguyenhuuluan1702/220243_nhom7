<?php
$servername = "localhost"; // Hoặc địa chỉ server của bạn
$username = "root"; // Tên đăng nhập của database
$password = ""; // Mật khẩu của database
$dbname = "ql_sinhvien"; // Tên cơ sở dữ liệu

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
