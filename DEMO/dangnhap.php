<?php

if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger">
        <?php 
        echo $_SESSION['error']; 
        unset($_SESSION['error']); // Xóa thông báo sau khi hiển thị
        ?>
    </div>
<?php endif;
require_once 'vendor/autoload.php';

// Thiết lập client OAuth 2.0
$client = new Google_Client();
$client->setClientId('178040620965-a3tah70qs3o6mgk1bes6g1snli3ig9o8.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/DEMO/google_callback.php'); // Chỉnh sửa URL này cho đúng
$client->addScope('email');
$client->addScope('profile');

session_start();

// Nếu người dùng chưa đăng nhập, hiển thị nút đăng nhập Google
$googleLoginUrl = $client->createAuthUrl();

include_once("connect.php");

$username = $password = "";
$error = "";

// Kiểm tra và hiển thị thông báo đăng ký thành công
if (isset($_SESSION['success'])) {
    $successMessage = $_SESSION['success'];
    unset($_SESSION['success']); // Xóa thông báo sau khi hiển thị
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    // Truy vấn lấy thông tin người dùng từ cơ sở dữ liệu
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username); // Ràng buộc tham số
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Kiểm tra mật khẩu
        if (password_verify($password, $row['password'])) {
            // Tạo session cho người dùng
            $_SESSION['username'] = $username;
            header("Location: trangchu.php");
            exit;
        } else {
            $error = "Mật khẩu không đúng!";
        }
    } else {
        $error = "Tài khoản không tồn tại!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Đăng nhập</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Đăng nhập</h2>

    <?php if (isset($successMessage)): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($successMessage); ?>
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form action="dangnhap.php" method="post">
        <div class="form-group">
            <label for="username">Tên đăng nhập:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Đăng nhập</button>
        <a href="<?php echo $googleLoginUrl; ?>" class="btn btn-secondary">Đăng nhập với Google</a>
    </form>

    <p class="mt-3">Chưa có tài khoản? 
        <a href="dangky.php" class="btn btn-secondary">Đăng ký ngay</a>
    </p>
</div>
</body>
</html>
