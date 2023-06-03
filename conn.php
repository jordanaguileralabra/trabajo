<?php
$servername = "localhost";
$username = "admin";
$password = "";
$dbname = "votaciones";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

echo "Conexión exitosa a la base de datos";

$conn->close();
?>