<?php
session_start(); 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] == 'guest') {
    echo "<script>alert('Log in terlebih dahulu.');</script>";
    header("Location: login.php");
    exit();
}

$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'web';


$conn = mysqli_connect($servername, $username, $password, $database);


if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $user_id = $_SESSION['user_id'];
    
    $id_produk = $_POST['id_produk'];

    
    $query_produk = "SELECT harga FROM produk WHERE id_produk = '$id_produk'";
    $result_produk = mysqli_query($conn, $query_produk);

    if ($result_produk && mysqli_num_rows($result_produk) > 0) {
      
        $row_produk = mysqli_fetch_assoc($result_produk);
        $harga_produk = $row_produk['harga'];

        
        $jumlah_barang_default = 1; 
        $jumlah_barang = $jumlah_barang_default;

        if (isset($_POST['jumlah_barang'])) {
            $jumlah_barang = $_POST['jumlah_barang'];
        }

   
        $total_harga = $harga_produk * $jumlah_barang;

       
        $user_id = mysqli_real_escape_string($conn, $user_id);
        $id_produk = mysqli_real_escape_string($conn, $id_produk);
        $jumlah_barang = mysqli_real_escape_string($conn, $jumlah_barang);

       
        $query_simpan = "INSERT INTO simpan (jumlah_barang, total, produk_id_produk, user_id_user) VALUES ('$jumlah_barang', '$total_harga', '$id_produk', '$user_id')";
        $result_simpan = mysqli_query($conn, $query_simpan);


        if ($result_simpan) {
     
            $_SESSION['success_message'] = "Produk telah berhasil disimpan!";
        } else {

            $_SESSION['error_message'] = "Gagal menyimpan produk.";
        }


        header("Location: detail.php?id=" . $id_produk);
        exit(); 
    } else {

        $_SESSION['error_message'] = "Produk tidak ditemukan.";
        header("Location: detail.php?id=" . $id_produk);
        exit(); 
    }
}

mysqli_close($conn);
?>
