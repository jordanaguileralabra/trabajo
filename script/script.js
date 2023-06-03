function getCiudades() {
    var regionId = document.getElementById("region").value;

    // Realizar una petición AJAX a un archivo PHP que obtenga las comunas de la región seleccionada
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("comuna").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "get_ciudades.php?regionId=" + regionId, true);
    xmlhttp.send();
}

function validarFormulario() {
    var checkboxes = document.getElementsByName("tipo-votacion");
    var contador = 0;
    
    for (var i = 0; i < checkboxes.length; i++) {
    if (checkboxes[i].checked) {
        contador++;
    }
    }
    
    if (contador < 2) {
    alert("Debe seleccionar al menos 2 opciones.");
    return false;
    }
    
    return true;
}