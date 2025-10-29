<?php
// Configuración de la Base de Datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barberia_db";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consultar los turnos existentes
$sql = "SELECT id, nombre_cliente, fecha_hora FROM reservas ORDER BY fecha_hora ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Torito The Barber$ - Turnos</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="bg-dark text-white text-center p-4">
        <h1>Torito The Barber$</h1>
        <p>Estilo y precisión en cada corte</p>
    </header>

    <main class="container mt-5">
        <section id="turnos">
            <h2>Modificar Turno Existente</h2>
            <p>Selecciona un turno de la lista para modificarlo.</p>

            <div id="lista-turnos" class="list-group">
                <?php
                if ($result->num_rows > 0) {
                    // Mostrar cada turno como un elemento de la lista
                    while($row = $result->fetch_assoc()) {
                        echo '<a href="#" class="list-group-item list-group-item-action" data-id="' . $row["id"] . '" data-nombre="' . htmlspecialchars($row["nombre_cliente"]) . '" data-fecha="' . date("Y-m-d\TH:i", strtotime($row["fecha_hora"])) . '">';
                        echo 'Turno #' . $row["id"] . ' - ' . htmlspecialchars($row["nombre_cliente"]) . ' - ' . date("d/m/Y H:i", strtotime($row["fecha_hora"]));
                        echo '</a>';
                    }
                } else {
                    echo '<p class="text-muted">No hay turnos registrados.</p>';
                }
                ?>
            </div>
        </section>

        <section id="formulario-modificacion" class="mt-4" style="display: none;">
            <h3>Editando Turno <span id="turno-id"></span></h3>
            <form id="booking-form" action="update_booking.php" method="POST">
                <input type="hidden" id="id_reserva" name="id_reserva">

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre del Cliente</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>

                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha y Hora</label>
                    <input type="datetime-local" class="form-control" id="fecha" name="fecha" required>
                </div>

                <div class="mb-3">
                    <h4>Servicios</h4>
                    <div class="form-check">
                        <input class="form-check-input service-checkbox" type="checkbox" value="8000" id="corte" name="servicios[]">
                        <label class="form-check-label" for="corte">Corte de Pelo ($8000)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input service-checkbox" type="checkbox" value="1500" id="barba" name="servicios[]">
                        <label class="form-check-label" for="barba">Arreglo de Barba ($1500)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input service-checkbox" type="checkbox" value="20000" id="tenido-completo" name="servicios[]">
                        <label class="form-check-label" for="tenido-completo">Teñido Completo ($20000)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input service-checkbox" type="checkbox" value="15000" id="claritos" name="servicios[]">
                        <label class="form-check-label" for="claritos">Teñido Claritos ($15000)</label>
                    </div>
                </div>

                <div class="mt-4">
                    <h3>Total a Pagar: $<span id="total-price">0</span></h3>
                </div>

                <button type="submit" class="btn btn-primary">Actualizar Turno</button>
            </form>
        </section>
    </main>

    <footer class="text-center mt-5 p-3 bg-light">
        <p>&copy; 2023 Torito The Barber$. Todos los derechos reservados.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="scripts.js"></script>
</body>
</html>
<?php
$conn->close();
?>
