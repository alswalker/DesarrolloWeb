<?php
// Configuración de la conexión a la base de datos
$servername = "crudbddv2.mysql.database.azure.com";
$username = "alswalker";
$password = "@dministrad0r";
$database = "test";

// Crear conexión sin SSL
$conn = new mysqli($servername, $username, $password, $database, 3306);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Establecer el conjunto de caracteres a UTF-8
$conn->set_charset("utf8");
?>
