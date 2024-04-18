<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Custom CSS -->
    <link href="index.css" rel="stylesheet">
</head>
<body>


<div class="global-container">
    <div class="row justify-content-center">
        <div class="col-md-6">
      
                    <h1 style="display: flex;">LOGIN</h1>
                </div>
            <form action="login.php" method="POST">
    <div class="mb-3">
        <label for="exampleInputusername" class="form-label">Username</label>
        <input type="text" class="form-control" id="exampleInputusername" name="username" aria-describedby="usernameHelp">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" class="form-control" id="exampleInputPassword1" name="password">
    </div>
    <div class="mb-3 form-check">
        <select class="form-select" aria-label="Default select example" name="role">
            <option value="1">Admin</option>
            <option value="2">Pembeli</option>
        </select>
    </div>
    <div class="mb-3">
            <div style="display: flex; justify-content: space-between;">
                <div style="text-decoration: underline; color: black;" class="form-text" onclick="redirectToRegister()">register?</div>
               
            </div>
            <br>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

            </div>
            </div>
        </div>
        <script>
    function redirectToRegister() {
        window.location.href = 'register.php';
    }
    function redirectToIndex(){
        window.location.href ='index.php';
    }
</script>

</body>
</html>
<?php
session_start(); 

$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'web';


$conn = mysqli_connect($servername, $username, $password, $database);


if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role']; 

  
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    
    if ($role == '1') {
        $table = 'admin';
        $id_column = 'id';
    } else {
        $table = 'user';
        $id_column = 'id_user';
    }

    $sql = "SELECT * FROM $table WHERE nama='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

   
    if ($result && mysqli_num_rows($result) > 0) {
        
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row[$id_column]; 
    
        if ($role == '1') {
            header("Location: admin.php");
        } else {
            header("Location: index.php");
        }
        exit(); 
    } else {
        echo "<script>alert('Username atau password salah.');</script>";
    }
}


mysqli_close($conn);
?>
