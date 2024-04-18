<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['id_produk'])) {
    $_SESSION['id_produk'] = $_POST['id_produk'];
}

if (isset($_SESSION['id_produk'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "web";
    $conn = mysqli_connect($servername, $username, $password, $database);

    if (!$conn) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }

    $id_produk = $_SESSION['id_produk'];
    $sql = "SELECT nama, harga FROM produk WHERE id_produk = '$id_produk'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $nama_produk = $row['nama'];
        $harga_per_produk = $row['harga'];

        echo '<div style="background-color: #f8f9fa; border-radius: 10px; padding: 20px; width: 50%; margin: auto; text-align: center;">';
        echo '<h2>Anda memilih untuk membeli produk: ' . $nama_produk . '</h2>';

        echo '<form action="" method="post" style="margin-top: 20px;">';
        echo '<div class="mb-3">';
        echo '<label for="jumlah" class="form-label">Jumlah Produk:</label>';
        echo '<input type="number" class="form-control" id="jumlah" name="jumlah" min="1" required>';
        echo '</div>';
        echo '<button type="submit" class="btn btn-primary" name="hitung">Hitung Total Harga</button>';
        echo '</form>';

        if (isset($_POST['hitung'])) {
            if (isset($_POST['jumlah'])) {
                $jumlah = $_POST['jumlah'];
                $total_harga = $jumlah * $harga_per_produk;
                $_SESSION['total_harga'] = $total_harga; // Simpan total harga dalam SESSION
                echo '<h3 style="margin-top: 20px;">Total Harga untuk ' . $jumlah . ' ' . $nama_produk . ': ' . $total_harga . '</h3>';

                echo '<form action="proses_pembayaran.php" method="post">';
                echo '<input type="hidden" name="id_produk" value="' . $id_produk . '">';
                echo '<input type="hidden" name="jumlah" value="' . $jumlah . '">';
                echo '<button type="submit" class="btn btn-success" name="bayar" style="margin-top: 20px;">Bayar Sekarang</button>';
                echo '</form>';
            } else {
                echo '<div class="alert alert-warning mt-4" role="alert">Masukkan jumlah produk terlebih dahulu.</div>';
            }
        }
        echo '</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert" style="text-align: center;">Produk tidak ditemukan.</div>';
    }

    mysqli_close($conn);
} else {
    echo '<div class="alert alert-warning" role="alert" style="text-align: center;">Anda belum memilih produk untuk dibeli.</div>';
}
?>
