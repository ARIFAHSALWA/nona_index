<?php
include "config.php";

// Inisialisasi variabel pemberitahuan
$login_error = "";

// Menangani permintaan dari formulir
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan data dari formulir
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Mengecek apakah username cocok dengan data di database
    $sql = "SELECT * FROM users WHERE username=?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Memeriksa apakah password yang dimasukkan cocok dengan password di database
        if (password_verify($password, $row['password'])) {
            session_start();
            $_SESSION["login"] = true;
            $_SESSION["user"] = $row["id_pelanggan"];
            $_SESSION["username"] = $row["username"];

            // role == admin "Location: admin/index.php"
            // role == user ""Location: user/index.php"
            if ($row["role"] == "admin") {
                header("Location: admin/index_admin.php");
            } elseif ($row["role"] == "user") {
                header("Location: user/index_user.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $login_error = "Password yang dimasukkan salah.";
        }
    } else {
        $login_error = "Username tidak ditemukan.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Mansalva&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #fce4ec; /* Warna latar belakang */
            font-family: 'Comic Sans MS', cursive; /* Font */
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); /* Efek shadow */
        }

        .card-header {
            background-color: #ff80ab; /* Warna header card */
            color: #fff;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            font-family: 'Comic Sans MS', cursive; /* Font header dengan sentuhan humor */
        }

        .btn-primary {
            background-color: #ff80ab; /* Warna tombol */
            border-color: #ff80ab;
        }

        .btn-primary:hover {
            background-color: #ff4081; /* Warna tombol saat hover */
            border-color: #ff4081;
        }

        .fun-text {
            font-family: 'Comic Sans MS', cursive; /* Font dengan sentuhan humor */
        }
    </style>
</head>

<body>
    <?php if (!empty($login_error)): ?>
        <div id="errorAlert" class="alert alert-danger w-75 mx-auto mt-4">
            <p class="font-weight-bold m-0 text-center fun-text">
                <?= $login_error; ?> Oopsie Woopsie, something went wrong!
            </p>
        </div>
        <script>
            setTimeout(function () {
                document.getElementById("errorAlert").style.display = "none";
            }, 3000); // kasih waktu (3 detik)
        </script>
    <?php endif; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center fun-text">Login</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="">
                            <div class="form-group">
                                <label for="username" class="fun-text">Username:</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password" class="fun-text">Password:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
                        </form>
                        <div class="mt-3 text-center fun-text">
                            <p>Don't have an account? <a href="register.php">Register here</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
