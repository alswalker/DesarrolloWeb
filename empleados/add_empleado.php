<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $fecha_nac = $_POST['fecha_nac'];
    $id_puesto = $_POST['id_puesto'];
    $id_tienda = $_POST['id_tienda'];
    $salario = $_POST['salario'];

    // Manejo de la subida de la imagen
    $fotografia = null;
    if (isset($_FILES['fotografia']) && $_FILES['fotografia']['tmp_name']) {
        $fotografia = file_get_contents($_FILES['fotografia']['tmp_name']);
    }

    // Preparamos la consulta al procedimiento almacenado
    $stmt = $conn->prepare("CALL spinsertarempleado(?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('ssssiii', $nombres, $apellidos, $fecha_nac, $fotografia, $id_puesto, $id_tienda, $salario);

    // Ejecutamos la consulta
    if ($stmt->execute()) {
        echo "Empleado agregado correctamente.";
        header("Location: empleados.php"); // Redirigir después de la inserción
    } else {
        echo "Error al agregar empleado.";
    }

    $stmt->close();
    $conn->close();
}
?>
