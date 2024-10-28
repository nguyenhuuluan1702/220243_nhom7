

<?php
include_once("connect.php");

session_start();

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: dangnhap.php");
    exit;
}

// Kiểm tra nếu có từ khóa tìm kiếm được gửi qua form
$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    // Truy vấn tìm kiếm sinh viên theo maSV, hoLot, tenSV hoặc maLop
    $sql = "SELECT * FROM sinhvien WHERE 
            maSV LIKE '%$search%' OR 
            hoLot LIKE '%$search%' OR 
            tenSV LIKE '%$search%' OR 
            maLop LIKE '%$search%'";
} else {
    // Nếu không có từ khóa tìm kiếm, hiển thị toàn bộ danh sách sinh viên
    $sql = "SELECT * FROM sinhvien";
}

$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Form LỚP HỌC</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container">
  <h2>QUẢN LÝ THÔNG TIN LỚP HỌC</h2>
  <form action="xuly_themlop.php" method = "post">
    <div class="form-group">
      <label for="malop">Mã lớp:</label>
      <input type="text" class="form-control" id="malop" placeholder="Nhập mã lớp" name="txtMa">
    </div>
    <div class="form-group">
      <label for="tenlop">Tên lớp:</label>
      <input type="text" class="form-control" id="tenlop" placeholder="Nhập tên lớp" name="txtTen">
    </div>

    <button type="submit" class="btn btn-primary">Thêm mới</button>
  </form>
</div>

</body>
</html>
