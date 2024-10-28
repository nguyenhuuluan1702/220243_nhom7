<?php
include_once("connect.php");

// Lấy mã lớp từ URL
$maLop = $_GET['ma'];
$tenLop = "";

// Truy vấn để lấy tên lớp dựa trên mã lớp
$sql = "SELECT * FROM lophoc WHERE maLop='$maLop'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $tenLop = $row['tenLop'];
} else {
    // Nếu không tìm thấy lớp, chuyển hướng về trang quản lý lớp
    header("Location: lophoc.php");
    exit;
}

// Xử lý khi người dùng xác nhận xóa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sqlDelete = "DELETE FROM lophoc WHERE maLop='$maLop'";
    
    if ($conn->query($sqlDelete) === TRUE) {
        header("Location: lophoc.php");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Xóa lớp học</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container">
  <h2>Xóa thông tin lớp học</h2>
  <p>Bạn có chắc chắn muốn xóa lớp học sau không?</p>
  <div class="alert alert-warning">
    <strong>Mã lớp:</strong> <?php echo $maLop; ?><br>
    <strong>Tên lớp:</strong> <?php echo $tenLop; ?>
  </div>
  
  <form method="post">
    <button type="submit" class="btn btn-danger">Xóa</button>
    <a href="lophoc.php" class="btn btn-secondary">Hủy</a>
  </form>
</div>

</body>
</html>
