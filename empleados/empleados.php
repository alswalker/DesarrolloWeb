<?php
// Incluimos la conexión a la base de datos
include '../db.php';
include_once '../config.php';

// Obtenemos los puestos y tiendas para llenar los selects
$puestos = $conn->query("CALL spconsultapuesto();");
$conn->next_result(); // Limpiamos el result set anterior
$tiendas = $conn->query("CALL spconsultatienda();");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Empleados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert -->
</head>
<body>

<?php include '../navbar.php'; ?> <!-- Incluimos la navbar -->

<div class="container mt-5">
    <h2 class="text-center">Agregar Nuevo Empleado</h2>

    <!-- Formulario para agregar empleado -->
    <form id="addEmpleadoForm" enctype="multipart/form-data" method="POST" action="add_empleado.php">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nombres" class="form-label">Nombres</label>
                <input type="text" class="form-control" id="nombres" name="nombres" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="fecha_nac" class="form-label">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="fecha_nac" name="fecha_nac" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="fotografia" class="form-label">Fotografía</label>
                <input type="file" class="form-control" id="fotografia" name="fotografia" accept="image/*" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="id_puesto" class="form-label">Puesto</label>
                <select class="form-select" id="id_puesto" name="id_puesto" required>
                    <option selected disabled value="">Seleccione un Puesto</option>
                    <?php while ($row = $puestos->fetch_assoc()) : ?>
                        <option value="<?= $row['id_puesto']; ?>"><?= $row['puesto']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="id_tienda" class="form-label">Tienda</label>
                <select class="form-select" id="id_tienda" name="id_tienda" required>
                    <option selected disabled value="">Seleccione una Tienda</option>
                    <?php while ($row = $tiendas->fetch_assoc()) : ?>
                        <option value="<?= $row['id_tienda']; ?>"><?= $row['tienda']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="salario" class="form-label">Salario</label>
                <input type="number" step="0.01" class="form-control" id="salario" name="salario" required>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-success">Guardar</button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        $('#addEmpleadoForm').on('submit', function (event) {
            event.preventDefault();
            var formData = new FormData(this); // Recogemos los datos del formulario

            $.ajax({
                url: 'add_empleado.php',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    // SweetAlert para notificación de éxito
                    Swal.fire({
                        title: '¡Éxito!',
                        text: 'Empleado agregado correctamente.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '<?= BASE_URL ?>empleados/listado_empleados.php';
                        }
                    });
                },
                error: function () {
                    Swal.fire({
                        title: 'Error',
                        text: 'Hubo un problema al agregar el empleado.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>

</body>
</html>
