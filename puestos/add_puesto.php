<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $puesto = $_POST['puesto'];

    $stmt = $conn->prepare("CALL spinsertapuesto(?)");
    $stmt->bind_param('s', $puesto);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Puesto agregado correctamente.";
    } else {
        echo "Error al agregar el puesto.";
    }

    $stmt->close();
    $conn->close();
}
?>
