
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta - Restaurante La Despensa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="styles.css" type="text/css">
    <style>
        main {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .category {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            width: 100%;
            max-width: 700px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        h1,
        h2 {
            text-align: center;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .menu-item {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding: 0.75rem 0;
        }

        .menu-item:last-child {
            border-bottom: none;
        }

        .menu-item span.price {
            color: #117719ff;
            font-weight: bold;
        }

        footer.minimal-footer {
            background-color: #ffffff;
            padding: 1.5rem 0;
            border-top: 1px solid #e9ecef;
            text-align: center;
            margin-top: auto;
            color: #555;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

        <?php

        include("nav.php");
   
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

    <footer class="footer-custom mt-auto">
        <div class="container-fluid px-3 px-md-5 d-flex justify-content-center">
            <p class="small mb-0">&copy; 2025 Restaurante La Despensa. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>