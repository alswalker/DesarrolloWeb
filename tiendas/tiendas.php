<?php
// Incluimos la conexión a la base de datos
include '../db.php';

// Obtenemos las tiendas usando el procedimiento almacenado
$result = $conn->query("CALL spconsultatienda();");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Tiendas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert -->
</head>
<body>

<?php include '../navbar.php'; ?> <!-- Incluimos la navbar -->

<div class="container mt-5">
    <h2 class="text-center">Catálogo de Tiendas</h2>
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Agregar Nueva Tienda</button>
    
    <!-- Tabla de tiendas -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tienda</th>
                <th>Dirección</th>
                <th>Jefe</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?= $row['id_tienda']; ?></td>
                    <td><?= $row['tienda']; ?></td>
                    <td><?= $row['direccion']; ?></td>
                    <td><?= $row['jefe']; ?></td>
                    <td>
                        <button class="btn btn-warning edit-btn" data-id="<?= $row['id_tienda']; ?>" data-tienda="<?= $row['tienda']; ?>" data-direccion="<?= $row['direccion']; ?>" data-jefe="<?= $row['jefe']; ?>" data-bs-toggle="modal" data-bs-target="#editModal">Editar</button>
                        <button class="btn btn-danger delete-btn" data-id="<?= $row['id_tienda']; ?>">Eliminar</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Modal para Crear Tienda -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Agregar Nueva Tienda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addTiendaForm">
                    <div class="mb-3">
                        <label for="tienda" class="form-label">Tienda</label>
                        <input type="text" class="form-control" id="tienda" name="tienda" required>
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" required>
                    </div>
                    <div class="mb-3">
                        <label for="jefe" class="form-label">Jefe</label>
                        <input type="text" class="form-control" id="jefe" name="jefe" required>
                    </div>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Editar Tienda -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Tienda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editTiendaForm">
                    <input type="hidden" id="editIdTienda" name="id_tienda">
                    <div class="mb-3">
                        <label for="editTienda" class="form-label">Tienda</label>
                        <input type="text" class="form-control" id="editTienda" name="tienda" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDireccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="editDireccion" name="direccion" required>
                    </div>
                    <div class="mb-3">
                        <label for="editJefe" class="form-label">Jefe</label>
                        <input type="text" class="form-control" id="editJefe" name="jefe" required>
                    </div>
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // SweetAlert para agregar una nueva tienda
    $('#addTiendaForm').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
            url: 'add_tienda.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#createModal').modal('hide');
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'Tienda agregada correctamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload();
                });
            },
            error: function() {
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al agregar la tienda.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });

    // SweetAlert para mostrar los datos en el modal para editar
    $('.edit-btn').on('click', function() {
        var id_tienda = $(this).data('id');
        var tienda = $(this).data('tienda');
        var direccion = $(this).data('direccion');
        var jefe = $(this).data('jefe');
        $('#editIdTienda').val(id_tienda);
        $('#editTienda').val(tienda);
        $('#editDireccion').val(direccion);
        $('#editJefe').val(jefe);
    });

    // SweetAlert para editar una tienda
    $('#editTiendaForm').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
            url: 'edit_tienda.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#editModal').modal('hide');
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'Tienda actualizada correctamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload();
                });
            },
            error: function() {
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al actualizar la tienda.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });

    // SweetAlert para eliminar una tienda
    $('.delete-btn').on('click', function() {
        var id_tienda = $(this).data('id');
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
                    url: 'delete_tienda.php',
                    method: 'POST',
                    data: { id_tienda: id_tienda },
                    success: function(response) {
                        Swal.fire({
                            title: '¡Eliminado!',
                            text: 'La tienda ha sido eliminada.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error',
                            text: 'Hubo un problema al eliminar la tienda.',
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
