-- Base de datos: `barberia_db`
-- Tabla: `reservas`

-- Crear la base de datos si no existe
CREATE DATABASE IF NOT EXISTS `barberia_db`;
USE `barberia_db`;

-- Eliminar la tabla si ya existe para empezar de cero
DROP TABLE IF EXISTS `reservas`;

-- Crear la tabla `reservas`
CREATE TABLE `reservas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_cliente` varchar(100) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `servicios` varchar(255) NOT NULL,
  `costo_total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar datos de ejemplo
INSERT INTO `reservas` (`id`, `nombre_cliente`, `fecha_hora`, `servicios`, `costo_total`) VALUES
(1, 'Juan Pérez', '2023-11-15 10:30:00', 'Corte de Pelo, Arreglo de Barba', 9500.00),
(2, 'Carlos Gómez', '2023-11-16 14:00:00', 'Teñido Completo', 20000.00),
(3, 'Ana López', '2023-11-17 18:00:00', 'Corte de Pelo', 8000.00);
