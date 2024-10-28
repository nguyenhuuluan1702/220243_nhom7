<?php
include_once("connect.php");
session_start();

// Khai báo biến để lưu thông tin đăng ký và lỗi
$email = $username = $password = $confirmPassword = "";
$error = "";

// Xử lý khi form đăng ký được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    // Kiểm tra xem mật khẩu xác nhận có khớp không
    if ($password !== $confirmPassword) {
        $error = "Mật khẩu xác nhận không khớp!";
    } else {
        // Kiểm tra xem email hoặc tên đăng nhập đã tồn tại chưa
        $checkSql = "SELECT * FROM users WHERE email = '$email' OR username = '$username'";
        $checkResult = $conn->query($checkSql);

        if ($checkResult->num_rows > 0) {
            $error = "Email hoặc tên đăng nhập đã tồn tại. Vui lòng thử lại.";
        } else {
            // Mã hóa mật khẩu
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Thêm người dùng mới vào cơ sở dữ liệu
            $sqlInsert = "INSERT INTO users (email, username, password)
                          VALUES ('$email', '$username', '$hashedPassword')";

            if ($conn->query($sqlInsert) === TRUE) {
                // Đăng ký thành công, lưu thông báo và chuyển hướng về trang đăng nhập
                $_SESSION['success'] = "Đăng ký thành công! Vui lòng đăng nhập.";
                header("Location: dangnhap.php");
                exit;
            } else {
                $error = "Có lỗi xảy ra khi đăng ký: " . $conn->error;
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Đăng ký</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Đăng ký tài khoản</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form action="dangky.php" method="post">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email" required>
        </div>
        <div class="form-group">
            <label for="username">Tên đăng nhập:</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Nhập tên đăng nhập" required>
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu:</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Xác nhận mật khẩu:</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Xác nhận mật khẩu" required>
        </div>
        <button type="submit" class="btn btn-primary">Đăng ký</button>
    </form>

    <p class="mt-3">Đã có tài khoản? 
        <a href="dangnhap.php" class="btn btn-secondary">Đăng nhập</a>
    </p>
</div>
</body>
</html>
