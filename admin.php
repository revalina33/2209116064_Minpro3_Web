<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin</title>
  <style>
    .sidebar {
      position: fixed;
      width: 200px;
      height: 100vh; 
      z-index: 1; 
      left: 0; 
      background-color: #f1f1f1; 
      overflow-x: hidden; 
      padding: 20px;
      transition: width 0.3s ease-in-out; 
    }

    .sidebar.collapsed {
      width: 60px; 
      transition: width 0.3s ease-in-out; 
    }

    .sidebar a {
      display: block;
      width: 100%; 
      color: black;
      text-align: left;
      padding: 8px 16px;
      text-decoration: none;
    }

    .sidebar a:hover {
      background-color: #e9e9e9; 
    }

    .main {
      margin-left: 200px; 
      padding: 20px;
      min-height: 100vh; 
      transition: margin-left 0.3s ease-in-out;
    }

    .main.collapsed {
      margin-left: 60px; 
      transition: margin-left 0.3s ease-in-out; 
    }

    .toggle-btn {
      position: absolute;
      top: 10px;
      left: 10px;
      display: none;
      cursor: pointer;
    }

    .main.collapsed .toggle-btn {
      display: block;  
    }

    .toggle-btn.open {
      left: auto;
      right: 10px;
    }
  </style>
</head>
<body>
  <div class="sidebar" id="sidebar">
    <a class="navbar-brand"><b>Dashboard Admin</b></a>
    <a href="#">Produk</a>
    <a href="login.php">Log Out</a>
    <button class="toggle-btn btn btn-light" onclick="toggleSidebar()">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 1.646z"/>
      </svg>
    </button>
  </div>


  <div class="main" id="main-content">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
      </div>
    </nav>

    <div class="container mt-4">
      <div class="row">
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

        $sql = "SELECT id_produk, gambar, nama, deskripsi, harga FROM produk";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
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
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-mQgXXvMJzGSsRNqMkUobv4V8/DjbCTwjbswtBedq2yW8NLbvz9BtSRyYv+dQpPtO" crossorigin="anonymous"></script>

  <script>
    function toggleSidebar() {
      var sidebar = document.getElementById('sidebar');
      var mainContent = document.getElementById('main-content');
      var toggleBtn = document.querySelector('.toggle-btn');

      if (sidebar.classList.contains('collapsed')) {
        // Buka sidebar ke kiri
        sidebar.classList.remove('collapsed');
        mainContent.classList.remove('collapsed');
        toggleBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 1.646z"/></svg>';
      } else {
        // Tutup sidebar ke kanan
        sidebar.classList.add('collapsed');
        mainContent.classList.add('collapsed');
        toggleBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L6.707 8l4.647 4.646a.5.5 0 1 1-.708.708l-5-5a.5.5 0 0 1 0-.708l5-5a.5.5 0 0 1 .708 0z"/></svg>';
      }
    }
  </script>
</body>
</html>
