<?php
//* Datos de conexión a la base de datos
$servername = "localhost"; //? Nombre del servidor
$username = "root"; //? Nombre del usuario
$password = ""; //? Contraseña 
$dbname = "prueba1"; //? Nombre de la BD
//anyusu_english

//* Crear conexión a la BD
$conn = new mysqli($servername, $username, $password, $dbname);

//! Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

//! Hacer que $conn sea accesible globalmente
global $conn;
