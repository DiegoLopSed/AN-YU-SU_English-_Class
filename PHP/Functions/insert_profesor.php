<?php
//? Incluir archivo de conexión a la base de datos
require_once 'connection.php';


//! Verificar si se enviaron datos por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //? Obtener datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $edad = $_POST['edad'];
    $nivel_ingles = $_POST['nivel_ingles'];
    $contraseña = $_POST['contraseña'];

    //! Encriptar la contraseña usando MD5
    $contraseña_encriptada = md5($contraseña);

    //! Preparar la consulta SQL para insertar un nuevo profesor
    $sql = "INSERT INTO profesores (nombre, apellido, email, edad, nivel_ingles, contraseña) 
            VALUES ('$nombre', '$apellido', '$email', '$edad', '$nivel_ingles', '$contraseña_encriptada')";

if ($conn->query($sql) === TRUE) {
    echo "<script>
            setTimeout(function() {
                alert('¡Registro exitoso!');
                window.location.href = '../../index.html';
            }, 2000); 
          </script>";
    
    exit;
} else {
    echo "Error al registrar alumno: " . $conn->error;
}

    //! Cerrar conexión
    $conn->close();
}
