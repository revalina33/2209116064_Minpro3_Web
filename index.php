<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    
</head>

<body class="bg-secondary">
<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">BeatLab</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#About">About Web</a>
        </li>
      
        <li class="nav-item">
        <a class="nav-link" href="login.php">Log Out</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="container p-0 mb-4 mt-4 rounded-3 shadow bg-white">
    <!-- menu -->
    <nav class="d-md-flex p-4">
        
       
       
    </nav>
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="banner1.png" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
       
      </div>
    </div>
    <div class="carousel-item">
      <img src="banner2.png" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
       
      </div>
    </div>
    <div class="carousel-item">
      <img src="banner3.png" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
 
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>  
    <!-- konten -->
    <div class="px-4 mb-4">
        <h2 id="Sosial_Media"></h2>
        <div class="px-4 mb-4 d-flex justify-content-end">
        <img src="logo belanja.png" class="rounded-3" style="width: 40px; height: auto; cursor: pointer;" onclick="redirectToTampilanSimpan()" />

        </div>
        <!-- Daftar Barang -->
        <div class="row row-cols-md-3 row-cols-2 gx-5 p-5">
            <?php
          
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "web";

            $conn = mysqli_connect($servername, $username, $password, $database);

            if (!$conn) {
                die("Koneksi gagal: " . mysqli_connect_error());
            }

           
            $sql = "SELECT id_produk, gambar, nama, deskripsi,harga FROM produk";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
               
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="col mb-5">';
                    echo '<div class="card shadow">';
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($row["gambar"]) . '" class="card-img-top" />';
                    echo '<div class="card-body">';
                    echo '<p class="card-text">' . $row["nama"] . '</p>';
                    echo '</div>';
                    echo '<div class="d-none deskripsi"><p>' . $row["deskripsi"] . '</p></div>';
                    echo '<div class="card-footer d-md-flex">';
                    echo '<a href="detail.php?id=' . $row['id_produk'] . '" class="btn btn-sm btn-primary d-block btnDetail">Detail</a>';

                    if (isset($row["harga"])) {
                        echo '<span class="ms-auto text-danger fw-bold d-block text-center harga">Rp. ' . number_format($row["harga"], 2, ',', '.') . '</span>';
                    } else {
                        echo '<span class="ms-auto text-danger fw-bold d-block text-center harga">Harga tidak tersedia</span>';
                    }
                    
                    
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "0 hasil";
            }
        
            
          
            mysqli_close($conn);
            ?>
        </div>
    </div>

    
    <div id="About" class="px-4 py-4 bg-secondary text-center">
        <div class="mx-auto w-75">
            <h3 class="text-white">About Web</h3>
            <p class="text-center text-white"> Beatlab merupakan sebuah toko berbasis web yang menjual berbagai jenis Headphone berkualitas dari berbagai merek terkemuka. Kami bertujuan untuk memberikan pengalaman belanja yang menyenangkan dan mudah bagi para penggemar musik dan audio.</p>
        </div>
    </div>

   

   
    <div class="text-center p-4 border-top">&copy; 2024 BeatLab </div>
</div>

<button type="button" class="btn btn-primary d-none btnModal" data-bs-toggle="modal" data-bs-target="#exampleModal">Launch demo modal</button>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 modalTitle" id="exampleModalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row">
                <div class="modalImage col-md-6 col-12"></div>
                <div class="col-md-6 col-12">
                    <div class="modalDeskripsi"></div>
                    <div class="d-md-flex">
                        <a href="" target="_blank" class="btn btn-sm btn-warning d-block btnBeli">Beli Produk Ini</a>
                        <span class="ms-auto text-danger fw-bold d-block text-center modalHarga"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
  
    function redirectToTampilanSimpan() {
        window.location.href = "tampilan_simpan.php";
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="javascript/main.js"></script>

</body>
</html>
