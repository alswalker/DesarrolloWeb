<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_empleado = $_POST['id_empleado'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $fecha_nac = $_POST['fecha_nac'];
    $id_puesto = $_POST['id_puesto'];
    $id_tienda = $_POST['id_tienda'];
    $salario = $_POST['salario'];
    
    // Verificar si hay una nueva imagen cargada
    if (isset($_FILES['fotografia']) && $_FILES['fotografia']['tmp_name']) {
        $fotografia = file_get_contents($_FILES['fotografia']['tmp_name']);
        $stmt = $conn->prepare("UPDATE empleados SET nombres=?, apellidos=?, fecha_nac=?, fotografia=?, id_puesto=?, id_tienda=?, salario=? WHERE id_empleado=?");
        $stmt->bind_param("ssssiiid", $nombres, $apellidos, $fecha_nac, $fotografia, $id_puesto, $id_tienda, $salario, $id_empleado);
    } else {
        // Si no se subió una nueva imagen, no actualizar la columna de la fotografía
        $stmt = $conn->prepare("UPDATE empleados SET nombres=?, apellidos=?, fecha_nac=?, id_puesto=?, id_tienda=?, salario=? WHERE id_empleado=?");
        $stmt->bind_param("sssiiid", $nombres, $apellidos, $fecha_nac, $id_puesto, $id_tienda, $salario, $id_empleado);
    }

    if ($stmt->execute()) {
        echo "Empleado actualizado correctamente.";
    } else {
        echo "Error al actualizar empleado: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Método no permitido.";
}
?>
