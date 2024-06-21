<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Datos de conexión a la base de datos
    include('../PHP/Functions/connection.php');

    // Recoger datos desde el formulario
    $nombre_clase = $_POST['nombre_clase'];
    $id_profesor = $_SESSION['id_usuario'];

    // Validar los datos recibidos
    if (empty($nombre_clase)) {
        die("El nombre de la clase es requerido.");
    }

    // Verificar que $id_profesor es un entero
    if (!is_numeric($id_profesor)) {
        die("El ID del profesor no es válido.");
    }

    // Preparar y ejecutar la consulta SQL para insertar una nueva clase
    $sql = "INSERT INTO clases (nombre_clase, id_profesor) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error en la preparación de la declaración: " . $conn->error);
    }

    // Convertir $id_profesor a entero si no lo es
    $id_profesor = (int)$id_profesor;

    $stmt->bind_param("si", $nombre_clase, $id_profesor);

    if ($stmt->execute()) {
        echo "<script>alert('Nueva clase creada exitosamente.'); window.location.href = '../inicio.php';</script>";
        exit; // Asegurarse de que el script se detenga después del redireccionamiento
    } else {
        echo "Error: " . $stmt->error;
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nueva Clase</title>
</head>
<body>
    <h2>Crear Nueva Clase</h2>
    <form action="crear_clase.php" method="post">
        <label for="nombre_clase">Nombre de la Clase:</label><br>
        <input type="text" id="nombre_clase" name="nombre_clase" required><br><br>
        <input type="submit" value="Crear Clase">
    </form>
    <a href="panel_profesor.php">Volver al Panel</a>
</body>
</html>
