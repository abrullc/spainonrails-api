-- -----------------------------------------------------
-- Schema "spain_on_rails"
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS spain_on_rails;
CREATE SCHEMA IF NOT EXISTS spain_on_rails DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE spain_on_rails;


-- -----------------------------------------------------
-- Table "tren"
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS tren (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(45) UNIQUE NOT NULL,
  descripcion TEXT NOT NULL,
  capacidad INT NOT NULL,
  imagen VARCHAR(100)
);


-- -----------------------------------------------------
-- Table "ruta"
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS ruta (
  id INT PRIMARY KEY AUTO_INCREMENT,
  tren_id INT,
  origen VARCHAR(45) NOT NULL,
  destino VARCHAR(45) NOT NULL,
  descripcion TEXT NOT NULL,
  CONSTRAINT fk_ruta_tren
    FOREIGN KEY (tren_id)
    REFERENCES tren (id)
    ON DELETE SET NULL
);


-- -----------------------------------------------------
-- Table "estacion"
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS estacion (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(100) NOT NULL,
  poblacion VARCHAR(100) NOT NULL,
  direccion VARCHAR(150) NOT NULL,
  longitud FLOAT NOT NULL,
  latitud FLOAT NOT NULL,
  imagen VARCHAR(100)
);


-- -----------------------------------------------------
-- Table "parada"
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS parada (
  ruta_id INT NOT NULL,
  estacion_id INT NOT NULL,
  CONSTRAINT multiple_primary_key_ruta_estacion PRIMARY KEY (ruta_id, estacion_id),
  CONSTRAINT fk_parada_ruta
    FOREIGN KEY (ruta_id)
    REFERENCES ruta (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_parada_estacion
    FOREIGN KEY (estacion_id)
    REFERENCES estacion (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);


-- -----------------------------------------------------
-- Table "punto_interes"
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS punto_interes (
  id INT PRIMARY KEY AUTO_INCREMENT,
  estacion_id INT NOT NULL,
  nombre VARCHAR(100) NOT NULL,
  direccion VARCHAR(150) NOT NULL,
  descripcion TEXT NOT NULL,
  longitud FLOAT NOT NULL,
  latitud FLOAT NOT NULL,
  imagen VARCHAR(100),
  CONSTRAINT fk_punto_interes_estacion
    FOREIGN KEY (estacion_id)
    REFERENCES estacion (id)
    ON DELETE CASCADE
    ON UPDATE NO ACTION
);


-- -----------------------------------------------------
-- Table "usuario"
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS usuario (
  id INT PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(45) UNIQUE NOT NULL,
  password VARCHAR(45) NOT NULL,
  email VARCHAR(100) NULL,
  imagen VARCHAR(100)
);


-- -----------------------------------------------------
-- Table "plan_viaje"
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS plan_viaje (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(70) NOT NULL
);


-- -----------------------------------------------------
-- Table "pasaje"
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS pasaje (
  id INT PRIMARY KEY AUTO_INCREMENT,
  ruta_id INT NOT NULL,
  usuario_id INT,
  salida DATETIME NOT NULL,
  llegada DATETIME NOT NULL,
  precio FLOAT NOT NULL,
  habitacion VARCHAR(20) NOT NULL,
  CONSTRAINT fk_ruta_pasaje
    FOREIGN KEY (ruta_id)
    REFERENCES ruta (id)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT fk_usuario_pasaje
    FOREIGN KEY (usuario_id)
    REFERENCES usuario (id)
    ON DELETE SET NULL
    ON UPDATE NO ACTION
);


-- -----------------------------------------------------
-- Table "plan_viaje_usuario"
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS plan_viaje_usuario (
  plan_viaje_id INT NOT NULL,
  usuario_id INT NOT NULL,
  CONSTRAINT multiple_primary_key_plan_viaje_usuario PRIMARY KEY (plan_viaje_id, usuario_id),
  CONSTRAINT fk_plan_viaje_usuario_plan_viaje
    FOREIGN KEY (plan_viaje_id)
    REFERENCES plan_viaje (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_plan_viaje_usuario_usuario
    FOREIGN KEY (usuario_id)
    REFERENCES usuario (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);


-- -----------------------------------------------------
-- Table "visita"
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS visita (
  plan_viaje_id INT NOT NULL,
  punto_interes_id INT NOT NULL,
  fecha DATETIME NOT NULL,
  CONSTRAINT multiple_primary_key_plan_viaje_punto_interes PRIMARY KEY (plan_viaje_id, punto_interes_id),
  CONSTRAINT fk_plan_viaje_punto_interes_plan_viaje
    FOREIGN KEY (plan_viaje_id)
    REFERENCES plan_viaje (id)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT fk_plan_viaje_punto_interes_punto_interes
    FOREIGN KEY (punto_interes_id)
    REFERENCES punto_interes (id)
    ON DELETE CASCADE
    ON UPDATE NO ACTION
);

INSERT INTO tren (nombre, descripcion, capacidad)
VALUES
("Transcantábrico", "El Transcantábrico, se inaugura en 1983 en León, se reforma en el año 2000 y se transforma íntegramente en el año 2011 convirtiéndose en El Transcantábrico Gran Lujo, uno de los trenes más exclusivos y lujosos del mundo. Circula por una red ferroviaria de ancho métrico, lo que permite disfrutar de la naturaleza en todo su esplendor, desde la alta montaña, pasando por valles y riberas hasta llegar a besar el mar Cantábrico. Un viaje de glamour, paisaje, cultura y belleza que no le dejará indiferente.", 28),
("Al Ándalus", "El Tren Al Ándalus se inaugura en 1985 teniendo como destino y fin el dar a conocer Andalucía. Diversos contratiempos hacen que en 2005 el tren deje de circular y queda aparcado en Sevilla. En 2011 se procede a una cuidadísima restauración y redecoración del tren, volviendo a su vida activa en 2012, por las vías de ancho Ibérico, que le confieren una mayor amplitud interior, que unido a sus casi 500m de longitud hacen de este tren un auténtico Palacio sobre ruedas. Un viaje a la Belle Époque de la exquisitez y la sofisticación con la tecnología de los tiempos actuales.", 64),
("Costa Verde Express", "Tras el éxito alcanzado por El Transcantábrico en sus primeros años, en el año 2000 se construye un hermano gemelo al que en aquella época se estaba reformando y pasa a llamarse El Transcantábrico II. En 2011, El Transcantábrico I, que se inauguró en 1983 y se reformó en el 2000 se remodela integramente dando lugar a El Transcantábrico Gran Lujo y El Transcantábrico II cambia el nombre por El Transcantábrico Clásico, nombre que le dura hasta 2022. que pasa a denominarse Costa Verde Express, con una nueva ruta más corta y nuevos colores. Un tren de lujo moderno que le dará a conocer la bella España Verde.", 46),
("Expreso de La Robla", "El expreso de la Robla se construye en 2009 como un tren-escuela, para impartir cursos de intermodalidad portuaria. A la par, realizaba viajes turísticos entre curso y curso, afianzando un gran mercado nacional. Una vez finalizado el periodo de cursos, continúa realizando viajes turísticos por todo el Norte de España, dentro de la red de ancho métrico. El expreso de la Robla es un tren juvenil con el confort de los legendarios trenes europeos y las comodidades y avances tecnológicos del siglo XXI. Un tren alegre y moderno que le mostrará los más espectaculares parajes de Castilla y León.", 54),
("Tren de los Ochenta", "Con el paso de los años se han incorporado diferentes vehículos tanto de tracción como coches de viajeros que circularon por la red ferroviaria durante la década de los 80. La gran variedad de material incluido haría necesario cambiar el enfoque del proyecto original con el nombre con el que se conoce actualmente: el “Tren de los 80”. Se busca así la preservación de una composición completa, como una muestra viva de una etapa del pasado ferroviario e industrial de nuestro país y su evolución hacia el conjunto de la sociedad, siempre buscando la máxima similitud a la configuración comercial real en cuanto a plazas y servicios.", 80);

INSERT INTO ruta (tren_id, origen, destino, descripcion)
VALUES
("1", "San Sebastián", "Santiago de Compostela", 
"Día 1: San Sebastián – Carranza
Día 2: Carranza – Santander
Día 3: Santander – Cabezón de la Sal
Día 4: Cabezón de la Sal – Llanes
Día 5: Llanes – Oviedo
Día 6: Oviedo – Luarca
Día 7: Luarca – Viveiro
Día 8: Viveiro – Santiago de Compostela"),
("2", "Málaga", "Sevilla", 
"Día 1: Málaga – Granada
Día 2: Granada – Linares/Baeza
Día 3: Linares/Baeza – Úbeda – Baeza – Córdoba
Día 4: Córdoba – Ronda
Día 5: Ronda – Jerez
Día 6: Jerez – Cádiz – Jerez
Día 7: Sevilla"),
("3", "Bilbao", "Santiago de Compostela", 
"Día 1: Bilbao – Santander
Día 2: Santander – Llanes
Día 3: Llanes – Oviedo
Día 4: Oviedo – Luarca
Día 5: Luarca – Viveiro
Día 6: Viveiro – Santiago de Compostela"),
("4", "Bilbao", "León", 
"Día 1: Bilbao – Espinosa de Los Monteros
Día 2: Espinosa de Los Monteros – Cistierna
Día 3: Cistierna – León"),
("5", "Madrid", "Valencia", "Bajo el nombre de “Valencia Expreso” -en homenaje al Rápido que unía Madrid con València y Portbou a través del “Directo” de Cuenca, hoy cerrado parcialmente- nos desplazaremos a la ciudad del Turia -vía Albacete- a bordo de nuestro “Tren de los Ochenta” al completo y remolcado por una de las 269.400 del parque de Alsa Rail."),
("1", "Santiago de Compostela", "San Sebastián", 
"Día 1: Santiago de Compostela – Viveiro
Día 2: Viveiro – Oviedo
Día 3: Oviedo – Llanes
Día 4: Llanes
Día 5: Llanes - Cabezón de la Sal
Día 6: Cabezón de La Sal – Santander
Día 7: Santander - Carranza
Día 8: Carranza - San Sebastián");

INSERT INTO estacion (nombre, poblacion, direccion, longitud, latitud)
VALUES
/*1*/("San Sebastián", "San Sebastián", "De Francia Ibilbidea, 22, 20012 Donostia, Gipuzkoa", 43.317672075902976, -1.9767051319885167),
/*2*/("Carranza", "Ambasaguas", "48890 Ambasaguas, Vizcaya", 43.23893883331732, -3.3579304449974674),
/*3*/("Santander", "Santander", "39008 Santander, Cantabria", 43.458329956532566, -3.8109882414329426),
/*4*/("Cabezón de la Sal", "Cabezón de la Sal", "39500 Cabezón de la Sal, Cantabria", 43.30777026930593, -4.231968416100467),
/*5*/("Llanes", "Llanes", "Llanes, 33500 Llanes, Asturias", 43.42093964462446, -4.7587020978435195),
/*6*/("Oviedo", "Oviedo", "C. Uría, 33001 Oviedo, Asturias", 43.366839948522234, -5.854270405313146),
/*7*/("Luarca", "Luarca", "Luarca, 33700 Valdés, Asturias", 43.537832592724065, -6.536935035358728),
/*8*/("Viveiro", "Viveiro", "Viveiro, 27869 Viveiro, Lugo", 43.65690113718507, -7.600335834873597),
/*9*/("Santiago de Compostela", "Santiago de Compostela", "Rúa de Santiago del Estero, 75, A, 15702 Santiago de Compostela, A Coruña", 42.87079440773629, -8.544722046495826),
/*10*/("Málaga María Zambrano", "Málaga", "s/n, 29002 Málaga", 36.71192090012768, -4.4319629877659015),
/*11*/("Granada", "Granada", "Av. de Andaluces, 20, Beiro, 18014 Granada", 37.184043758799696, -3.6091647229214217),
/*12*/("Linares-Baeza", "Linares", "23490 Estación Linares-Baeza, Jaén", 38.06916911312782, -3.589314113063243),
/*13*/("Córdoba", "Córdoba", "Gta. Tres Culturas, s/n, Noroeste, 14011 Córdoba", 37.88854074045589, -4.789554774003961),
/*14*/("Ronda", "Ronda", "C. Victoria, 31, 29012 Ronda, Málaga", 36.74840333902957, -5.161972984225822),
/*15*/("Jerez De La Frontera", "Jerez De La Frontera", "11406 Jerez de la Frontera, Cádiz", 36.67999352657208, -6.126601848497249),
/*16*/("Cádiz", "Cádiz", "Pl. de Sevilla, S/N, 11006 Cádiz", 36.528900621771335, -6.2879647254703555),
/*17*/("Sevilla Santa Justa", "Sevilla", "41007, C. Joaquin Morales y Torres, 41003 Sevilla", 37.392386284234554, -5.974933424769042),
/*18*/("Bilbao-Abando Indalecio Prieto", "Bilbao", "48008 Bilbao, BI (Planta 0 y Planta 1)", 43.259960130675154, -2.928538251537945),
/*19*/("Espinosa de Los Monteros", "Espinosa de Los Monteros", "09560, Burgos", 43.07437753075875, -3.5373711004646977),
/*20*/("Cistierna", "Cistierna", "24800 Cistierna, León", 42.80316214592475, -5.130811290366542),
/*21*/("León", "León", "24009 León", 42.59529644590684, -5.581532648919893),
/*22*/("Madrid-Chamartín-Clara Campoamor", "Madrid", "Chamartín, 28036 Madrid", 40.47210452710373, -3.682449506763763),
/*23*/("Madrid-Atocha-Cercanías", "Madrid", "Pl. del Emperador Carlos V, Arganzuela, 28045 Madrid", 40.405031318378256, -3.688269866944005),
/*24*/("Aranjuez", "Aranjuez", "28300 Aranjuez, Madrid", 40.03486044837603, -3.6181864728104984),
/*25*/("Xàtiva", "Xàtiva", "46800 Xàtiva, Valencia", 38.992097860100415, -0.5244983351063605),
/*26*/("Valencia-Estació del Nord", "Valencia", "Carrer d'Alacant, 25, Extramurs, 46004 València, Valencia", 39.466028282263444, -0.3774458907306249);

INSERT INTO parada (ruta_id, estacion_id)
VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(2, 10),
(2, 11),
(2, 12),
(2, 13),
(2, 14),
(2, 15),
(2, 16),
(2, 17),
(3, 18),
(3, 3),
(3, 5),
(3, 6),
(3, 7),
(3, 8),
(3, 9),
(4, 18),
(4, 19),
(4, 20),
(4, 21),
(5, 22),
(5, 23),
(5, 24),
(5, 25),
(5, 26),
(6, 9),
(6, 8),
(6, 7),
(6, 6),
(6, 5),
(6, 4),
(6, 3),
(6, 2),
(6, 1);

INSERT INTO punto_interes (estacion_id, nombre, direccion, descripcion, longitud, latitud)
VALUES
(26, "Ciutat de les Arts i les Ciències", "Quatre Carreres, 46013 Valencia", "Obra del arquitecto valenciano Santiago Calatrava, tiene varios edificios que se han convertido en iconos de la ciudad. Se trata de un complejo de ocio científico y cultural para disfrutar en familia o con amigos que hoy en día ocupa alrededor de dos kilómetros del antiguo cauce del río Turia.
Necesitarás entradas para poder acceder al interior del Hemisfèric, el Museu de les Ciències  y Oceanogràfic y puedes comprarlas por separado o conjuntas, de los edificios que más te interese visitar.", 39.45487252369318, -0.35049511511959186),
(26, "Jardín Botánico de la Universidad de Valencia", "C/ de Quart, 80, Extramurs, 46008 València, Valencia", "Invernadero y jardín botánico universitario con 4500 especies, incluidas palmeras y plantas exóticas.", 39.47551443954715, -0.3863507272502327),
(26, "Torre del Micalet", "Pça. de la Reina, s/n, Ciutat Vella, 46001 València, Valencia", "El Miguelete es una torre de estilo gótico valenciano,​ tiene 51 metros de altura hasta la terraza, los mismos que mide su perímetro, y 63 metros en total. Tiene forma de prisma octogonal y posee 207 escalones.
Es accesible todos los días del año mediante la adquisición de una entrada.", 39.475322014030965, -0.3756316715071305),
(2, "Bar Felipe", "Barrio de Ambasaguas, 16, 48890 Ambasaguas, Biscay", "Almuerzos, comidas, menús. Comida casera y buen ambiente", 43.23796343980198, -3.356788713476831);

INSERT INTO usuario (username, password)
VALUES
("Antonio", "test"),
("abrullc", "12354");

INSERT INTO plan_viaje (nombre)
VALUES
("Visitas viaje Transcantábrico");

INSERT INTO pasaje (ruta_id, usuario_id, salida, llegada, precio, habitacion)
VALUES
(1, 2, "2024-06-22 13:00:00", "2024-06-30 13:00:00", 6500.00, "5B"),
(1, null, "2024-06-22 13:00:00", "2024-06-30 13:00:00", 8900.00, "2A");

INSERT INTO plan_viaje_usuario (plan_viaje_id, usuario_id)
VALUES
(1, 2);

INSERT INTO visita (plan_viaje_id, punto_interes_id, fecha)
VALUES
(1, 4, "2024-06-29 12:00:00");
