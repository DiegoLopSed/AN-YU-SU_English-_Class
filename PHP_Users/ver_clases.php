<?php
session_start();

//! Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    die("Acceso denegado. Por favor, inicia sesión.");
}

//! Datos de conexión a la base de datos
include('../PHP/Functions/connection.php');

//? Obtener el id del profesor desde la sesión
$id_profesor = $_SESSION['id_usuario'];
$tipo_usuario = $_SESSION['tipo_usuario'];
$id_usuario = $_SESSION['id_usuario'];
$nombre_usuario = $_SESSION['nombre_usuario'];
$email_usuario = $_SESSION['email_usuario'];

//* Preparar y ejecutar la consulta SQL para obtener las clases asignadas al profesor
$sql = "SELECT id_clase, nombre_clase FROM clases WHERE id_profesor = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error en la preparación de la declaración: " . $conn->error);
}

//* Vincular el id_profesor como parámetro y ejecutar la declaración
$stmt->bind_param("i", $id_profesor);
$stmt->execute();

//! Obtener el resultado
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Clases Asignadas</title>
    <link rel="stylesheet" href="../CSS/sesion.css">
    <link rel="stylesheet" href="../CSS/main.css">
    <link rel="stylesheet" href="../CSS/tables.css">
</head>

<header>
    <div class="container">
        <h1>Bienvenido, <?php echo htmlspecialchars($nombre_usuario); ?></h1>
        <nav>
            <ul class="nav-links">
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropbtn">Usuario</a>
                    <div class="dropdown-content">
                        <p>ID de usuario: <?php echo htmlspecialchars($id_usuario); ?></p>
                        <p>Tipo de usuario: <?php echo htmlspecialchars($tipo_usuario); ?></p>
                        <p>Email: <?php echo htmlspecialchars($email_usuario); ?></p>
                        <a href="PHP/Functions/logout.php">Cerrar sesión</a>
                    </div>
                </li>
                <li><a href="#home">Editar Perfil</a></li>
            </ul>
        </nav>
    </div>
</header>

<body>
    <br><br><br>
    <div class="container-table">
        <h2>Clases Asignadas</h2>
        <table>
            <tr>
                <th>ID Clase</th>
                <th>Nombre de la Clase</th>
            </tr>
            <?php
            // Verificar si se encontraron resultados
            if ($result->num_rows > 0) {
                // Recorrer los resultados y mostrarlos en la tabla
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id_clase']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nombre_clase']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No se encontraron clases asignadas.</td></tr>";
            }
            ?>
        </table>

        <a href="../inicio.php">Volver al Panel</a>
</body>


</html>
<?php
//! Cerrar la conexión
$stmt->close();
$conn->close();
?>