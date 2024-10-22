<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tienda = $_POST['tienda'];
    $direccion = $_POST['direccion'];
    $jefe = $_POST['jefe'];

    $stmt = $conn->prepare("CALL spinsertatienda(?, ?, ?)");
    $stmt->bind_param('sss', $tienda, $direccion, $jefe);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Tienda agregada correctamente.";
    } else {
        echo "Error al agregar la tienda.";
    }

    $stmt->close();
    $conn->close();
}
?>
