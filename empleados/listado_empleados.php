<?php
include '../db.php';

// Obtenemos los empleados
$result = $conn->query("CALL spconsultaempleado();");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Empleados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<?php include '../navbar.php'; ?> <!-- Incluimos la navbar -->

<div class="container mt-5">
    <h2 class="text-center">Listado de Empleados</h2>

    <!-- Tabla de empleados -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre Completo</th>
                <th>Fecha de Nacimiento</th>
                <th>Puesto</th>
                <th>Tienda</th>
                <th>Salario</th>
                <th>Fotografía</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?= $row['id_empleado']; ?></td>
                    <td><?= $row['nombres'] . ' ' . $row['apellidos']; ?></td>
                    <td><?= $row['fecha_nac']; ?></td>
                    <td><?= $row['puesto']; ?></td>
                    <td><?= $row['tienda']; ?></td>
                    <td><?= $row['salario']; ?></td>
                    <td>
                        <?php if ($row['fotografia']) : ?>
                            <img src="data:image/jpeg;base64,<?= base64_encode($row['fotografia']); ?>" alt="Foto" width="100">
                        <?php else : ?>
                            Sin foto
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
