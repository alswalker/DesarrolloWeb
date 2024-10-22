<?php
// Incluimos la conexión a la base de datos
include '../db.php';

// Obtenemos los puestos usando el procedimiento almacenado
$result = $conn->query("CALL spconsultapuesto();");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Puestos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert -->
</head>
<body>

<?php include '../navbar.php'; ?> <!-- Incluimos la navbar -->

<div class="container mt-5">
    <h2 class="text-center">Catálogo de Puestos</h2>
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Agregar Nuevo Puesto</button>
    
    <!-- Tabla de puestos -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Puesto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?= $row['id_puesto']; ?></td>
                    <td><?= $row['puesto']; ?></td>
                    <td>
                        <button class="btn btn-warning edit-btn" data-id="<?= $row['id_puesto']; ?>" data-puesto="<?= $row['puesto']; ?>" data-bs-toggle="modal" data-bs-target="#editModal">Editar</button>
                        <button class="btn btn-danger delete-btn" data-id="<?= $row['id_puesto']; ?>">Eliminar</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Modal para Crear Puesto -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Agregar Nuevo Puesto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addPuestoForm">
                    <div class="mb-3">
                        <label for="puesto" class="form-label">Puesto</label>
                        <input type="text" class="form-control" id="puesto" name="puesto" required>
                    </div>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Editar Puesto -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Puesto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPuestoForm">
                    <input type="hidden" id="editIdPuesto" name="id_puesto">
                    <div class="mb-3">
                        <label for="editPuesto" class="form-label">Puesto</label>
                        <input type="text" class="form-control" id="editPuesto" name="puesto" required>
                    </div>
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // SweetAlert para agregar un nuevo puesto
    $('#addPuestoForm').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
            url: 'add_puesto.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#createModal').modal('hide');
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'Puesto agregado correctamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload();
                });
            },
            error: function() {
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al agregar el puesto.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });

    // SweetAlert para mostrar el modal con los datos para editar un puesto
    $('.edit-btn').on('click', function() {
        var id_puesto = $(this).data('id');
        var puesto = $(this).data('puesto');
        $('#editIdPuesto').val(id_puesto);
        $('#editPuesto').val(puesto);
    });

    // SweetAlert para editar un puesto
    $('#editPuestoForm').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
            url: 'edit_puesto.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#editModal').modal('hide');
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'Puesto actualizado correctamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload();
                });
            },
            error: function() {
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al actualizar el puesto.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });

    // SweetAlert para eliminar un puesto
    $('.delete-btn').on('click', function() {
        var id_puesto = $(this).data('id');
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esta acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'delete_puesto.php',
                    method: 'POST',
                    data: { id_puesto: id_puesto },
                    success: function(response) {
                        Swal.fire({
                            title: '¡Eliminado!',
                            text: 'El puesto ha sido eliminado.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error',
                            text: 'Hubo un problema al eliminar el puesto.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    });
});
</script>

</body>
</html>
