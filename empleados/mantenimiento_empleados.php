<?php
include '../db.php';

// Obtenemos los empleados
$result = $conn->query("CALL spconsultaempleado();");

// Obtenemos los puestos y tiendas para llenar los selects en el modal
$conn->next_result(); // Limpiamos el result set anterior
$puestos = $conn->query("CALL spconsultapuesto();");
$conn->next_result(); // Limpiamos el result set anterior
$tiendas = $conn->query("CALL spconsultatienda();");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenimiento de Empleados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert -->
</head>
<body>

<?php include '../navbar.php'; ?> <!-- Incluimos la navbar -->

<div class="container mt-5">
    <h2 class="text-center">Mantenimiento de Empleados</h2>

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
                <th>Acciones</th>
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
                    <td>
                        <button class="btn btn-warning edit-btn" data-id="<?= $row['id_empleado']; ?>" 
                                data-nombres="<?= $row['nombres']; ?>" data-apellidos="<?= $row['apellidos']; ?>"
                                data-fecha="<?= $row['fecha_nac']; ?>" data-salario="<?= $row['salario']; ?>" 
                                data-puesto="<?= $row['puesto']; ?>" data-tienda="<?= $row['tienda']; ?>"
                                data-bs-toggle="modal" data-bs-target="#editModal">Editar</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Modal para Editar Empleado -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Empleado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editEmpleadoForm" enctype="multipart/form-data">
                    <input type="hidden" id="editIdEmpleado" name="id_empleado">

                    <div class="mb-3">
                        <label for="editNombres" class="form-label">Nombres</label>
                        <input type="text" class="form-control" id="editNombres" name="nombres" required>
                    </div>

                    <div class="mb-3">
                        <label for="editApellidos" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" id="editApellidos" name="apellidos" required>
                    </div>

                    <div class="mb-3">
                        <label for="editFecha" class="form-label">Fecha de Nacimiento</label>
                        <input type="date" class="form-control" id="editFecha" name="fecha_nac" required>
                    </div>

                    <div class="mb-3">
                        <label for="editSalario" class="form-label">Salario</label>
                        <input type="number" class="form-control" id="editSalario" name="salario" required>
                    </div>

                    <div class="mb-3">
                        <label for="editPuesto" class="form-label">Puesto</label>
                        <select class="form-select" id="editPuesto" name="id_puesto" required>
                            <option selected disabled value="">Seleccione un Puesto</option>
                            <?php while ($puesto = $puestos->fetch_assoc()) : ?>
                                <option value="<?= $puesto['id_puesto']; ?>"><?= $puesto['puesto']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="editTienda" class="form-label">Tienda</label>
                        <select class="form-select" id="editTienda" name="id_tienda" required>
                            <option selected disabled value="">Seleccione una Tienda</option>
                            <?php while ($tienda = $tiendas->fetch_assoc()) : ?>
                                <option value="<?= $tienda['id_tienda']; ?>"><?= $tienda['tienda']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="editFotografia" class="form-label">Fotografía</label>
                        <input type="file" class="form-control" id="editFotografia" name="fotografia" accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Mostrar el modal con los datos para editar un empleado
    $('.edit-btn').on('click', function() {
        var id_empleado = $(this).data('id');
        var nombres = $(this).data('nombres');
        var apellidos = $(this).data('apellidos');
        var fecha_nac = $(this).data('fecha');  // Obtenemos la fecha
        var salario = $(this).data('salario');
        var puesto = $(this).data('puesto');
        var tienda = $(this).data('tienda');

        // Convertir fecha a formato YYYY-MM-DD si está en otro formato
        if (fecha_nac.includes('/')) {
            var parts = fecha_nac.split('/');
            fecha_nac = `${parts[2]}-${parts[1]}-${parts[0]}`;  // Reordenar para YYYY-MM-DD
        }

        $('#editIdEmpleado').val(id_empleado);
        $('#editNombres').val(nombres);
        $('#editApellidos').val(apellidos);
        $('#editFecha').val(fecha_nac);  // Cargar la fecha convertida
        $('#editSalario').val(salario);
        $('#editPuesto').val(puesto);
        $('#editTienda').val(tienda);
    });

    // Enviar los datos para actualizar el empleado
    $('#editEmpleadoForm').on('submit', function(event) {
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: 'update_empleado.php', // Archivo PHP que procesará la actualización
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#editModal').modal('hide');
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'Empleado actualizado correctamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload();
                });
            },
            error: function() {
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al actualizar el empleado.',
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
