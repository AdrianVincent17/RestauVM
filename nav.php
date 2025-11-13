<div class="d-flex flex-column w-100">
    <nav class="navbar navbar-expand-sm bg-light navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="quienessomos.php" class="logo">
                <img src="../img/LaDespensalogo.png" alt="LaDespensalogo" class="img-fluid logo">
                <span class="mt-5" >Restaurante La Despensa</span>
            </a>
            
            <ul class="navbar-nav mt-3">
                <li class="nav-item mt-2 me-2 xs-d-none">
                    <p>Bienvenido/a, <?php echo $_SESSION['nombre']; ?></p>
                </li>
                <li class="nav-item">
                    <a class="btn btn-md btn-outline-danger" href="../logout.php">Cerrar Sesion</a>
                </li>
            </ul>
        </div>
    </nav>









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