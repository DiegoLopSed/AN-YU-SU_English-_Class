<?php
//? Incluir archivo de conexión a la base de datos para no tener todo en un solo archivo
require_once 'connection.php';


//! Verificar si se enviaron datos por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //! Obtenemos los datos del formulario y los guardamos en variables
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $edad = $_POST['edad'];
    $id_clase = $_POST['id_clase'];
    $contraseña = $_POST['contraseña'];

    //! Encriptar la contraseña usando MD5 para mayor seguridad
    $contraseña_encriptada = md5($contraseña);

    //? $sql sirve para hacer la inserccion de los datos en la BD
    $sql = "INSERT INTO alumnos (nombre, apellido, email, edad, id_clase, contraseña)
            VALUES ('$nombre', '$apellido','$email','$edad','$id_clase', '$contraseña_encriptada')";
    
    if ($conn->query($sql) === TRUE) {
        //!Si se registro correctamente mandar un alert
        echo "<script>
                setTimeout(function() {
                    alert('¡Registro exitoso!');
                    window.location.href = '../../index.html';
                }, 500); 
              </script>";
        
        exit; //? Termina la función cuando se registre
    } else {
        //?Mensaje de error por si no logra conectar
        echo "Error al registrar alumno: " . $conn->error;
    }

    //! Cerrar conexión con la BD por seguridad
    $conn->close();
}
