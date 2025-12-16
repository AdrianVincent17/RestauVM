<?php
// Detecta el nombre del archivo actual sin importar la carpeta
$pagina_actual = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Definimos el enlace por defecto para "Pedidos".
$pedidopendiente = "pedidos.php";

//Comprobamos si existe un 'idped' en la URL actual.
if (isset($_SESSION['idped'])) {
    //Sí existe... Sobrescribimos la variable para que el enlace
    //    apunte a este pedido específico.
    $pedidopendiente = "pedidos.php?idped=" . (int)$_SESSION['idped'];
}
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
        <h3>Gestión Cliente</h3>
    </div>
    <ul class="list-unstyled components sidebar-items">
        <li>
            <a href="indexClientes.php"
                class="nav-link <?= ($pagina_actual == 'indexClientes.php') ? 'active' : '' ?>">
                Inicio
            </a>
        </li>
        <?php
        //Solo mostrar el enlace "Reservar Mesa" si NO hay un pedido activo en la sesión
        if (!isset($_SESSION['idped'])) :
        ?>
            <li>
                <a href="mesas.php"
                    class="nav-link <?= ($pagina_actual == 'mesas.php') ? 'active' : '' ?>">
                    Reservar Mesa
                </a>
            </li>
        <?php endif; ?>
        <li>
            <a href="<?php echo $pedidopendiente; ?>"
                class="nav-link <?= ($pagina_actual == 'pedidos.php') ? 'active' : '' ?>">
                Pedidos
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