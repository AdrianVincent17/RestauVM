-- ==========================================================
-- INSERTS CATEGORIAS
-- ==========================================================

INSERT INTO categoria (nombre,estado) VALUES
('Entrantes',0),
('Platos Principales',0),
('Postres',0),
('Bebidas',0);

-- ==========================================================
-- INSERTS PRODUCTOS
-- ==========================================================

-- ==========================================================
-- CATEGORÍA 1: ENTRANTES / TAPAS (5 productos)
-- ==========================================================

INSERT INTO producto (idprod, nombre, precio, stock, estado, categoria, estado_cat) VALUES
(0, 'Ensalada murciana (tomate, cebolla, aceitunas y huevo)', 7.50, 30, 0, 1, 0),
(0, 'Zarangollo murciano (revuelto de calabacín, cebolla)', 7.50, 42, 0, 1, 0),
(0, 'Pastel de carne murciano (hojaldre relleno de carne)', 4.50, 47, 0, 1, 0),
(0, 'Michirones (habas secas guisadas con chorizo y pan)', 6.50, 39, 0, 1, 0),
(0, 'Croquetas de jamón ibérico', 7.00, 29, 0, 1, 0);


-- ==========================================================
-- CATEGORÍA 2: PLATOS PRINCIPALES (5 productos)
-- ==========================================================

INSERT INTO producto (idprod, nombre, precio, stock, estado, categoria, estado_cat) VALUES
(0, 'Arroz caldero del Mar Menor (con pescado y alioli)', 14.00, 40, 0, 2, 0),
(0, 'Cordero segureño al horno con patatas', 15.50, 24, 0, 2, 0),
(0, 'Bacalao al ajo colorao', 13.00, 31, 0, 2, 0),
(0, 'Albóndigas de chato murciano con salsa casera', 12.50, 43, 0, 2, 0),
(0, 'Huevos rotos con jamón y patatas de la huerta', 9.50, 48, 0, 2, 0);


-- ==========================================================
-- CATEGORÍA 3: POSTRES (5 productos)
-- ==========================================================

INSERT INTO producto (idprod, nombre, precio, stock, estado, categoria, estado_cat) VALUES
(0, 'Paparajotes murcianos (hojas de limón rebozadas en masa tipo churro)', 4.50, 37, 0, 3, 0),
(0, 'Arroz con leche de la abuela', 4.00, 40, 0, 3, 0),
(0, 'Tocino de cielo', 4.20, 41, 0, 3, 0),
(0, 'Tarta de limón murciano', 5.00, 33, 0, 3, 0),
(0, 'Pan de Calatrava', 4.00, 28, 0, 3, 0);


-- ==========================================================
-- CATEGORÍA 4: BEBIDAS (5 productos)
-- ==========================================================

INSERT INTO producto (idprod, nombre, precio, stock, estado, categoria, estado_cat) VALUES
(0, 'Vino tinto de Jumilla (copa)', 3.00, 40, 0, 4, 0),
(0, 'Cerveza artesanal murciana', 3.50, 50, 0, 4, 0),
(0, 'Agua mineral', 1.50, 8, 0, 4, 0),
(0, 'Sangría casera', 4.50, 38, 0, 4, 0),
(0, 'Refescos', 2.10, 80, 0, 4, 0);

-- ==========================================================
-- CATEGORÍA 5: CAFÉS E INFUSIONES (5 productos)
-- ==========================================================

INSERT INTO producto (idprod, nombre, precio, stock, estado, categoria, estado_cat) VALUES
(0, 'Café bombón murciano (con leche condensada)', 2.50, 25, 0, 5, 0),
(0, 'Té matcha verde', 3.50, 30, 0, 5, 0),
(0, 'Asiatico murciano', 3.20, 25, 0, 5, 0),
(0, 'Té frutos rojos', 2.80, 38, 0, 5, 0),
(0, 'Batido Nesquik', 2.10, 80, 0, 5, 0);



-- ==========================================================
-- INSERTS USUARIOS
-- ==========================================================

INSERT INTO usuario (dni, nombre, apellidos, rol, email, telefono, direccion, pass, estado) VALUES
('12345678A', 'Antonio', 'Vicente López', 0,'tonikirosiki@ladespensa.es','658987453','C/Murillo,38','1234',0),
('12345678B', 'Alvaro', 'Martinez Sanz', 1,'alvarodevs@ladespensa.es','658985913','C/Santiago,12','1234',0),
('12345678C', 'Adrian', 'Vicente López', 2,'adrianvincent@ladespensa.es','685248569','C/Albeniz,26','1234',0);

-- ==========================================================
-- INSERTS MESAS
-- ==========================================================

INSERT INTO mesa (nmesa,estado) VALUES
(1,0),
(2,0),
(3,0),
(4,0),
(5,0),
(6,0),
(7,0),
(8,0),
(9,0);











