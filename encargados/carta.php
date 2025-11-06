<?php
include("../seguridad.php");
proteger(2);
include("../conexion.php");
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <?php

    include("../head.php");
    ?>
    <title>Carta - Restaurante La Despensa</title>

</head>

<body class="d-flex flex-column min-vh-100">

    <?php

    include("../nav.php");

    ?>


    <div class="wrapper">

        <?php
        include("navbar.php");
        ?>



        <main class="container my-5">
            <h1 class="mb-5">Carta - Restaurante La Despensa</h1>

            <section class="category">
                <h2>🥗 Entrantes</h2>
                <div class="menu-item">
                    <span>Ensalada murciana tradicional</span>
                    <span class="price">8,50 €</span>
                </div>
                <div class="menu-item">
                    <span>Pimientos asados con ventresca</span>
                    <span class="price">9,00 €</span>
                </div>
                <div class="menu-item">
                    <span>Zarangollo murciano (calabacín, huevo y cebolla)</span>
                    <span class="price">7,50 €</span>
                </div>
                <div class="menu-item">
                    <span>Tabla de embutidos de la huerta</span>
                    <span class="price">11,00 €</span>
                </div>
            </section>
            <section class="category">
                <h2>🍅 Platos Principales</h2>
                <div class="menu-item">
                    <span>Arroz con conejo y caracoles al estilo murciano</span>
                    <span class="price">13,50 €</span>
                </div>
                <div class="menu-item">
                    <span>Chuletas de cordero segureño con guarnición</span>
                    <span class="price">15,00 €</span>
                </div>
                <div class="menu-item">
                    <span>Bacalao al ajo colorao</span>
                    <span class="price">14,00 €</span>
                </div>
                <div class="menu-item">
                    <span>Pisto de la huerta con huevo a baja temperatura</span>
                    <span class="price">10,00 €</span>
                </div>
            </section>
            <section class="category">
                <h2>🍮 Postres Caseros</h2>
                <div class="menu-item">
                    <span>Paparajotes murcianos</span>
                    <span class="price">5,00 €</span>
                </div>
                <div class="menu-item">
                    <span>Arroz con leche de la abuela</span>
                    <span class="price">4,50 €</span>
                </div>
                <div class="menu-item">
                    <span>Natillas con canela</span>
                    <span class="price">4,00 €</span>
                </div>
                <div class="menu-item">
                    <span>Tarta de limón murciano</span>
                    <span class="price">5,50 €</span>
                </div>
            </section>
            <section class="category">
                <h2>🍷 Bebidas</h2>
                <div class="menu-item">
                    <span>Vino tinto de Jumilla (copa)</span>
                    <span class="price">3,00 €</span>
                </div>
                <div class="menu-item">
                    <span>Cerveza artesanal murciana</span>
                    <span class="price">3,50 €</span>
                </div>
                <div class="menu-item">
                    <span>Agua mineral</span>
                    <span class="price">1,50 €</span>
                </div>
                <div class="menu-item">
                    <span>Refrescos variados</span>
                    <span class="price">2,20 €</span>
                </div>
            </section>
        </main>
    </div>

    <?php

    include("../footer.php");
    ?>
</body>

</html>