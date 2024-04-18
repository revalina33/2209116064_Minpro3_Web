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

$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nomor_kartu'])) {
        // Proses pembayaran
        // Di sini Anda dapat menambahkan logika untuk memproses pembayaran
        // Misalnya, memvalidasi nomor kartu kredit dan menambahkan ke database transaksi
        $success = true; // Set variabel sukses menjadi true
    } else {
        $error = "Nomor kartu kredit diperlukan."; // Set pesan error jika nomor kartu kredit kosong
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proses Pembayaran</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mb-4">Proses Pembayaran</h2>
            <?php if ($error != ""): ?>
                <div class="alert alert-danger" role="alert"><?php echo $error; ?></div>
            <?php elseif ($success): ?>
                <div class="alert alert-success" role="alert">Pembayaran berhasil!</div>
            <?php endif; ?>
            <p>Total yang harus dibayar: <?php echo isset($_SESSION['total_harga']) ? $_SESSION['total_harga'] : ''; ?></p>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="nomor_kartu" class="form-label">Nomor Kartu Kredit:</label>
                    <input type="text" class="form-control" id="nomor_kartu" name="nomor_kartu" required>
                </div>
                <button type="submit" class="btn btn-primary">Bayar</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
