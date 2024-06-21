<?php
//! Incluir archivo de conexión a la base de datos
require_once 'Functions/connection.php';

//* Consulta SQL para obtener todos los profesores
$sql = "SELECT * FROM profesores";
$result = $conn->query($sql);

//! Verificar si hay resultados
if ($result->num_rows > 0) {
    //? Iniciar a imprimir la tabla HTML
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Listado de Profesores</title>
        <link rel="stylesheet" href="../CSS/tables.css">
    </head>
    <body>
        <h2>Listado de Profesores Registrados</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Edad</th>
                <th>English level</th>
                <!-- Agrega más campos según tu estructura de base de datos -->
            </tr>';

    //? Mostrar sobre cada fila de resultados
    while($row = $result->fetch_assoc()) {
        echo '<tr>
                <td>'.$row['id_profesor'].'</td>
                <td>'.$row['nombre'].'</td>
                <td>'.$row['email'].'</td>
                <td>'.$row['edad'].'</td>
                <td>'.$row['nivel_ingles'].'</td>
                <!-- Agrega más celdas según tu estructura de base de datos -->
              </tr>';
    }

    //? Cerrar la tabla HTML
    echo '</table>
          </body>
          </html>';

} else {
    echo "No se encontraron profesores registrados.";
}

//! Cerrar conexión
$conn->close();