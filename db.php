<?php
// Configuraci�n de la conexi�n a la base de datos
$servername = "crudbddv2.mysql.database.azure.com";
$username = "alswalker";
$password = "@dministrad0r";
$database = "test";

// Crear conexi�n sin SSL
$conn = new mysqli($servername, $username, $password, $database, 3306);

// Verificar la conexi�n
if ($conn->connect_error) {
    die("Error de conexi�n: " . $conn->connect_error);
}

// Establecer el conjunto de caracteres a UTF-8
$conn->set_charset("utf8");
?>
