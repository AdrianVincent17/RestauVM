<?php

// Detecta el nombre del archivo actual sin importar la carpeta
$pagina_actual = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
?>

<nav id="sidebar">
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
            <a href="carta.php" 
               class="nav-link <?= ($pagina_actual == 'carta.php') ? 'active' : '' ?>">
               Carta de restaurante
            </a>
        </li>
         <li>
            <a href="cobrar.php" 
               class="nav-link <?= ($pagina_actual == 'cobrar.php') ? 'active' : '' ?>">
               Cobrar
            </a>
        </li>
    </ul>
</nav>
