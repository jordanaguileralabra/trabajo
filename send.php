<?php
// Incluir el archivo de conexión a la base de datos
$servername = "localhost";
$username = "admin";
$password = "";
$dbname = "votaciones";

$conn = new mysqli($servername, $username, $password, $dbname);


// Obtener los datos del formulario
$rut = mysqli_real_escape_string($conn, $_GET['rut']);
$nombres = mysqli_real_escape_string($conn, $_GET['nombres']);
$alias = mysqli_real_escape_string($conn, $_GET['alias']);
$email = mysqli_real_escape_string($conn, $_GET['email']);
$id_region = mysqli_real_escape_string($conn, $_GET['region']);
$id_comuna = mysqli_real_escape_string($conn, $_GET['comuna']);
$id_candidato = mysqli_real_escape_string($conn, $_GET['candidato']);
$id_medio = mysqli_real_escape_string($conn, $_GET['tipo-votacion']);

// Preparar la consulta SQL

$duplicate = "SELECT rut FROM votaciones WHERE rut = $rut ";

if($duplicate != $rut){
  $sql = "INSERT INTO votaciones (rut, nombres, alias, email, id_region, id_comuna, id_candidato, id_medio) VALUES ('$rut', '$nombres', '$alias', '$email', $id_region, $id_comuna, $id_candidato, $id_medio)";
  if ($conn->query($sql) === TRUE) {
    echo "Los datos se han insertado correctamente.";
  } else {
    echo "Error al insertar los datos: " . $conn->error;
  }
  $conn->close();
}else{
  echo "Ya existe este rut, ingrese otro";
}
?>