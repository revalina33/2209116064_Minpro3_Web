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


if (!isset($_SESSION['user_id'])) {
  
    header("Location: login.php");
    exit(); 
}


$user_id = $_SESSION['user_id'];


$user_id = mysqli_real_escape_string($conn, $user_id);


if(isset($_POST['selected_items'])) {
   
    $selected_items = $_POST['selected_items'];

   
    $total_price_query = "SELECT SUM(total) AS total_price FROM simpan WHERE id IN (" . implode(",", $selected_items) . ")";
    $total_price_result = mysqli_query($conn, $total_price_query);
    $total_price_row = mysqli_fetch_assoc($total_price_result);
    $total_price = $total_price_row['total_price'];

    
    echo "Total harga yang harus dibayar: " . $total_price;
} else {
    echo "Tidak ada item yang dipilih untuk check out.";
}


mysqli_close($conn);
?>
