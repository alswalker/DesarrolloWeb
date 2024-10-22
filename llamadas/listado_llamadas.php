<?php
include '../db.php';

// Llamada al procedimiento almacenado para obtener las llamadas de atención
$result = $conn->query("CALL spconsultaratencion();");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Llamadas de Atención y Logros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<?php include '../navbar.php'; ?> <!-- Inclusión de la navbar -->

<div class="container mt-5">
    <h2 class="text-center">Listado de Llamadas de Atención y Logros</h2>

    <!-- Tabla de logros y llamadas de atención -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Empleado</th>
                <th>Tipo de Logro</th>
                <th>Descripción</th>
                <th>Fecha de Ocurrencia</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?= $row['id_atencion']; ?></td>
                    <td><?= $row['nombre_empleado']; ?></td>
                    <td><?= $row['tipo_logro']; ?></td>
                    <td><?= $row['descripcion']; ?></td>
                    <td><?= $row['fecha_ocurrencia']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
