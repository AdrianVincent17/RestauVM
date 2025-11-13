<?php 
$pagina_actual = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
?>

<!-- Botón de colapso visible solo en móviles -->
<div class="d-md-none text-end mb-3">
    <button class="btn btn-info" 
            type="button" 
            data-bs-toggle="collapse" 
            data-bs-target="#sidebar"
            aria-expanded="false" 
            aria-controls="sidebar">
        <i class="bi bi-list">Menu</i>
    </button>
</div>

<!-- Sidebar -->
<nav id="sidebar" class="collapse d-md-block">
    <div class="sidebar-header">
        <h3>Gestión Restaurante</h3>
    </div>
    <ul class="list-unstyled components sidebar-items">
        <li>
            <a href="indexEncargados.php" 
               class="nav-link <?php echo ($pagina_actual == 'indexEncargados.php') ? 'active' : ''; ?>">
               Inicio
            </a>
        </li>
        <li>
            <a href="modperfil.php" 
               class="nav-link <?php echo ($pagina_actual == 'modperfil.php') ? 'active' : ''; ?>">
               Gestión de Personal
            </a>
        </li>
        <li>
            <a href="productos.php" 
               class="nav-link <?php echo ($pagina_actual == 'productos.php') ? 'active' : ''; ?>">
               Productos
            </a>
        </li>
        <li>
            <a href="carta.php" 
               class="nav-link <?php echo ($pagina_actual == 'carta.php') ? 'active' : ''; ?>">
               Carta Restaurante
            </a>
        </li>
        <li>
            <a href="estadisticas.php" 
               class="nav-link <?php echo ($pagina_actual == 'estadisticas.php') ? 'active' : ''; ?>">
               Estadísticas
            </a>
        </li>
    </ul>
</nav>