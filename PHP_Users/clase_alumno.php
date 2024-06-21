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
$tipo_usuario = $_SESSION['tipo_usuario'];
$id_usuario = $_SESSION['id_usuario'];
$nombre_usuario = $_SESSION['nombre_usuario'];
$email_usuario = $_SESSION['email_usuario'];

// Preparar y ejecutar la consulta SQL para obtener los datos del alumno, la clase y el profesor
$sql = "SELECT a.id_alumno, a.nombre AS nombre_alumno, a.apellido AS apellido_alumno, a.email AS email_alumno, a.edad AS edad_alumno,
               cl.id_clase, cl.nombre_clase, 
               p.id_profesor, p.nombre AS nombre_profesor, p.apellido AS apellido_profesor, p.email AS email_profesor, p.edad AS edad_profesor, p.nivel_ingles AS nivel_ingles_profesor
        FROM alumnos a
        INNER JOIN clases cl ON a.id_clase = cl.id_clase
        INNER JOIN profesores p ON cl.id_profesor = p.id_profesor
        WHERE a.id_alumno = ?";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error en la preparación de la declaración: " . $conn->error);
}

// Vincular el id_alumno como parámetro y ejecutar la declaración
$stmt->bind_param("i", $id_alumno);
$stmt->execute();

// Obtener el resultado
$result = $stmt->get_result();

// Obtener los datos del resultado
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id_alumno = $row['id_alumno'];
    $nombre_alumno = $row['nombre_alumno'];
    $apellido_alumno = $row['apellido_alumno'];
    $email_alumno = $row['email_alumno'];
    $edad_alumno = $row['edad_alumno'];
    $id_clase = $row['id_clase'];
    $nombre_clase = $row['nombre_clase'];
    $id_profesor = $row['id_profesor'];
    $nombre_profesor = $row['nombre_profesor'];
    $apellido_profesor = $row['apellido_profesor'];
    $email_profesor = $row['email_profesor'];
    $edad_profesor = $row['edad_profesor'];
    $nivel_ingles_profesor = $row['nivel_ingles_profesor'];
} else {
    die("No se encontraron datos para el alumno.");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Alumno, Clase y Profesor</title>
    <link rel="stylesheet" href="../CSS/sesion.css">
    <link rel="stylesheet" href="../CSS/main.css">
    <link rel="stylesheet" href="../CSS/details.css"> 
    
</head>

<header>
    <div class="container">
        <h1>Bienvenido, <?php echo htmlspecialchars($nombre_usuario); ?></h1>
    </div>
</header>

<body>
    <div class="container-details">
        <h2>Detalles del Alumno, Clase y Profesor</h2>
        <div class="details">
            <h3>Datos del Alumno</h3>
            <p>ID de alumno: <?php echo htmlspecialchars($id_alumno); ?></p>
            <p>Nombre: <?php echo htmlspecialchars($nombre_alumno . ' ' . $apellido_alumno); ?></p>
            <p>Email: <?php echo htmlspecialchars($email_alumno); ?></p>
            <p>Edad: <?php echo htmlspecialchars($edad_alumno); ?></p>
        </div>
        <div class="details">
            <h3>Datos de la Clase</h3>
            <p>ID de clase: <?php echo htmlspecialchars($id_clase); ?></p>
            <p>Nombre de la Clase: <?php echo htmlspecialchars($nombre_clase); ?></p>
        </div>
        <div class="details">
            <h3>Datos del Profesor</h3>
            <p>ID de profesor: <?php echo htmlspecialchars($id_profesor); ?></p>
            <p>Nombre del Profesor: <?php echo htmlspecialchars($nombre_profesor . ' ' . $apellido_profesor); ?></p>
            <p>Email del Profesor: <?php echo htmlspecialchars($email_profesor); ?></p>
            <p>Edad del Profesor: <?php echo htmlspecialchars($edad_profesor); ?></p>
            <p>Nivel de inglés del Profesor: <?php echo htmlspecialchars($nivel_ingles_profesor); ?></p>
        </div>
    </div>
    <a href="../inicio.php">Volver al Panel</a>
</body>

</html>
<?php
// Cerrar la declaración y la conexión
$stmt->close();
$conn->close();
?>
