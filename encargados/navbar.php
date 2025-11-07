<?php
// Detecta el nombre del archivo actual sin importar la carpeta
$pagina_actual = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
?>

<nav id="sidebar">
    <div class="sidebar-header">
        <h3>Gestión Restaurante</h3>
    </div>
    <ul class="list-unstyled components sidebar-items">
        <li>
            <a href="indexEncargados.php" 
               class="nav-link <?= ($pagina_actual == 'indexEncargados.php') ? 'active' : '' ?>">
               Inicio
            </a>
        </li>

        <li>
            <a href="modperfil.php" 
               class="nav-link <?= ($pagina_actual == 'modperfil.php') ? 'active' : '' ?>">
               Gestión de Personal
            </a>
        </li>

         <li>
            <a href="productos.php" 
               class="nav-link <?= ($pagina_actual == 'productos.php') ? 'active' : '' ?>">
               Productos
            </a>
        </li>
        <li>
            <a href="carta.php" 
               class="nav-link <?= ($pagina_actual == 'carta.php') ? 'active' : '' ?>">
               Carta Restaurante
            </a>
        </li>
        <li>
            <a href="estadisticas.php" 
               class="nav-link <?= ($pagina_actual == 'estadisticas.php') ? 'active' : '' ?>">
               Estadísticas
            </a>
        </li>
    </ul>
</nav>
