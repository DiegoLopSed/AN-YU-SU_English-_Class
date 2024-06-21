<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    die("Acceso denegado. Por favor, inicia sesión.");
}

// Datos de conexión a la base de datos
include('../PHP/Functions/connection.php');

$id_usuario_sesion = $_SESSION['id_usuario'];
$tipo_usuario = $_SESSION['tipo_usuario'];

// Variable para el mensaje de alerta
$alert_message = "";

// Verificar si se ha enviado el formulario para eliminar el usuario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Solo se puede eliminar el perfil del usuario en sesión
    if ($tipo_usuario == 'alumno') {
        // Eliminar alumno
        $tabla = "alumnos";
        $columna_id = "id_alumno";
    }else {
        die("Tipo de usuario no válido.");
    }

    // Consulta SQL para eliminar el usuario en sesión
    $sql = "DELETE FROM $tabla WHERE $columna_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error en la preparación de la declaración: " . $conn->error);
    }
    $stmt->bind_param("i", $id_usuario_sesion);
    if ($stmt->execute()) {
        // Si se elimina correctamente, destruir la sesión actual
        session_unset();
        session_destroy();
        $alert_message = "Tu perfil ha sido eliminado correctamente.";
        // Redireccionar a la página de login después de mostrar el alert
        echo '<script>alert("' . $alert_message . '"); window.location.href = "../index.html";</script>';
        exit();
    } else {
        $alert_message = "Error al eliminar tu perfil: " . $stmt->error;
    }
    $stmt->close();
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Usuario</title>
    <link rel="stylesheet" href="../CSS/sesion.css">
    <link rel="stylesheet" href="../CSS/main.css">
</head>

<header>
    <div class="container">
        <h1>Panel de Administración</h1>
    </div>
</header>

<body>
    <center>
    <div class="container-form">
        <h2>Eliminar Usuario</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <p>¿Estás seguro que deseas eliminar tu perfil?</p>
            <button type="submit">Eliminar Perfil</button>
        </form>
    </div>
    </center>
</body>

</html>
<?php
// Cerrar la conexión
$conn->close();
?>
