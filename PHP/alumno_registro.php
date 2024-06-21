<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Profesor</title>
    <link rel="stylesheet" href="../CSS/main.css">
    <link rel="stylesheet" href="../CSS/forms.css">
</head>
<header>
    <div class="container">
        <h1>Bienvenidos a ANYUSU</h1>
        <nav>
            <ul>
                <li><a href="../index.html">Inicio</a></li>
                <li><a href="profesor_registro.html">Registrarse Prof.</a></li>
                <li><a href="lista_clases.php">Clases</a></li>
                  
            </ul>
        </nav>
    </div>
</header>

<main>
    <div class="container">
        <h2>Registrate como alumno</h2>
        <p>Registrate como alumno y selecciona la clase de interes según el tema de
            interes que se adecue a tus espectativas y deseos de aprender inglés.</p>
    </div>
</main>

<body>
    <center>

        <form action="Functions/insert_alumno.php" method="post">
            <h2>Crear Nuevo Alumno</h2>
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required><br>

            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="edad">Edad:</label>
            <input type="number" id="edad" name="edad" required><br>

            <label for="id_clase">Clase:</label>
            <select id="id_clase" name="id_clase" required>
                <?php
                include 'Functions/connection.php';

                //* Consultar las clases y los profesores
                $sql = "SELECT clases.id_clase, clases.nombre_clase, profesores.nombre AS nombre_profesor, profesores.apellido AS apellido_profesor 
                    FROM clases 
                    JOIN profesores ON clases.id_profesor = profesores.id_profesor";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["id_clase"] . "'>" . $row["nombre_clase"] . " - " . $row["nombre_profesor"] . " " . $row["apellido_profesor"] . "</option>";
                    }
                } else {
                    echo "<option value=''>No hay clases disponibles</option>";
                }

                $conn->close();
                ?>
            </select>

            <label for="contraseña">Contraseña:</label>
            <input type="password" id="contraseña" name="contraseña" required><br>

            <input type="submit" value="Crear Alumno">
        </form>
    </center>
</body>
<br><br>
<footer>
    <div class="container">
        <p>&copy; 2024 AN-YU-SU. Todos los derechos reservados.</p>
    </div>
</footer>

</html>