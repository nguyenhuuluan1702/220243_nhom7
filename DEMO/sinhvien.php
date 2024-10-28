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
    <title>Quản lý sinh viên</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <style>
        .logout-btn {
            position: absolute;
            right: 20px;
            top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Danh sách sinh viên</h2>
    <p class="logout-btn"> Chào, <?php echo $_SESSION['username']; ?>! <a href="dangxuat.php" class="btn btn-danger">Đăng xuất</a></p>
    <!-- Form tìm kiếm sinh viên -->
    <form class="form-inline mb-3" method="GET" action="">
        <input class="form-control mr-sm-2" type="search" name="search" placeholder="Tìm kiếm sinh viên" value="<?php echo $search; ?>">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Tìm kiếm</button>
    </form>

    <a href="form_sv.php" class="btn btn-primary mb-3">Thêm sinh viên mới</a>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mã sinh viên</th>
                <th>Họ lót</th>
                <th>Tên</th>
                <th>Ngày sinh</th>
                <th>Giới tính</th>
                <th>Mã lớp</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['maSV'] . "</td>";
                    echo "<td>" . $row['hoLot'] . "</td>";
                    echo "<td>" . $row['tenSV'] . "</td>";
                    echo "<td>" . $row['ngaySinh'] . "</td>";
                    echo "<td>" . $row['gioiTinh'] . "</td>";
                    echo "<td>" . $row['maLop'] . "</td>";
                    echo "<td>";
                    echo "<a href='suasinhvien.php?maSV=" . $row['maSV'] . "' class='btn btn-warning btn-sm'>Sửa</a> ";
                    echo "<a href='xoasinhvien.php?maSV=" . $row['maSV'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Bạn có chắc chắn muốn xóa sinh viên này không?\");'>Xóa</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7' class='text-center'>Không có sinh viên nào</td></tr>";
            }
            ?>
        </tbody>
        </table>
        
</div>

</body>
</html>