<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "salwa";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
  die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Menangani permintaan dari formulir
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Mendapatkan data dari formulir
  $full_name = $_POST['full-name'];
  $gender = $_POST['gender'];
  $birthday = $_POST['birthday'];
  $mobile_phone = $_POST['mobile-phone'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Menggunakan hash untuk kata sandi

  // Menyiapkan dan mengeksekusi pernyataan SQL untuk menyimpan data pengguna ke dalam database
  $sql = "INSERT INTO users (full_name, gender, birthday, mobile_phone, email, password)
  VALUES ('$full_name', '$gender', '$birthday', '$mobile_phone', '$email', '$password')";

  if ($conn->query($sql) === TRUE) {
    echo "Registrasi berhasil!";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

// Menutup koneksi ke database
$conn->close();
?>
