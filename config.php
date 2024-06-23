<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'nonariwa');

$connect = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// cek koneksi berhasil 
if (!$connect) {
    die ("Koneksi database gagal: " . mysqli_connect_error());
}

function query($query, $connect)
{
    $result = mysqli_query($connect, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

function updateUser($data, $connect)
{
    $id = $data["user_id"];
    $result = query("SELECT password FROM user WHERE user_id = $id", $connect)[0];
    $username = $data["username"];

    if (empty ($data["password"])) {
        $password = $result["password"];
    } else {
        $password = password_hash($data["password"], PASSWORD_DEFAULT);
    }

    $query = "UPDATE user SET
                username = '$username',
                password = '$password'
              WHERE user_id = $id
            ";

    $result = mysqli_query($connect, $query);

    // Periksa query berhasil dieksekusi
    if (!$result) {
        die ("Error query: " . mysqli_error($connect));
    }

    return mysqli_affected_rows($connect);
}
?>