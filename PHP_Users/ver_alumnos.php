<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    die("Acceso denegado. Por favor, inicia sesión.");
}

// Datos de conexión a la base de datos
include('../PHP/Functions/connection.php');

// Obtener el id del profesor desde la sesión
$id_profesor = $_SESSION['id_usuario'];
$tipo_usuario = $_SESSION['tipo_usuario'];
$id_usuario = $_SESSION['id_usuario'];
$nombre_usuario = $_SESSION['nombre_usuario'];
$email_usuario = $_SESSION['email_usuario'];

// Preparar y ejecutar la consulta SQL para obtener las clases asignadas al profesor
$sql_clases = "SELECT id_clase, nombre_clase FROM clases WHERE id_profesor = ?";
$stmt_clases = $conn->prepare($sql_clases);
if ($stmt_clases === false) {
    die("Error en la preparación de la declaración: " . $conn->error);
}

// Vincular el id_profesor como parámetro y ejecutar la declaración
$stmt_clases->bind_param("i", $id_profesor);
$stmt_clases->execute();

// Obtener el resultado
$result_clases = $stmt_clases->get_result();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Alumnos de Clases Asignadas</title>
    <link rel="stylesheet" href="../CSS/sesion.css">
    <link rel="stylesheet" href="../CSS/main.css">
    <link rel="stylesheet" href="../CSS/tables2.css">
</head>

<header>
    <div class="container">
        <h1>Bienvenido, <?php echo htmlspecialchars($nombre_usuario); ?></h1>
    </div>
</header>

<body>
    <br><br><br>
    <div class="container-table">
        <h2>Alumnos de Clases Asignadas</h2>
        <?php
        // Verificar si se encontraron resultados
        if ($result_clases->num_rows > 0) {
            // Recorrer las clases y obtener los alumnos de cada clase
            while ($clase = $result_clases->fetch_assoc()) {
                echo "<h3>" . htmlspecialchars($clase['nombre_clase']) . "</h3>";

                // Preparar y ejecutar la consulta SQL para obtener los alumnos de la clase actual
                $sql_alumnos = "SELECT id_alumno, nombre, apellido, email 
                                FROM alumnos 
                                WHERE id_clase = ?";
                $stmt_alumnos = $conn->prepare($sql_alumnos);
                if ($stmt_alumnos === false) {
                    die("Error en la preparación de la declaración: " . $conn->error);
                }

                // Vincular el id_clase como parámetro y ejecutar la declaración
                $stmt_alumnos->bind_param("i", $clase['id_clase']);
                $stmt_alumnos->execute();

                // Obtener el resultado
                $result_alumnos = $stmt_alumnos->get_result();

                // Mostrar los alumnos en una tabla
                echo "<table>";
                echo "<tr><th>ID Alumno</th><th>Nombre del Alumno</th><th>Apellido del Alumno</th><th>Email del Alumno</th></tr>";

                if ($result_alumnos->num_rows > 0) {
                    // Recorrer los resultados y mostrarlos en la tabla
                    while ($alumno = $result_alumnos->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($alumno['id_alumno']) . "</td>";
                        echo "<td>" . htmlspecialchars($alumno['nombre']) . "</td>";
                        echo "<td>" . htmlspecialchars($alumno['apellido']) . "</td>";
                        echo "<td>" . htmlspecialchars($alumno['email']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No se encontraron alumnos en esta clase.</td></tr>";
                }
                echo "</table>";

                // Cerrar la declaración de alumnos
                $stmt_alumnos->close();
            }
        } else {
            echo "<p>No se encontraron clases asignadas.</p>";
        }
        ?>
        <a href="../inicio.php">Volver al Panel</a>
    </div>
</body>

</html>
<?php
// Cerrar la declaración y la conexión de clases
$stmt_clases->close();
$conn->close();
?>
