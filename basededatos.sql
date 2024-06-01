CREATE DATABASE sgvur;

CREATE TABLE `sgvur`.`usuarios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(11) NOT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  `apellido` VARCHAR(100) NOT NULL,
  `password` TEXT NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `sgvur`.`unidad` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `sgvur`.`vehiculos` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `marca` VARCHAR(45) NULL,
    `modelo` VARCHAR(45) NULL,
    `tipo` ENUM('Moto', 'Carro') NOT NULL,
    `placa` VARCHAR(7) NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `sgvur`.`registro` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `usuario_id` INT NOT NULL,
  `vehiculo_id` INT NOT NULL,
  `unidad_id` INT NOT NULL,
  `fecha` DATETIME NOT NULL DEFAULT NOW(),
  `tipo` ENUM('ENTRADA', 'SALIDA') NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_registro_usuario_idx` (`usuario_id` ASC) VISIBLE,
  INDEX `fk_registro_vehiculo_idx` (`vehiculo_id` ASC) VISIBLE,
  INDEX `fk_registro_unidad_idx` (`unidad_id` ASC) VISIBLE,
  CONSTRAINT `fk_registro_usuario`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `sgvur`.`usuarios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_registro_vehiculo`
    FOREIGN KEY (`vehiculo_id`)
    REFERENCES `sgvur`.`vehiculos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_registro_unidad`
    FOREIGN KEY (`unidad_id`)
    REFERENCES `sgvur`.`unidad` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);