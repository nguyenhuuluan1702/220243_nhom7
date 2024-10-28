<?php
include_once("connect.php");

// Lấy mã sinh viên từ URL
$maSV = $_GET['maSV'];

// Khai báo các biến chứa thông tin sinh viên
$hoLot = $tenSV = $ngaySinh = $gioiTinh = $maLop = "";

// Truy vấn để lấy thông tin sinh viên từ cơ sở dữ liệu dựa trên mã sinh viên
$sql = "SELECT * FROM sinhvien WHERE maSV='$maSV'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $hoLot = $row['hoLot'];
    $tenSV = $row['tenSV'];
    $ngaySinh = $row['ngaySinh'];
    $gioiTinh = $row['gioiTinh'];
    $maLop = $row['maLop'];
} else {
    // Nếu không tìm thấy sinh viên, chuyển hướng về trang danh sách sinh viên
    header("Location: sinhvien.php");
    exit;
}

$error = ""; // Khai báo biến cho thông báo lỗi

// Xử lý khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hoLotMoi = $_POST["txtHoLot"];
    $tenSVMoi = $_POST["txtTenSV"];
    $ngaySinhMoi = $_POST["txtNgaySinh"];
    $gioiTinhMoi = $_POST["txtGioiTinh"];
    $maLopMoi = $_POST["txtMaLop"];

    // Cập nhật thông tin sinh viên
    $sqlUpdate = "UPDATE sinhvien SET 
                  hoLot='$hoLotMoi', 
                  tenSV='$tenSVMoi', 
                  ngaySinh='$ngaySinhMoi', 
                  gioiTinh='$gioiTinhMoi', 
                  maLop='$maLopMoi' 
                  WHERE maSV='$maSV'";

    if ($conn->query($sqlUpdate) === TRUE) {
        header("Location: sinhvien.php"); // Chuyển hướng về trang danh sách sau khi cập nhật thành công
        exit;
    } else {
        $error = "Có lỗi xảy ra khi cập nhật sinh viên: " . $conn->error;
    }
}

// Lấy danh sách mã lớp để hiển thị trong dropdown
$sqlLop = "SELECT maLop FROM lophoc";
$resultLop = $conn->query($sqlLop);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sửa thông tin sinh viên</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h2>Sửa thông tin sinh viên</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form action="" method="post">
        <div class="form-group">
            <label for="maSV">Mã sinh viên:</label>
            <input type="text" class="form-control" id="maSV" name="txtMaSV" value="<?php echo $maSV; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="hoLot">Họ lót:</label>
            <input type="text" class="form-control" id="hoLot" name="txtHoLot" value="<?php echo $hoLot; ?>" required>
        </div>
        <div class="form-group">
            <label for="tenSV">Tên sinh viên:</label>
            <input type="text" class="form-control" id="tenSV" name="txtTenSV" value="<?php echo $tenSV; ?>" required>
        </div>
        <div class="form-group">
            <label for="ngaySinh">Ngày sinh:</label>
            <input type="date" class="form-control" id="ngaySinh" name="txtNgaySinh" value="<?php echo $ngaySinh; ?>" required>
        </div>
        <div class="form-group">
            <label for="gioiTinh">Giới tính:</label>
            <select class="form-control" id="gioiTinh" name="txtGioiTinh" required>
                <option value="Nam" <?php if ($gioiTinh == "Nam") echo "selected"; ?>>Nam</option>
                <option value="Nữ" <?php if ($gioiTinh == "Nữ") echo "selected"; ?>>Nữ</option>
            </select>
        </div>
        <div class="form-group">
            <label for="maLop">Mã lớp:</label>
            <select class="form-control" id="maLop" name="txtMaLop" required>
                <option value="">Chọn mã lớp</option>
                <?php
                if ($resultLop->num_rows > 0) {
                    while($rowLop = $resultLop->fetch_assoc()) {
                        $selected = ($rowLop['maLop'] == $maLop) ? "selected" : "";
                        echo "<option value='" . $rowLop['maLop'] . "' $selected>" . $rowLop['maLop'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>

</body>
</html>
