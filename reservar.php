<?php
// ATENCIÓN: Complete los detalles de su base de datos a continuación
$servername = "localhost";
$username = "su_nombre_de_usuario"; // Reemplace con el nombre de usuario de su base de datos
$password = "su_contraseña"; // Reemplace con la contraseña de su base de datos
$dbname = "barberia";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener y sanitizar los datos del formulario
$nombre = $conn->real_escape_string($_POST['nombre']);
$telefono = $conn->real_escape_string($_POST['telefono']);
$fecha = $conn->real_escape_string($_POST['fecha']);
$hora = $conn->real_escape_string($_POST['hora']);
$barbero = $conn->real_escape_string($_POST['barbero']);

// Los servicios son un array, así que los unimos en un string
$servicios = isset($_POST['servicios']) ? implode(', ', $_POST['servicios']) : '';

// Calcular el total de nuevo en el servidor para seguridad
$total = 0;
if (isset($_POST['servicios']) && is_array($_POST['servicios'])) {
    // Un mapa de precios de servicios para mayor seguridad y facilidad de mantenimiento
    $precios_servicios = [
        'corte' => 8000,
        'barba' => 2000,
        'tenido-completo' => 20000,
        'claritos' => 12000
    ];

    foreach ($_POST['servicios'] as $servicio) {
        if (isset($precios_servicios[$servicio])) {
            $total += $precios_servicios[$servicio];
        }
    }
}

$sql = "INSERT INTO reservas (nombre, telefono, fecha, hora, barbero, servicios, total)
VALUES ('$nombre', '$telefono', '$fecha', '$hora', '$barbero', '$servicios', '$total')";

if ($conn->query($sql) === TRUE) {
    // Redirigir a una página de éxito
    header("Location: index.html?reserva=exito");
    exit();
} else {
    // Mostrar un error si la inserción falla
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>