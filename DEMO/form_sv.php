<?php
// Kết nối đến cơ sở dữ liệu
include_once("connect.php");

// Khai báo biến cho thông báo lỗi
$error = "";

// Xử lý khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $maSV = $_POST["txtMaSV"];
    $hoLot = $_POST["txtHoLot"];
    $tenSV = $_POST["txtTenSV"];
    $ngaySinh = $_POST["txtNgaySinh"];
    $gioiTinh = $_POST["txtGioiTinh"];
    $maLop = $_POST["txtMaLop"];

    // Kiểm tra xem mã sinh viên có bị trùng không
    $checkSql = "SELECT * FROM sinhvien WHERE maSV=?";
    $stmtCheck = $conn->prepare($checkSql);
    $stmtCheck->bind_param("s", $maSV);
    $stmtCheck->execute();
    $checkResult = $stmtCheck->get_result();

    if ($checkResult->num_rows > 0) {
        $error = "Mã sinh viên đã tồn tại. Vui lòng nhập mã sinh viên khác.";
    } else {
        // Thêm sinh viên mới vào cơ sở dữ liệu
        $sqlInsert = "INSERT INTO sinhvien (maSV, hoLot, tenSV, ngaySinh, gioiTinh, maLop)
                      VALUES (?, ?, ?, ?, ?, ?)";
        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bind_param("ssssss", $maSV, $hoLot, $tenSV, $ngaySinh, $gioiTinh, $maLop);

        if ($stmtInsert->execute()) {
            header("Location: sinhvien.php"); // Chuyển hướng về trang danh sách sinh viên sau khi thêm thành công
            exit;
        } else {
            $error = "Có lỗi xảy ra khi thêm sinh viên: " . $stmtInsert->error;
        }
    }

    $stmtCheck->close();
    $stmtInsert->close();
}

// Lấy dữ liệu maLop từ bảng lophoc
$sql = "SELECT maLop FROM lophoc";
$result = $conn->query($sql);

// Kiểm tra kết quả truy vấn
if (!$result) {
    die("Truy vấn thất bại: " . $conn->error);
}

// Khởi động session
session_start();

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: ");
    exit;
}

// Kiểm tra nếu có từ khóa tìm kiếm được gửi qua form
$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    // Truy vấn tìm kiếm sinh viên theo maSV, hoLot, tenSV hoặc maLop
    $sql = "SELECT * FROM sinhvien WHERE 
            maSV LIKE ? OR 
            hoLot LIKE ? OR 
            tenSV LIKE ? OR 
            maLop LIKE ?";
    $stmtSearch = $conn->prepare($sql);
    $likeSearch = "%" . $search . "%";
    $stmtSearch->bind_param("ssss", $likeSearch, $likeSearch, $likeSearch, $likeSearch);
    $stmtSearch->execute();
    $result = $stmtSearch->get_result();
    $stmtSearch->close();
} else {
    // Nếu không có từ khóa tìm kiếm, hiển thị toàn bộ danh sách sinh viên
    $sql = "SELECT * FROM sinhvien";
    $result = $conn->query($sql);
}

// Đóng kết nối
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Thêm sinh viên</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h2>Thêm sinh viên mới</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form action="" method="post">
        <div class="form-group">
            <label for="maSV">Mã sinh viên:</label>
            <input type="text" class="form-control" id="maSV" name="txtMaSV" placeholder="Nhập mã sinh viên" required>
        </div>
        <div class="form-group">
            <label for="hoLot">Họ và tên đệm:</label>
            <input type="text" class="form-control" id="hoLot" name="txtHoLot" placeholder="Nhập họ và tên đệm" required>
        </div>
        <div class="form-group">
            <label for="tenSV">Tên sinh viên:</label>
            <input type="text" class="form-control" id="tenSV" name="txtTenSV" placeholder="Nhập tên sinh viên" required>
        </div>
        <div class="form-group">
            <label for="ngaySinh">Ngày sinh:</label>
            <input type="date" class="form-control" id="ngaySinh" name="txtNgaySinh" required>
        </div>
        <div class="form-group">
            <label for="gioiTinh">Giới tính:</label>
            <select class="form-control" id="gioiTinh" name="txtGioiTinh" required>
                <option value="Nam">Nam</option>
                <option value="Nữ">Nữ</option>
            </select>
        </div>
        <div class="form-group">
            <label for="maLop">Mã lớp:</label>
            <select class="form-control" id="maLop" name="txtMaLop" required>
                <option value="">Chọn mã lớp</option>
                <?php
                // Hiển thị danh sách mã lớp
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($row['maLop']) . "'>" . htmlspecialchars($row['maLop']) . "</option>";
                    }
                }
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Thêm mới</button>
    </form>
</div>

</body>
</html>
