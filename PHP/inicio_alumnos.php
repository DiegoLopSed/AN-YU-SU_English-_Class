<?php
//! Incluir archivo de conexión a la base de datos
require_once 'Functions/connection.php';

//* Consulta SQL para obtener todos los alumnos con información de la clase
$sql = "SELECT alumnos.*, clases.nombre_clase AS nombre_clase
        FROM alumnos
        INNER JOIN clases ON alumnos.id_clase = clases.id_clase";

$result = $conn->query($sql);

//? Verificar si hay resultados
if ($result->num_rows > 0) {
    //? Iniciar a imprimir la tabla HTML
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Listado de Alumnos</title>
        <link rel="stylesheet" href="../CSS/tables.css">
    </head>
    <body>
        <h2>Listado de Alumnos con Información de la Clase</h2>
        <table>
            <tr>
                <th>ID Alumno</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Edad</th>
                <th>ID Clase</th>
                <th>Nombre Clase</th>
                
            </tr>';

    //? Mostrar sobre cada fila de resultados
    while($row = $result->fetch_assoc()) {
        echo '<tr>
                <td>'.$row['id_alumno'].'</td>
                <td>'.$row['nombre'].'</td>
                <td>'.$row['apellido'].'</td>
                <td>'.$row['email'].'</td>
                <td>'.$row['edad'].'</td>
                <td>'.$row['id_clase'].'</td>
                <td>'.$row['nombre_clase'].'</td>
              </tr>';
    }

    //! Cerrar la tabla HTML
    echo '</table>
          </body>
          </html>';

} else {
    echo "No se encontraron alumnos registrados.";
}

//! Cerrar conexión
$conn->close();
