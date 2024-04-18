<?php
// Mulai sesi jika belum dimulai
session_start();

// Buat koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$database = "web";

$conn = mysqli_connect($servername, $username, $password, $database);

// Periksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $username = $_POST['username'];
    $password = $_POST['password'];

   
    
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    $sql_check = "SELECT * FROM user WHERE nama = '$username'";
    $result = mysqli_query($conn, $sql_check);

  if (mysqli_num_rows($result) > 0) {
    echo "<script>alert('Username Sudah digunakan.');</script>";
  } else {
   
    $sql = "INSERT INTO user (nama, password) VALUES ('$username', '$password')";
    if (mysqli_query($conn, $sql)) {
        
      $_SESSION['registration_success'] = true;
      header("Location: login.php");
      exit();
    
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
  }
}
  
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #1690A7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .global-container {
            background-color: #fff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="global-container">
        <form action="register.php" method="POST">
            <h1 class="mb-4 text-center">Registration</h1>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email</label>
                <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputUsername" class="form-label">Username</label>
                <input type="text" class="form-control" id="exampleInputUsername" name="username"required>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="password"required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            
        </form>
    </div>
</body>
</html>
<form action="bayar.php" method="post"> 