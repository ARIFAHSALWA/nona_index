<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nonariwa";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die ("Koneksi ke database gagal: " . $conn->connect_error);
}

// Menangani permintaan dari formulir
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan data dari formulir
    $username = $_POST['username'];
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];
    $mobile_phone = $_POST['mobile-phone'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Menggunakan hash untuk kata sandi

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Format email tidak valid.";
        exit();
    }

    // Menyiapkan dan mengeksekusi pernyataan SQL untuk menyimpan data pengguna ke dalam database menggunakan prepared statement
    $sql = "INSERT INTO users (username, gender, birthday, mobile_phone, email, password) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $username, $gender, $birthday, $mobile_phone, $email, $password);

    if ($stmt->execute()) {
        // Registrasi berhasil, arahkan ke halaman login.php
        $stmt->close();
        $conn->close();
        header("Location: login.php");
        exit(); // Pastikan tidak ada output lain sebelum redirect
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Menutup koneksi ke database
$conn->close();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Mansalva&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #fce4ec; /* Warna latar belakang */
            font-family: 'Comic Sans MS', cursive; /* Font */
        }

        .container {
            margin-top: 50px;
        }

        h1 {
            color: #ff80ab; /* Warna judul */
            text-align: center;
            font-family: 'Comic Sans MS', cursive; /* Font judul dengan sentuhan humor */
        }

        .form-group label {
            color: #ff80ab; /* Warna label */
            font-family: 'Comic Sans MS', cursive; /* Font label dengan sentuhan humor */
        }

        .btn-primary {
            background-color: #ff80ab; /* Warna tombol */
            border-color: #ff80ab;
        }

        .btn-primary:hover {
            background-color: #ff4081; /* Warna tombol saat hover */
            border-color: #ff4081;
        }

        .login-link {
            color: #ff80ab; /* Warna tautan login */
            font-family: 'Comic Sans MS', cursive; /* Font tautan login dengan sentuhan humor */
        }

        .login-link a {
            color: #ff80ab; /* Warna tautan login */
        }

        .login-link a:hover {
            color: #ff4081; /* Warna tautan login saat hover */
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>NONARIWA BEAUTY</h1>
        <form id="registration-form" method="post" action="register.php">
            <div class="form-group">
                <label for="username">Full Name</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <select class="form-control" id="gender" name="gender" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            <div class="form-group">
                <label for="birthday">Date of Birthday</label>
                <input type="date" class="form-control" id="birthday" name="birthday" required>
            </div>
            <div class="form-group">
                <label for="mobile-phone">Mobile Phone</label>
                <input type="tel" class="form-control" id="mobile-phone" name="mobile-phone" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </form>
        <div class="login-link text-center mt-3">
            Already have an account? <a href="login.php">Please login here.</a>
        </div>
    </div>

</body>

</html>

