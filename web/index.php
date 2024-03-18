<?php
    session_start();
    include 'connection.php';
?>  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary" style="background-color: #e3f2fd;">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">Navbar</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="top-novel.php">Top Novel</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Genre
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Fantasy</a></li>
                                <li><a class="dropdown-item" href="#">Romance</a></li>
                                <li><a class="dropdown-item" href="#">Sci-Fi</a></li>
                                <li><a class="dropdown-item" href="#">Fan-Fiction</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <form class="d-flex" role="search" action="search.php" method="get" onsubmit="return submitForm()">
                    <input id="searchInput" class="form-control me-2" type="search" name="query" placeholder="Search Novel..." aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
                <?php 
                    if(!isset($_SESSION['user_id'])){
                ?>
                    <!-- Tampilkan tombol login dan register jika pengguna belum login -->
                    <a type="button" class="btn btn-outline-primary m-10" href="login.php">Login</a>/
                    <a type="button" class="btn btn-outline-secondary m-10" href="register.php">Register</a>
                <?php
                    } else {
                ?>                
                    <!-- Tampilkan tombol dropdown jika pengguna telah login -->
                    <div class="btn-group">
                        <img class="square m-20" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png" alt="" width="40px" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="create-novel.php">Write a Novel</a></li>
                            <li><a class="dropdown-item" href="#">Library</a></li>
                            <li><a class="dropdown-item" href="#">Account</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </div>
                <?php
                    }
                ?>
            </div>
        </nav>
    </header>

    <main>
        <div class="container text-center">
            <h1>Top Novel</h1>
        </div>
        <div class="container text-center">
            <div class="row row-cols-6">
                <?php
                    $sql = "SELECT * FROM novel_list";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_array($result)) {
                ?>
                    <a href="novel.php?id=<?= $row['novel_id'] ?>" class="card col" style="width: 18rem;">
                    <img src="data:image/jpeg;base64,<?= base64_encode($row['novel_img']) ?>" class="card-img-top" alt="Novel Image">
                    <div class="card-body">
                        <h5 class="card-title"><?= $row['novel_title'] ?></h5>
                        <p class="card-text">Tags: <?= $row['novel_tag'] ?></p>
                        <p class="card-text">Genre: <?= $row['novel_genre'] ?></p>
                        <p class="card-text">Total Chapter: <?= $row['total_chapter'] ?></p>
                    </div>
                </a>
                <?php
                    }
                ?>
            </div>
        </div>
    </main>

    <footer></footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script>
        function submitForm() {
            var query = document.getElementById("searchInput").value;
            window.location.href = "search.php?query=" + encodeURIComponent(query);
            return false; // Menghentikan pengiriman formulir default
        }
    </script>
</body>
</html>