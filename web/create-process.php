<?php
session_start();
// Sertakan file koneksi
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai dari formulir
    $novel_title = isset($_POST['novel_title']) ? trim($_POST['novel_title']) : '';
    $novel_genre = isset($_POST['novel_genre']) ? trim($_POST['novel_genre']) : '';
    $novel_description = isset($_POST['novel_description']) ? trim($_POST['novel_description']) : '';
    $selectedTags = isset($_POST['selectedTags']) ? $_POST['selectedTags'] : ''; // Memperbarui variabel selectedTags
    $id_usr = $_SESSION['user_id'];
    $target_dir = "uploads/"; // Direktori tempat Anda menyimpan gambar yang diunggah
    $target_file = $target_dir . basename($_FILES["novel_img"]["name"]);
    $uploadOk = 1;
    $total_chapter = 0;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Inisialisasi tanggal saat ini untuk novel_publish
    $novel_publish = date('Y-m-d');
    // Inisialisasi nilai 0 untuk novel_vote
    $novel_vote = 0;

    // Periksa apakah file gambar valid
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["novel_img"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Periksa apakah file sudah ada
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Periksa ukuran file
    if ($_FILES["novel_img"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Izinkan hanya format file tertentu
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Periksa apakah $uploadOk diatur menjadi 0 oleh suatu kesalahan
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // Jika semuanya baik-baik saja, coba unggah file
    } else {
        // Definisikan direktori tempat menyimpan file yang diunggah
        $target_dir = "uploads/";

        // Definisikan nama file target berdasarkan nama file yang diunggah
        $target_file = $target_dir . basename($_FILES["novel_img"]["name"]);

        // Periksa apakah direktori target ada atau buat jika belum ada
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true); // Buat direktori jika belum ada
        }

        // Sekarang kita dapat mencoba memindahkan file yang diunggah
        if (move_uploaded_file($_FILES["novel_img"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["novel_img"]["name"])). " has been uploaded.";
            
            // Sekarang, Anda dapat menyimpan nama file gambar ke dalam kolom novel_img di database
            $novel_img = file_get_contents($target_file);

            // Buat dan jalankan kueri SQL untuk menyimpan data dengan placeholder parameterized
            $sql = "INSERT INTO novel_list (novel_title, novel_tag, novel_description, novel_img, id_usr, novel_genre, total_chapter, novel_publish, novel_vote)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssisiss", $novel_title, $selectedTags, $novel_description, $novel_img, $id_usr, $novel_genre, $total_chapter, $novel_publish, $novel_vote);

            if ($stmt->execute()) {
                echo "New record created successfully";
                header("Location: index.php");
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $stmt->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
