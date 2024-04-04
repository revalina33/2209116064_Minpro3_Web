<?php

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "web";

$conn = mysqli_connect($servername, $username, $password, $database);


if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}




$message = '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $id_produk = $_POST['id_produk'];
    
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $gambar = addslashes(file_get_contents($_FILES['gambar']['tmp_name'])); // Mengambil data gambar

    
    $nama = mysqli_real_escape_string($conn, $nama);
    $deskripsi = mysqli_real_escape_string($conn, $deskripsi);
    $harga = mysqli_real_escape_string($conn, $harga);

    $sql = "INSERT INTO produk (id_produk, gambar, nama, deskripsi, harga) VALUES ('$id_produk', '$gambar', '$nama', '$deskripsi', '$harga')";


    if (mysqli_query($conn, $sql)) {
        $message = "Produk berhasil ditambahkan ke tabel produk.";
    } else {
        $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}


$sql_produk = "SELECT * FROM produk";
$result_produk = mysqli_query($conn, $sql_produk);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
</head>
<body>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <h2>Tambah Produk Baru</h2>
            <?php if (!empty($message)) : ?>
                <div class="alert alert-<?php echo $message === "Produk berhasil ditambahkan ke tabel produk." ? 'success' : 'danger'; ?>" role="alert">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="id_produk">ID Produk</label>
                    <input type="text" class="form-control" id="id_produk" name="id_produk" required>
                </div>

                <div class="mb-3">
                    <label for="nama">Nama Produk</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                
                <div class="mb-3">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                </div>
                
                <div class="mb-3">
                    <label for="harga">Harga</label>
                    <input type="text" class="form-control" id="harga" name="harga" required>
                </div>
                
                <div class="mb-3">
                    <label for="gambar">Gambar Produk</label>
                    <input type="file" class="form-control" id="gambar" name="gambar" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Tambah Produk</button>
            </form>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <h2>Daftar Produk</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row_produk = mysqli_fetch_assoc($result_produk)) : ?>
                        <tr>
                            <th scope="row"><?php echo $row_produk['id_produk']; ?></th>
                            <td><?php echo $row_produk['nama']; ?></td>
                            <td><?php echo $row_produk['deskripsi']; ?></td>
                            <td><?php echo $row_produk['harga']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
