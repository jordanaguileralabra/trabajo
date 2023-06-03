<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votaciones</title>
    <link rel="stylesheet" href="style/style.css" alt="">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script/script.js"></script>
</head>
<body>
    <h1>FORMULARIO DE VOTACIÓN:</h1>
    <form id="formulario">
        <div class="form-group-dk">
            <label for="nombres">Nombre y Apellido</label>
            <input type="text" name="nombres" required>
        </div>
        <br>

        <div class="form-group-dk">
            <label for="alias">Alias</label>
            <input type="text" name="alias" pattern="^(?=.*[a-zA-Z])(?=.*\d).+$" minlength="5" required>
        </div>
        <br>

        <div class="form-group-dk">
            <label for="rut">Rut</label>
            <input type="text" id="rutInput" name="rut" required>
        </div>
        <br>

        <div class="form-group-dk">
            <label for="email">Email</label>
            <input type="email" name="email">
        </div>
        <br>

        <div class="form-group-dk">
            <label for="regiones">Región</label>
            <select name="region" id="region"  onchange="getCiudades()">
                <?php
                // Incluir el archivo de conexión a la base de datos
                $servername = "localhost";
                $username = "admin";
                $password = "";
                $dbname = "votaciones";
                
                $conn = new mysqli($servername, $username, $password, $dbname);
                
                // Consulta SQL para obtener los datos de la tabla "candidato"
                $sql = "SELECT * FROM regiones";
                // Ejecutar la consulta
                $result = mysqli_query($conn, $sql);

                // Verificar si hay resultados
                if (mysqli_num_rows($result) > 0) {
                    // Recorrer los resultados y generar las opciones del select
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['id'];
                        $region = $row['region'];
                        echo "<option value='$id'>$region</option>";
                    }
                } else {
                    echo "<option value=''>No hay candidatos disponibles</option>";
                }

                // Liberar el resultado
                mysqli_free_result($result);

                // Cerrar la conexión
                mysqli_close($conn);
                ?>
            </select>
        </div>
        <br>

        <div class="form-group-dk">
            <label for="comuna">Comuna</label>
            <select name="comuna" id="comuna">
            <option value="">Seleccione comuna</option>
            </select>
        </div>
        <br>

        <div class="form-group-dk">
            <label for="candidato">Candidato</label>
            <select name="candidato">
            <?php
            // Incluir el archivo de conexión a la base de datos
            $servername = "localhost";
            $username = "admin";
            $password = "";
            $dbname = "votaciones";
            
            $conn = new mysqli($servername, $username, $password, $dbname);
            
            // Consulta SQL para obtener los datos de la tabla "candidato"
            $sql = "SELECT * FROM candidatos";
            // Ejecutar la consulta
            $result = mysqli_query($conn, $sql);

            // Verificar si hay resultados
            if (mysqli_num_rows($result) > 0) {
                // Recorrer los resultados y generar las opciones del select
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['id'];
                    $nombre_candidato = $row['nombre_candidato'];
                    echo "<option value='$id'>$nombre_candidato</option>";
                }
            } else {
                echo "<option value=''>No hay candidatos disponibles</option>";
            }

            // Liberar el resultado
            mysqli_free_result($result);

            // Cerrar la conexión
            mysqli_close($conn);
            ?>
            </select>
        </div>
        <br>

        <div class="form-group-dk">
            <label>Cómo se enteró de nosotros</label><br>
            <input type="checkbox" name="tipo-votacion" value="1" id="Web">
            <label for="Web">Web</label><br>
            <input type="checkbox" name="tipo-votacion" value="2" id="TV">
            <label for="TV">TV</label><br>
            <input type="checkbox" name="tipo-votacion" value="3" id="Redes Sociales">
            <label for="Redes Sociales">Redes Sociales</label><br>
            <input type="checkbox" name="tipo-votacion" value="4" id="Amigo">
            <label for="Amigo">Amigo</label><br>
        </div>
        <br>

        <input type="submit" value="Votar">
    </form>

    <div id="resultado"><h1>Respuesta</h1></div>

    <script >
        $(document).ready(function() {
        $('#formulario').submit(function(event) {
            event.preventDefault(); // Evitar el envío del formulario por defecto

            // Obtener los datos del formulario
            var formData = $(this).serialize();

            // Realizar la solicitud AJAX
            $.ajax({
            url: 'send.php', // Archivo PHP que procesará y guardará los datos
            method: 'GET',
            data: formData,
            success: function(response) {
                $('#resultado').text(response);
                $('#formulario')[0].reset(); // Reiniciar el formulario después de enviar los datos
            },
            error: function() {
                $('#resultado').text('Error en la solicitud AJAX');
            }
            });
        });
        });
    </script>
    <script>
            document.querySelector('form').addEventListener('submit', function(event) {
            event.preventDefault(); // Evitar el envío del formulario por defecto
            
            var rutInput = document.getElementById('rutInput');
            var rut = rutInput.value.trim();
            
            if (validarRutChileno(rut)) {
            // Rut válido
            // Aquí puedes realizar las acciones necesarias si el RUT es válido
            console.log('RUT válido');
            } else {
            // Rut inválido
            // Aquí puedes realizar las acciones necesarias si el RUT es inválido
            console.log('RUT inválido');
            }
            });
            
            function validarRutChileno(rut) {
                // Eliminar puntos y guión del RUT (dejar solo dígitos y letra K en mayúscula)
                rut = rut.replace(/\./g, '').replace(/-/g, '').toUpperCase();
                
                // Verificar longitud mínima del RUT
                if (rut.length < 2) {
                return false;
                }
                
                // Extraer dígito verificador y cuerpo del RUT
                var dv = rut.slice(-1);
                var cuerpo = rut.slice(0, -1);
                
                // Verificar que el cuerpo del RUT solo contenga dígitos
                if (!/^\d+$/.test(cuerpo)) {
                return false;
                }
                
                // Cálculo del dígito verificador
                var suma = 0;
                var multiplo = 2;
                
                for (var i = cuerpo.length - 1; i >= 0; i--) {
                suma += parseInt(cuerpo.charAt(i), 10) * multiplo;
                multiplo = (multiplo + 1) % 8 || 2;
                }
                
                var dvCalculado = (11 - suma % 11).toString();
                
                if (dvCalculado === '10') {
                dvCalculado = 'K';
                } else if (dvCalculado === '11') {
                dvCalculado = '0';
                }
                
                // Comparar dígito verificador calculado con el ingresado
                return dv === dvCalculado;
            }
    </script>
</body>
</html>