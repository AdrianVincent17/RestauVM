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
            <a href="indexClientes.php" 
               class="nav-link <?= ($pagina_actual == 'indexClientes.php') ? 'active' : '' ?>">
               Inicio
            </a>
        </li>
        <li>
            <a href="mesas.php" 
               class="nav-link <?= ($pagina_actual == 'mesas.php') ? 'active' : '' ?>">
               Reservar Mesa
            </a>
        </li>
         <li>
            <a href="pedidos.php" 
               class="nav-link <?= ($pagina_actual == 'pedidos.php') ? 'active' : '' ?>">
                Pedidos
            </a>
        </li>
        <li>
            <a href="carta.php" 
               class="nav-link <?= ($pagina_actual == 'carta.php') ? 'active' : '' ?>">
               Carta Restaurante
            </a>
        </li>
        <li>
            <a href="modperfil.php" 
               class="nav-link <?= ($pagina_actual == 'modperfil.php') ? 'active' : '' ?>">
               Mi perfil
            </a>
        </li>
    </ul>
</nav>
