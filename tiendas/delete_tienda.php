<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_tienda = $_POST['id_tienda'];

    $stmt = $conn->prepare("CALL speliminatienda(?)");
    $stmt->bind_param('i', $id_tienda);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Tienda eliminada correctamente.";
    } else {
        echo "Error al eliminar la tienda.";
    }

    $stmt->close();
    $conn->close();
}
?>
