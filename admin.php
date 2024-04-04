<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Dashboard Admin</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Produk</a>
        </li>
      
        <li class="nav-item">
          <a class="nav-link" href="login.php">Log Out</a>
        </li>
       
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">
    <div class="row">
        <?php
        
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "web";

        $conn = mysqli_connect($servername, $username, $password, $database);

        if (!$conn) {
            die("Koneksi gagal: " . mysqli_connect_error());
        }

        $sql = "SELECT id_produk, gambar, nama, deskripsi, harga FROM produk";
        $result = mysqli_query($conn, $sql);
        
        
        if (mysqli_num_rows($result) > 0) {
          
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="col-md-4 mb-4">';
                echo '<div class="card">';
                echo '<img src="data:image/jpeg;base64,' . base64_encode($row["gambar"]) . '" class="card-img-top" alt="' . $row["nama"] . '">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $row["nama"] . '</h5>';
                echo '<p class="card-text">' . $row["deskripsi"] . '</p>';
                echo '</div>';
                echo '<div class="card-footer">';
                echo '<a href="edit.php?id=' . $row['id_produk'] . '" class="btn btn-primary">Edit</a>';



                echo '<span class="text-danger fw-bold ms-2">Rp. ' . number_format($row["harga"], 2, ',', '.') . '</span>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "Tidak ada produk yang tersedia.";
        }

     
        mysqli_close($conn);
        ?>
    </div>
    <div class="container mt-2 mb-4">
  <a href="tambah.php" class="btn btn-primary" style="align-items: center;">Tambah Produk Baru</a>
</div>

</div>

</body>
</html>
