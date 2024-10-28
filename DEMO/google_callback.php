<?php
require_once 'vendor/autoload.php';
include_once("connect.php");

session_start();

$client = new Google_Client();
$client->setClientId('178040620965-a3tah70qs3o6mgk1bes6g1snli3ig9o8.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/DEMO/google_callback.php');
$client->addScope('email');
$client->addScope('profile');

// Kiểm tra xem người dùng đã đăng nhập qua Google chưa
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    // Lấy thông tin người dùng từ Google
    $oauth = new Google_Service_Oauth2($client);
    $userInfo = $oauth->userinfo->get();

    $googleEmail = $userInfo->email;

    // Kiểm tra xem email đã tồn tại trong cơ sở dữ liệu chưa
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $googleEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Nếu email tồn tại, cho phép người dùng đăng nhập
        $_SESSION['username'] = $googleEmail; // Hoặc lưu thông tin khác nếu cần
        header("Location: trangchu.php");
        exit;
    } else {
        // Nếu email chưa tồn tại, yêu cầu người dùng đăng ký trước
        $_SESSION['error'] = "Tài khoản Google này chưa được đăng ký. Vui lòng đăng ký trước khi đăng nhập.";
        header("Location: dangky.php"); // Hoặc chuyển hướng tới trang đăng ký
        exit;
    }
} else {
    header("Location: dangnhap.php");
    exit;
}
?>
