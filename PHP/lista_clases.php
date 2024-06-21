<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clases Registradas</title>
    <link rel="stylesheet" href="../CSS/main.css">
    <link rel="stylesheet" href="../CSS/forms.css">
    <link rel="stylesheet" href="../CSS/tables.css">
</head>
<header>
    <div class="container">
        <h1>Bienvenidos a ANYUSU</h1>
        <nav>
            <ul>
                <li><a href="../index.html">Inicio</a></li>
                <li><a href="profesor_registro.html">Registrarse Prof.</a></li>
                <li><a href="alumno_registro.php">Registrarse Alumn.</a></li>
                  
            </ul>
        </nav>
    </div>
</header>

<main>
    <div class="container">
        <h2>Conoce que clases estan dadas de alta</h2>
        <p>Escoge de las clases en lista que se adecue a tus necesidades
            y realiza tu registro como alumno en la pagina de Registrar Alum.</p>
    </div>
</main>

<body>
    <center>
        <div class="container-table">
            <h2>Lista de Clases</h2>
            <table border="1">
                <tr>
                    <th>Nombre de la Clase</th>
                    <th>Profesor</th>
                </tr>
                <?php
                //! Incluir el archivo de conexión a la base de datos
                include 'Functions/connection.php';

                //* Consulta SQL para obtener las clases y los profesores que las imparten
                $sql = "SELECT clases.nombre_clase, profesores.nombre AS nombre_profesor, profesores.apellido AS apellido_profesor 
                        FROM clases 
                        JOIN profesores ON clases.id_profesor = profesores.id_profesor";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    //! Mostrar los datos de cada fila
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["nombre_clase"] . "</td>
                                <td>" . $row["nombre_profesor"] . " " . $row["apellido_profesor"] . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No hay clases disponibles</td></tr>";
                }

                //! Cerrar la conexión
                $conn->close();
                ?>
            </table>
        </div>
    </center>
</body>
<br><br>
<footer>
    <div class="container">
        <p>&copy; 2024 AN-YU-SU. Todos los derechos reservados.</p>
    </div>
</footer>

</html>