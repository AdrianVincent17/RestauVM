<?php

// Detecta el nombre del archivo actual sin importar la carpeta
$pagina_actual = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
?>

<!-- BOTÓN DE COLAPSO VISIBLE SOLO EN MÓVILES -->
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

<nav id="sidebar" class="collapse d-md-block">
    <div class="sidebar-header">
        <h3>Gestión Camareros</h3>
    </div>
    <ul class="list-unstyled components sidebar-items">
        <li>
            <a href="indexCamareros.php" 
               class="nav-link <?= ($pagina_actual == 'indexCamareros.php') ? 'active' : '' ?>">
               Inicio
            </a>
        </li>

        <li>
            <a href="gestionarmesas.php" 
               class="nav-link <?= ($pagina_actual == 'gestionarmesas.php') ? 'active' : '' ?>">
               Gestión de mesas
            </a>
        </li>

        <li>
            <a href="servir.php" 
               class="nav-link <?= ($pagina_actual == 'servir.php') ? 'active' : '' ?>">
               Servir Mesas
            </a>
        </li>
         <li>
            <a href="cobrar.php" 
               class="nav-link <?= ($pagina_actual == 'cobrar.php') ? 'active' : '' ?>">
               Cobrar Mesas
            </a>
        </li>
    </ul>
</nav>
