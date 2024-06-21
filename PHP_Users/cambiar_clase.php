<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    die("Acceso denegado. Por favor, inicia sesión.");
}

// Datos de conexión a la base de datos
include('../PHP/Functions/connection.php');

// Obtener el id del alumno desde la sesión (en este caso, se asume que el id del alumno está en la sesión)
$id_alumno = $_SESSION['id_usuario']; // Aquí deberías tener el id del alumno, asumiendo que está en la sesión
$nombre_usuario = $_SESSION['nombre_usuario'];

// Verificar si se envió el formulario de cambio de clase
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_nueva_clase'])) {
        $id_nueva_clase = $_POST['id_nueva_clase'];

        // Actualizar la tabla de alumnos con la nueva clase
        $sql_update = "UPDATE alumnos SET id_clase = ? WHERE id_alumno = ?";
        $stmt_update = $conn->prepare($sql_update);
        if ($stmt_update === false) {
            die("Error en la preparación de la actualización: " . $conn->error);
        }
        $stmt_update->bind_param("ii", $id_nueva_clase, $id_alumno);
        if ($stmt_update->execute()) {
            $mensaje = "¡Cambio de clase realizado correctamente!";
        } else {
            $mensaje = "Error al cambiar de clase: " . $stmt_update->error;
        }
        $stmt_update->close();
    }
}

// Obtener las clases actuales del alumno
$sql_actual = "SELECT a.id_alumno, a.nombre AS nombre_alumno, a.apellido AS apellido_alumno, 
                     cl.id_clase, cl.nombre_clase 
              FROM alumnos a
              INNER JOIN clases cl ON a.id_clase = cl.id_clase
              WHERE a.id_alumno = ?";
$stmt_actual = $conn->prepare($sql_actual);
if ($stmt_actual === false) {
    die("Error en la preparación de la consulta actual: " . $conn->error);
}
$stmt_actual->bind_param("i", $id_alumno);
$stmt_actual->execute();
$result_actual = $stmt_actual->get_result();
if ($result_actual->num_rows > 0) {
    $row_actual = $result_actual->fetch_assoc();
    $id_clase_actual = $row_actual['id_clase'];
    $nombre_clase_actual = $row_actual['nombre_clase'];
} else {
    die("No se encontraron clases asignadas para este alumno.");
}
$stmt_actual->close();

// Obtener todas las clases disponibles para el cambio
$sql_clases_disponibles = "SELECT id_clase, nombre_clase FROM clases WHERE id_clase != ?";
$stmt_clases_disponibles = $conn->prepare($sql_clases_disponibles);
if ($stmt_clases_disponibles === false) {
    die("Error en la preparación de la consulta de clases disponibles: " . $conn->error);
}
$stmt_clases_disponibles->bind_param("i", $id_clase_actual);
$stmt_clases_disponibles->execute();
$result_clases_disponibles = $stmt_clases_disponibles->get_result();
$stmt_clases_disponibles->close();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambio de Clase</title>
    <link rel="stylesheet" href="../CSS/sesion.css">
    <link rel="stylesheet" href="../CSS/main.css">
    <link rel="stylesheet" href="../CSS/forms.css">
    <link rel="stylesheet" href="../CSS/details.css">
</head>

<header>
    <div class="container">
        <h1>Bienvenido, <?php echo htmlspecialchars($nombre_usuario); ?></h1>
    </div>
</header>

<body>
    <center>
        <div class="container-form">
            <h2>Cambio de Clase</h2>
            <h3>Clase Actual: <?php echo htmlspecialchars($nombre_clase_actual); ?></h3>
            <?php if (isset($mensaje)) : ?>
                <p><?php echo htmlspecialchars($mensaje); ?></p>
            <?php endif; ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="id_nueva_clase">Selecciona una nueva clase:</label>
                <select name="id_nueva_clase" id="id_nueva_clase" required>
                    <?php while ($row = $result_clases_disponibles->fetch_assoc()) : ?>
                        <option value="<?php echo htmlspecialchars($row['id_clase']); ?>"><?php echo htmlspecialchars($row['nombre_clase']); ?></option>
                    <?php endwhile; ?>
                </select>
                <button type="submit">Cambiar Clase</button>
            </form>
        </div>
    </center>
    <a href="../inicio.php">Volver al Panel</a>
</body>

</html>
<?php
// Cerrar la conexión
$conn->close();
?>