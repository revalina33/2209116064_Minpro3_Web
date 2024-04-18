<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-bottom">
    <div class="container">
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <form action="simpan.php" method="POST">
                        <input type="hidden" name="id_produk" value="<?php echo $_GET['id']; ?>">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </li>
                <li class="nav-item" style="margin: 0 10px;">
                    <form action="beli.php" method="POST">
                        <input type="hidden" name="id_produk" value="<?php echo $_GET['id']; ?>">
                        <button type="submit" class="btn btn-success">Beli</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <?php
            session_start();
            if (!isset($_SESSION['user_id'])) {
                header("Location: login.php");
                exit();
            }
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "web";

            $conn = mysqli_connect($servername, $username, $password, $database);
      
            if (!$conn) {
                die("Koneksi gagal: " . mysqli_connect_error());
            }

            if (isset($_GET['id'])) {
                $id_produk = mysqli_real_escape_string($conn, $_GET['id']);

                $sql = "SELECT nama, gambar, deskripsi FROM produk WHERE id_produk = '$id_produk'";
                $result = mysqli_query($conn, $sql);

                if ($result) {
                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        echo '<h2 class="text-center mb-4">Detail Produk</h2>';
                        echo '<div class="card">';
                        echo '<img src="data:image/jpeg;base64,' . base64_encode($row["gambar"]) . '" class="card-img-top" style="max-width: 300px; margin: auto;" />';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title text-center">' . $row["nama"] . '</h5>';
                        echo '<p class="card-text">' . $row["deskripsi"] . '</p>';
                        echo '</div>';
                        echo '</div>';
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Deskripsi tidak ditemukan.</div>';
                    }
                } else {
                    echo '<div class="alert alert-danger" role="alert">Error: ' . mysqli_error($conn) . '</div>';
                }

                mysqli_close($conn);
            } else {
                echo '<div class="alert alert-warning" role="alert">Parameter id tidak ditemukan.</div>';
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>
