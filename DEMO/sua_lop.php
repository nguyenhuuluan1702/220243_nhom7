<?php
include_once("connect.php");

// Lấy mã lớp từ URL
$maLop = $_GET['ma'];
$tenLop = "";

// Truy vấn lấy thông tin lớp học dựa trên mã lớp
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

$error = ""; // Khai báo biến để lưu thông báo lỗi

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Nhận dữ liệu từ form
    $tenLopMoi = $_POST["txtTenMoi"];

    // Kiểm tra xem tên lớp mới có bị trùng hay không
    $checkSql = "SELECT * FROM lophoc WHERE tenLop='$tenLopMoi' AND maLop != '$maLop'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows > 0) {
        $error = "Tên lớp đã tồn tại. Vui lòng nhập tên lớp khác.";
    } else {
        // Cập nhật thông tin lớp học
        $sqlUpdate = "UPDATE lophoc SET tenLop='$tenLopMoi' WHERE maLop='$maLop'";

        if ($conn->query($sqlUpdate) === TRUE) {
            header("Location: lophoc.php");
            exit;
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sửa lớp học</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h2>Sửa thông tin lớp học</h2>
    
    <?php if ($error): ?>
        <div class="alert alert-danger">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form action="" method="post">
        <div class="form-group">
            <label for="maLop">Mã lớp:</label>
            <input type="text" class="form-control" id="maLop" name="txtMa" value="<?php echo $maLop; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="tenLopMoi">Tên lớp mới:</label>
            <input type="text" class="form-control" id="tenLopMoi" placeholder="Nhập tên lớp mới" name="txtTenMoi" value="<?php echo $tenLop; ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>

</body>
</html>
