<?php
session_start();
include("include/config.php");
error_reporting(0);
 
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $loginpassword = $_POST['loginpassword'];
    $hasedpassword = hash('sha256', $loginpassword); // แฮชรหัสผ่าน
 
    try {
        // SQL Query
        $ret = "SELECT * FROM userdata WHERE username=:uname AND loginpassword=:loginpassword";
        $queryt = $dbh->prepare($ret);
        $queryt->bindParam(':uname', $username, PDO::PARAM_STR);
        $queryt->bindParam(':loginpassword', $hasedpassword, PDO::PARAM_STR);
        $queryt->execute();
 
        // ตรวจสอบผลลัพธ์
        if ($queryt->rowCount() > 0) {
            $_SESSION['username'] = $username; // เก็บ username ใน session
            header('Location: welcome.php'); // เปลี่ยนหน้าไปยัง welcome.php
            exit();
        } else {
            echo "<script>alert('username หรือ password ไม่ถูกต้อง');</script>";
        }
    } catch (PDOException $e) {
        exit("Error: " . $e->getMessage());
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login Page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
 
<div class="container">
  <h2>Login Page</h2>
  <form action="" method="post">
    <div class="form-group">
      <label for="username">UserName:</label>
      <input type="text" class="form-control" id="username" placeholder="Enter UserName" name="username" required>
    </div>
    <div class="form-group">
      <label for="loginpassword">Password:</label>
      <input type="password" class="form-control" id="loginpassword" placeholder="Enter password" name="loginpassword" required>
    </div>
    <button type="submit" class="btn btn-success" name="login" id="login">Login</button>
  </form>
</div>
 
</body>
</html>