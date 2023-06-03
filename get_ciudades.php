<?php
// Incluir el archivo de conexión a la base de datos
$servername = "localhost";
$username = "admin";
$password = "";
$dbname = "votaciones";

$conn = new mysqli($servername, $username, $password, $dbname);


// Obtener el ID de la región seleccionada desde la petición AJAX
$regionId = $_GET['regionId'];

// Consulta SQL para obtener las comunas de la región seleccionada
$sql = "SELECT * FROM comunas WHERE id_region = $regionId";

// Ejecutar la consulta
$result = mysqli_query($conn, $sql);

// Generar las opciones de las comunas
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $nombre_comuna = $row['comuna'];
        echo "<option value='$id'>$nombre_comuna</option>";
    }
} else {
    echo "<option value=''>No hay comunas disponibles</option>";
}

// Liberar el resultado
mysqli_free_result($result);

// Cerrar la conexión
mysqli_close($conn);
?>