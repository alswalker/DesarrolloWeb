<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_puesto = $_POST['id_puesto'];

    // Preparamos la llamada al procedimiento almacenado
    $stmt = $conn->prepare("CALL speliminapuesto(?)");
    $stmt->bind_param('i', $id_puesto);
    $stmt->execute();

    // Verificamos si la operación fue exitosa
    if ($stmt->affected_rows > 0) {
        echo "Puesto eliminado correctamente.";
    } else {
        echo "Error al eliminar el puesto.";
    }

    // Cerramos la conexión y el statement
    $stmt->close();
    $conn->close();
}
?>
