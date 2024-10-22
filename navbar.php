<?php
// Incluir la configuración global
include_once 'config.php'; // Ajusta la ruta según sea necesario
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?= BASE_URL ?>">Intelafix</a> <!-- Enlace al inicio -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="catalogosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Catálogos
          </a>
          <ul class="dropdown-menu" aria-labelledby="catalogosDropdown">
            <li><a class="dropdown-item" href="<?= BASE_URL ?>puestos/puestos.php">Puestos</a></li>
            <li><a class="dropdown-item" href="<?= BASE_URL ?>tiendas/tiendas.php">Tiendas</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="empleadosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Empleados
          </a>
          <ul class="dropdown-menu" aria-labelledby="empleadosDropdown">
            <li><a class="dropdown-item" href="<?= BASE_URL ?>empleados/listado_empleados.php">Listado</a></li>
            <li><a class="dropdown-item" href="<?= BASE_URL ?>empleados/empleados.php">Agregar</a></li>
            <li><a class="dropdown-item" href="<?= BASE_URL ?>empleados/mantenimiento_empleados.php">Mantenimiento</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="llamadasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Control de Desempeño
          </a>
          <ul class="dropdown-menu" aria-labelledby="llamadasDropdown">
            <li><a class="dropdown-item" href="<?= BASE_URL ?>llamadas/listado_llamadas.php">Listado</a></li>
            <li><a class="dropdown-item" href="<?= BASE_URL ?>llamadas/agregar_llamada.php">Agregar</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Reportes</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
