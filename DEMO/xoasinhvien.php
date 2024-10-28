<?php
include_once("connect.php");

// Lấy mã sinh viên từ URL
$maSV = $_GET['maSV'];

// Kiểm tra xem mã sinh viên có tồn tại trong URL không
if (isset($maSV)) {
    // Thực hiện câu lệnh xóa sinh viên dựa trên mã sinh viên
    $sql = "DELETE FROM sinhvien WHERE maSV='$maSV'";

    if ($conn->query($sql) === TRUE) {
        // Nếu xóa thành công, chuyển hướng về trang danh sách sinh viên
        header("Location: sinhvien.php");
        exit;
    } else {
        echo "Có lỗi xảy ra khi xóa sinh viên: " . $conn->error;
    }
} else {
    // Nếu không tìm thấy mã sinh viên, chuyển hướng về trang danh sách sinh viên
    header("Location: sinhvien.php");
    exit;
}

$conn->close();
?>
