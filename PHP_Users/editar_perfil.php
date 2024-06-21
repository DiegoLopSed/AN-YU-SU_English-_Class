<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../PHP/Functions/login.php'); // Redirige a la página de login si no hay sesión
    exit;
}

$tipo_usuario = $_SESSION['tipo_usuario'];
$id_usuario = $_SESSION['id_usuario'];
$nombre_usuario = $_SESSION['nombre_usuario'];
$apellido_usuario = $_SESSION['apellido_usuario']; // Nuevo campo para el apellido
$email_usuario = $_SESSION['email_usuario'];

// Incluir la conexión a la base de datos
include '../PHP/Functions/connection.php';

if (!isset($conn)) {
    die("Error: No se pudo conectar a la base de datos.");
}

// Procesar la actualización del perfil
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nuevo_nombre = $conn->real_escape_string($_POST['nombre_usuario']);
    $nuevo_apellido = $conn->real_escape_string($_POST['apellido_usuario']); // Nuevo campo para el apellido
    $nuevo_email = $conn->real_escape_string($_POST['email_usuario']);

    if ($tipo_usuario == "alumno") {
        // Actualizar la información del usuario
        $sql = "UPDATE alumnos SET nombre='$nuevo_nombre', apellido='$nuevo_apellido', email='$nuevo_email' WHERE id_alumno='$id_usuario'";
    } else if ($tipo_usuario == "maestro") {
        $sql = "UPDATE profesores SET nombre='$nuevo_nombre', apellido='$nuevo_apellido', email='$nuevo_email' WHERE id_profesor='$id_usuario'";
    }

    if ($conn->query($sql) === TRUE) {
        // Actualizar las variables de sesión
        $_SESSION['nombre_usuario'] = $nuevo_nombre;
        $_SESSION['apellido_usuario'] = $nuevo_apellido; // Actualizar el apellido en la sesión
        $_SESSION['email_usuario'] = $nuevo_email;
        echo "<script>alert('Perfil actualizado exitosamente.'); window.location.href = '../inicio.php';</script>";
    } else {
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="../CSS/main.css">
    <link rel="stylesheet" href="../CSS/forms.css">
</head>

<body>
    <header>
        <div class="container">
            <h1>Editar Perfil</h1>
        </div>
    </header>
    <main>
        <center>
            <div class="container-perfil">
                <form action="editar_perfil.php" method="post">
                    <label for="nombre_usuario">Nombre:</label><br>
                    <input type="text" id="nombre_usuario" name="nombre_usuario" value="<?php echo htmlspecialchars($nombre_usuario); ?>" required><br>
                    <label for="apellido_usuario">Apellido:</label><br>
                    <input type="text" id="apellido_usuario" name="apellido_usuario" value="<?php echo htmlspecialchars($apellido_usuario); ?>" required><br>
                    <label for="email_usuario">Email:</label><br>
                    <input type="email" id="email_usuario" name="email_usuario" value="<?php echo htmlspecialchars($email_usuario); ?>" required><br>
                    <input type="submit" value="Actualizar Perfil">
                </form>
                <br>
            </div>
            <a href="../inicio.php" class="minimal-link">Volver a la página principal</a>
        </center>
    </main>
</body>

</html>