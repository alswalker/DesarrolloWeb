<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_tienda = $_POST['id_tienda'];
    $tienda = $_POST['tienda'];
    $direccion = $_POST['direccion'];
    $jefe = $_POST['jefe'];

    $stmt = $conn->prepare("CALL speditatienda(?, ?, ?, ?)");
    $stmt->bind_param('isss', $id_tienda, $tienda, $direccion, $jefe);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Tienda actualizada correctamente.";
    } else {
        echo "Error al actualizar la tienda.";
    }

    $stmt->close();
    $conn->close();
}
?>
