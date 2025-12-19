
<div class="container-fluid p-0">
    <nav class="navbar navbar-expand-sm bg-light navbar-light w-100">
        <div class="container-fluid d-flex justify-content-between align-items-center">

            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="../img/LaDespensalogo.png" alt="Logo" class="img-fluid" style="max-height: 50px;">
                <span class="ms-2">Restaurante La Despensa</span>
            </a>

            <ul class="navbar-nav d-flex flex-row align-items-center">
                <li class="nav-item me-3 d-none d-lg-block">
                    <p class="mb-0">Bienvenido/a, <?php echo $_SESSION['nombre']; ?></p>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-danger" href="../logout.php">Cerrar Sesión</a>
                </li>
            </ul>

        </div>
    </nav>
</div>








<!-- 
    <nav class="navbar navbar-expand-md navbar-light bg-light border-bottom">
        <div class="container-fluid">
            <button type="button" id="sidebarCollapse" class="btn btn-info d-md-none me-3">
                <i class="fa-thin fa-bars"></i> <span>Menu</span>
            </button>
            <div class="col-auto"><a class="navbar-brand text-dark" href="quienessomos.php"><img src="../img/LaDespensalogo.png" alt="LaDespensalogo" class="logo"></a></div>
            <div class="col">
                <h5>Restaurante La Despensa</h5>
            </div>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#" ++>Bienvenido/a, <span><?php echo $_SESSION['nombre']; ?></span></a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-danger ms-2" href="../logout.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav> -->