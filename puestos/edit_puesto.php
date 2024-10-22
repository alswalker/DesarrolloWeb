<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_puesto = $_POST['id_puesto'];
    $puesto = $_POST['puesto'];

    $stmt = $conn->prepare("CALL speditapuesto(?, ?)");
    $stmt->bind_param('is', $id_puesto, $puesto);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Puesto actualizado correctamente.";
    } else {
        echo "Error al actualizar el puesto.";
    }

    $stmt->close();
    $conn->close();
}
?>
