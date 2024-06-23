<?php
session_start();
session_destroy();
header("Location: /siti/index.php"); // Perubahan URL arahan
?>