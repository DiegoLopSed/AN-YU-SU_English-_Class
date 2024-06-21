<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../PHP/Functions/login.php'); // Redirige a la página de login si no hay sesión
    exit;
}

$tipo_usuario = $_SESSION['tipo_usuario'];
$id_usuario = $_SESSION['id_usuario'];
$nombre_usuario = $_SESSION['nombre_usuario'];
$email_usuario = $_SESSION['email_usuario'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="CSS/sesion.css">
    <link rel="stylesheet" href="CSS/main.css">
    <link rel="stylesheet" href="CSS/modal.css">
    <link rel="stylesheet" href="CSS/panels.css">

</head>

<body>
    <header>
        <div class="container">
            <h1>Bienvenido, <?php echo htmlspecialchars($nombre_usuario); ?></h1>
            <nav>
                <ul class="nav-links">
                    <li class="dropdown">
                        <a href="javascript:void(0)" class="dropbtn">Usuario</a>
                        <div class="dropdown-content">
                            <p>ID de usuario: <?php echo htmlspecialchars($id_usuario); ?></p>
                            <p>Tipo de usuario: <?php echo htmlspecialchars($tipo_usuario); ?></p>
                            <p>Email: <?php echo htmlspecialchars($email_usuario); ?></p>
                            <a href="PHP/Functions/logout.php">Cerrar sesión</a>
                        </div>
                    </li>
                    <li><a href="PHP_Users/editar_perfil.php">Editar Perfil</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <center>
        <main class="main-content">
            <br><br><br><br><br><br>
            <?php if ($tipo_usuario == 'alumno') : ?>
                <div class="panel">
                    <h2>Panel de Alumno</h2>
                    <div class="teacher-panel">
                        <a href="PHP_Users/clase_alumno.php" class="panel-item">Ver clases</a>
                        <a href="PHP_Users/cambiar_clase.php" class="panel-item">Cambiar Clase</a>
                    </div>
                </div>
            <?php elseif ($tipo_usuario == 'maestro') : ?>
                <div class="panel">
                    <h2>Panel de Profesor</h2>
                    <div class="teacher-panel">
                        <a href="#" id="crearClaseBtn" class="panel-item">Crear clase</a>
                        <a href="PHP_Users/ver_clases.php" class="panel-item">Revisar clase</a>
                        <a href="PHP_Users/ver_alumnos.php" class="panel-item">Revisar alumnos</a>

                    </div>
                </div>
            <?php endif; ?>
        </main>
    </center>


    <div id="crearClaseModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Crear Nueva Clase</h2>
            <form action="PHP_Users/crear_clase.php" method="post">
                <label for="nombre_clase">Nombre de la Clase:</label><br>
                <input type="text" id="nombre_clase" name="nombre_clase" required><br>
                <input type="submit" value="Crear Clase">
            </form>
        </div>
    </div>

    <script>
        // Modal script
        var modal = document.getElementById("crearClaseModal");
        var btn = document.getElementById("crearClaseBtn");
        var span = document.getElementsByClassName("close")[0];

        btn.onclick = function() {
            modal.style.display = "block";
        }
        span.onclick = function() {
            modal.style.display = "none";
        }
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Desactivar botón de retroceso
        history.pushState(null, null, location.href);
        window.onpopstate = function() {
            history.go(1);
        };
    </script>
</body>

</html>