<?php
session_start(); // Mulai sesi

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
    $password = validateInput($_POST["password"]);

    // Ambil data pengguna dari database berdasarkan email
    $sql = "SELECT * FROM user_info WHERE email_usr = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        // Verifikasi password
        if (password_verify($password, $row["password_usr"])) {
            // Jika password benar, set sesi pengguna
            $_SESSION["user_id"] = $row["id_usr"];
            $_SESSION["email"] = $row["email_usr"];
            $_SESSION["nickname"] = $row["nickname_usr"];
            // Redirect ke halaman dashboard atau halaman lainnya
            header("Location: index.php"); // Ganti "dashboard.php" dengan halaman yang sesuai
            exit();
        } else {
            echo "Password salah.";
        }
    } else {
        echo "Email tidak ditemukan.";
    }

    // Tutup koneksi ke database
    mysqli_close($conn);
}
?>
