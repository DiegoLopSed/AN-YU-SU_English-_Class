<?php
// Incluir archivo de conexión a la base de datos
require_once 'connection.php';

session_start(); // Iniciar sesión

// Verificar si se enviaron datos por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];
    $_SESSION['loggedin'] = true;
    $_SESSION['email'] = $email;

    // Encriptar la contraseña usando MD5 (ejemplo, usar métodos más seguros en producción)
    $contraseña_encriptada = md5($contraseña);

    // Consultar en la tabla de alumnos
    $sql_alumnos = "SELECT * FROM alumnos WHERE email = '$email' AND contraseña = '$contraseña_encriptada'";
    $result_alumnos = $conn->query($sql_alumnos);

    // Consultar en la tabla de maestros
    $sql_maestros = "SELECT * FROM profesores WHERE email = '$email' AND contraseña = '$contraseña_encriptada'";
    $result_maestros = $conn->query($sql_maestros);

    // Verificar si el usuario es un alumno
    if ($result_alumnos->num_rows > 0) {
        $row = $result_alumnos->fetch_assoc();
        $_SESSION['tipo_usuario'] = 'alumno';
        $_SESSION['id_usuario'] = $row['id_alumno'];
        $_SESSION['nombre_usuario'] = $row['nombre'];
        $_SESSION['apellido_usuario'] = $row['apellido'];
        $_SESSION['email_usuario'] = $row['email'];
        header('Location: ../../inicio.php'); // Redirigir a la página de inicio de alumnos
        exit;
    }

    // Verificar si el usuario es un maestro
    elseif ($result_maestros->num_rows > 0) {
        $row = $result_maestros->fetch_assoc();
        $_SESSION['tipo_usuario'] = 'maestro';
        $_SESSION['id_usuario'] = $row['id_profesor'];
        $_SESSION['nombre_usuario'] = $row['nombre'];
        $_SESSION['apellido_usuario'] = $row['apellido'];
        $_SESSION['email_usuario'] = $row['email'];
        header('Location: ../../inicio.php'); // Redirigir a la página de inicio de maestros
        exit;
    } else {
        echo "<script>alert('Usuario o contraseña incorrectos o usuario no encontrado.'); window.location.href = '../../index.html';</script>";
    }
}

// Cerrar conexión
$conn->close();
