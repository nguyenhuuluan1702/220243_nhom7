<?php
session_start();
include_once("connect.php");

// Kiểm tra nếu người dùng chưa đăng nhập hoặc không phải là Admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: dangnhap.php");
    exit;
}

$error = "";

// Xử lý việc thêm người dùng mới
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Kiểm tra xem người dùng đã tồn tại chưa
    $checkSql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($checkSql);

    if ($result->num_rows > 0) {
        $error = "Tên đăng nhập đã tồn tại!";
    } else {
        // Thêm người dùng mới
        $insertSql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
        if ($conn->query($insertSql) === TRUE) {
            header("Location: qluser.php");
            exit;
        } else {
            $error = "Lỗi khi thêm người dùng mới: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Thêm Người dùng</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h2>Thêm Người dùng mới</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    
    <form method="post">
        <div class="form-group">
            <label for="username">Tên đăng nhập:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        
        <div class="form-group">
            <label for="password">Mật khẩu:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        
        <div class="form-group">
            <label for="role">Quyền:</label>
            <select class="form-control" id="role" name="role">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        
        <button type="submit" class="btn btn-success">Thêm Người dùng</button>
    </form>
</div>

</body>
</html>
