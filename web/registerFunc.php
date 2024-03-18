<?php
include 'connection.php'; // File koneksi ke database

// Fungsi untuk memvalidasi input
function validateInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Cek apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form dan validasi
    $email = validateInput($_POST["email"]);
    $nickname = validateInput($_POST["nickname"]);
    $password = validateInput($_POST["password"]);
    $confirm_password = validateInput($_POST["confirm_password"]);

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Proses upload gambar profil jika ada
    $profile_picture = null;
    if ($_FILES["profile_picture"]["name"]) {
        $profile_picture = $_FILES["profile_picture"]["tmp_name"];
    }

    // Simpan data ke dalam database
    $sql = "INSERT INTO user_info (email_usr, nickname_usr, password_usr, profile_usr, account_create)
            VALUES ('$email', '$nickname', '$hashed_password', '$profile_picture', NOW())";

    if (mysqli_query($conn, $sql)) {
        // Jika sukses, redirect ke halaman lain atau tampilkan pesan sukses
        header("Location: login.php"); // Ganti "success.php" dengan halaman yang sesuai
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Tutup koneksi ke database
    mysqli_close($conn);
}