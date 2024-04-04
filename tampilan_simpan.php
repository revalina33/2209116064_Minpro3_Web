<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Simpan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Data Simpan</h2>
    <form action="bayar.php" method="post"> <!-- Form untuk proses pembayaran -->
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
                    session_start(); // Mulai sesi jika belum dimulai

                    $servername = 'localhost';
                    $username = 'root';
                    $password = '';
                    $database = 'web';

                    // Buat koneksi
                    $conn = mysqli_connect($servername, $username, $password, $database);

                    // Periksa koneksi
                    if (!$conn) {
                        die("Koneksi gagal: " . mysqli_connect_error());
                    }

                    // Periksa apakah pengguna telah login
                    if (!isset($_SESSION['user_id'])) {
                        // Jika belum, alihkan ke halaman login
                        header("Location: login.php");
                        exit(); // Keluar dari skrip setelah melakukan pengalihan header
                    }

                    // Ambil ID pengguna dari sesi
                    $user_id = $_SESSION['user_id'];

                    // Escape karakter khusus dalam string untuk mencegah SQL Injection
                    $user_id = mysqli_real_escape_string($conn, $user_id);

                    // Query untuk menampilkan data simpan berdasarkan ID pengguna
                    $query_simpan = "SELECT simpan.id, simpan.jumlah_barang, simpan.total, produk.gambar FROM simpan INNER JOIN produk ON simpan.produk_id_produk = produk.id_produk WHERE simpan.user_id_user = '$user_id'";
                    $result_simpan = mysqli_query($conn, $query_simpan);

                    // Periksa apakah ada data yang ditemukan
                    if ($result_simpan && mysqli_num_rows($result_simpan) > 0) {
                        // Tampilkan data simpan dalam tabel
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
                    

                    // Tutup koneksi database
                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
        <button type="submit" class="btn btn-primary">Bayar</button> <!-- Tombol untuk proses pembayaran -->
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>
