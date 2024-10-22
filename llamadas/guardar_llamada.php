<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $descripcion = $_POST['descripcion'];
    $tipo_logro = $_POST['tipo_logro'];
    $fecha_ocurrencia = $_POST['fecha_ocurrencia'];
    $id_empleado = $_POST['id_empleado'];

    // Preparamos la llamada al procedimiento almacenado
    $stmt = $conn->prepare("CALL spinsertaratencion(?, ?, ?, ?)");
    $stmt->bind_param("sssi", $descripcion, $tipo_logro, $fecha_ocurrencia, $id_empleado);

    if ($stmt->execute()) {
        echo "Registro exitoso.";
        header("Location: listado_llamadas.php"); // Redirigir al listado de llamadas
        exit();
    } else {
        echo "Error al registrar la llamada de atención o logro.";
    }

    $stmt->close();
    $conn->close();
}
?>
