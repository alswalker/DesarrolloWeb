<?php
include '../db.php';

// Obtenemos los empleados para llenar el combo
$empleados = $conn->query("CALL spconsultaempleados();");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Llamada de Atención o Logro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<?php include '../navbar.php'; ?> <!-- Inclusión de la navbar -->

<div class="container mt-5">
    <h2 class="text-center">Registrar Llamada de Atención o Logro</h2>

    <form id="addAtencionForm" method="POST" action="guardar_llamada.php">
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label for="tipo_logro" class="form-label">Tipo de Logro</label>
            <select class="form-select" id="tipo_logro" name="tipo_logro" required>
                <option value="" disabled selected>Seleccione el tipo de logro</option>
                <option value="Positivo">Positivo</option>
                <option value="Negativo">Negativo</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="fecha_ocurrencia" class="form-label">Fecha de Ocurrencia</label>
            <input type="date" class="form-control" id="fecha_ocurrencia" name="fecha_ocurrencia" required>
        </div>

        <div class="mb-3">
            <label for="id_empleado" class="form-label">Empleado</label>
            <select class="form-select" id="id_empleado" name="id_empleado" required>
                <option value="" disabled selected>Seleccione un empleado</option>
                <?php while ($row = $empleados->fetch_assoc()) : ?>
                    <option value="<?= $row['id_empleado']; ?>"><?= $row['nombre_completo']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Registrar</button>
    </form>
</div>

</body>
</html>
