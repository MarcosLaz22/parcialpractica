<?php
// 1. Configuración de la Base de Datos
$servername = "localhost"; // O la IP de tu servidor de BD
$username = "root"; // Usuario de la BD
$password = ""; // Contraseña de la BD
$dbname = "barberia_db"; // Nombre de la BD

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// 2. Verificar si se reciben datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 3. Recoger y validar los datos del formulario
    $id_reserva = isset($_POST['id_reserva']) ? intval($_POST['id_reserva']) : 0;
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $fecha = isset($_POST['fecha']) ? trim($_POST['fecha']) : '';
    $servicios_seleccionados = isset($_POST['servicios']) ? $_POST['servicios'] : [];

    if ($id_reserva > 0 && !empty($nombre) && !empty($fecha) && !empty($servicios_seleccionados)) {

        // 4. Calcular el costo total y preparar la descripción de servicios
        $costo_total = 0;
        $servicios_nombres = [];

        // Mapeo de precios a nombres de servicios
        $mapa_servicios = [
            '8000' => 'Corte de Pelo',
            '1500' => 'Arreglo de Barba',
            '20000' => 'Teñido Completo',
            '15000' => 'Teñido Claritos'
        ];

        foreach ($servicios_seleccionados as $precio) {
            $costo_total += intval($precio);
            if (isset($mapa_servicios[$precio])) {
                $servicios_nombres[] = $mapa_servicios[$precio];
            }
        }
        $servicios_str = implode(', ', $servicios_nombres);

        // 5. Preparar y ejecutar la consulta UPDATE
        $sql = "UPDATE reservas SET nombre_cliente = ?, fecha_hora = ?, servicios = ?, costo_total = ? WHERE id = ?";

        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Vincular parámetros: s = string, d = double, i = integer
            $stmt->bind_param("sssdi", $nombre, $fecha, $servicios_str, $costo_total, $id_reserva);

            // Ejecutar la sentencia
            if ($stmt->execute()) {
                // Redirigir a la página principal con un mensaje de éxito
                header("Location: index.php?status=success");
                exit();
            } else {
                echo "Error al actualizar el turno: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error al preparar la consulta: " . $conn->error;
        }

    } else {
        echo "Error: Todos los campos son obligatorios.";
    }
} else {
    // Si no es una solicitud POST, redirigir o mostrar un error
    echo "Método de solicitud no permitido.";
}

// 6. Cerrar la conexión
$conn->close();
?>
