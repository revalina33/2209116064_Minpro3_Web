<?php
session_start();

if (!isset($_SESSION['user_id'])) {
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


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
   
    if (isset($_POST['selected_items'])) {
        $user_id = $_SESSION['user_id'];
        foreach ($_POST['selected_items'] as $selected_id) {
            $delete_query = "DELETE FROM simpan WHERE id = '$selected_id' AND user_id_user = '$user_id'";
            $delete_result = mysqli_query($conn, $delete_query);
            if (!$delete_result) {
                $_SESSION['error_message'] = "Gagal menghapus produk dengan ID: $selected_id.";
            }
        }
        $_SESSION['success_message'] = "Produk yang dipilih telah dihapus dari simpanan.";
    } else {
        $_SESSION['error_message'] = "Tidak ada produk yang dipilih untuk dihapus.";
    }
   
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bayar'])) {
    if (isset($_POST['selected_items']) && !empty($_POST['selected_items'])) {
       
        $total_harga = 0;
        foreach ($_POST['selected_items'] as $selected_id) {
            $user_id = $_SESSION['user_id']; 
            $select_query = "SELECT total FROM simpan WHERE id = '$selected_id' AND user_id_user = '$user_id'";
            $select_result = mysqli_query($conn, $select_query);
            if ($select_result && mysqli_num_rows($select_result) > 0) {
                $row = mysqli_fetch_assoc($select_result);
                $total_harga += $row['total'];
            }
        }
       
        $_SESSION['total_harga'] = $total_harga;
       
        header("Location: proses_pembayaran.php");
        exit();
    } else {
       
        $_SESSION['error_message'] = "Tidak ada item yang dipilih untuk dibayar.";
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }
}


$user_id = $_SESSION['user_id'];
$query_simpan = "SELECT simpan.id, simpan.jumlah_barang, simpan.total, produk.gambar FROM simpan INNER JOIN produk ON simpan.produk_id_produk = produk.id_produk WHERE simpan.user_id_user = '$user_id'";
$result_simpan = mysqli_query($conn, $query_simpan);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simpan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Simpan</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"> 
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Gambar Barang</th>
                        <th>Jumlah Barang</th>
                        <th>Total</th>
                        <th>Check Out</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_simpan && mysqli_num_rows($result_simpan) > 0) {
                        while ($row = mysqli_fetch_assoc($result_simpan)) {
                            echo "<tr>";
                            echo "<td><img src='data:image/jpeg;base64," . base64_encode($row['gambar']) . "' width='100'></td>";
                            echo "<td>" . $row['jumlah_barang'] . "</td>";
                            echo "<td>" . $row['total'] . "</td>";
                            echo "<td><input type='checkbox' name='selected_items[]' value='" . $row['id'] . "'></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>Tidak ada data yang ditemukan.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <button type="submit" class="btn btn-primary" name="bayar">Bayar</button>
        <button type="submit" class="btn btn-danger" name="delete">Hapus</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

</body>
</html>
