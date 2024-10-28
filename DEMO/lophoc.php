<!DOCTYPE html>
<html lang="en">
<head>
  <title>QUẢN LÝ THÔNG TIN LỚP HỌC</title>
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
  
  <a class="btn btn-primary" href="form_lop.php">Thêm mới</a>
  <br>
  <?php
    include_once("connect.php");
    //Viết câu truy vấn
    $sql = "SELECT * FROM lophoc";
    
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
      // output data of each row
      echo "<table class='table table-hover mt-3'>";
      echo "<tr><th>Mã lớp</th><th>Tên lớp</th><th>Sửa</th><th>Xóa</th></tr>";
      while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row['maLop']."</td>";
        echo "<td>".$row['tenLop']."</td>";
        echo "<td><a href='sua_lop.php?ma=".$row['maLop']."'>Sửa</a></td>";
        echo "<td><a href='xoa_lop.php?ma=".$row['maLop']."'>Xóa</a></td>";
        echo "</tr>";
      }
      echo "</table>";
    } else {
      echo "0 results";
    }
    $conn->close();
  ?>
</div>

</body>
</html>
