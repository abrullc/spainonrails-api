-- -----------------------------------------------------
-- Schema "spain_on_rails"
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS spain_on_rails;
CREATE SCHEMA IF NOT EXISTS spain_on_rails DEFAULT CHARACTER SET utf8;
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
    ON DELETE NO ACTION
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
  usuario_id INT NOT NULL,
  salida DATETIME NOT NULL,
  llegada DATETIME NOT NULL,
  precio FLOAT NOT NULL,
  habitacion VARCHAR(20) NOT NULL,
  CONSTRAINT fk_ruta_pasaje
    FOREIGN KEY (ruta_id)
    REFERENCES ruta (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_usuario_pasaje
    FOREIGN KEY (usuario_id)
    REFERENCES usuario (id)
    ON DELETE NO ACTION
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
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_plan_viaje_punto_interes_punto_interes
    FOREIGN KEY (punto_interes_id)
    REFERENCES punto_interes (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);
