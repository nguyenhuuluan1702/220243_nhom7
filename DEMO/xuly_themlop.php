<?php
	include_once("connect.php");

	//Lấy dữ liệu từ form
	$ma = $ten = "";
	if(!empty($_POST["txtMa"])&&!empty($_POST["txtTen"]))
	{
		$ma = $_POST["txtMa"];
		$ten = $_POST["txtTen"];
	}
	//Viết câu truy vấn
	$sql = "INSERT INTO lophoc (maLop, tenLop)VALUES ('$ma', '$ten')";
	//Thực thi
	if ($conn->query($sql) === TRUE) {
  		header("Location:lophoc.php");
	} else {
		  echo "Error: " . $sql . "<br>" . $conn->error;
	}
	//Đóng kết nối
	$conn->close();
?>