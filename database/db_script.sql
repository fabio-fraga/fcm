-- MySQL Script generated by MySQL Workbench
-- Wed Apr 19 01:06:00 2023
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema FCM
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema FCM
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `FCM` DEFAULT CHARACTER SET utf8 ;
USE `FCM` ;

-- -----------------------------------------------------
-- Table `FCM`.`FCM_USUARIOS`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `FCM`.`FCM_USUARIOS` (
  `USU_CODIGO` INT NOT NULL AUTO_INCREMENT,
  `USU_NOME` VARCHAR(45) NOT NULL,
  `USU_NASCIMENTO` DATE NOT NULL,
  `USU_CPF` VARCHAR(11) NOT NULL,
  `USU_EMAIL` VARCHAR(256) NOT NULL,
  `USU_CELULAR` VARCHAR(11) NOT NULL,
  `USU_FOTO_PERFIL` VARCHAR(45) NULL,
  `USU_ENDERECO` VARCHAR(256) NOT NULL,
  `USU_SENHA` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`USU_CODIGO`),
  UNIQUE INDEX `USU_EMAIL_UNIQUE` (`USU_EMAIL` ASC) VISIBLE,
  UNIQUE INDEX `USU_CPF_UNIQUE` (`USU_CPF` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `FCM`.`FCM_FUNCOES`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `FCM`.`FCM_FUNCOES` (
  `FUN_CODIGO` INT NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`FUN_CODIGO`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `FCM`.`FCM_COMERCIANTES`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `FCM`.`FCM_COMERCIANTES` (
  `CMR_CODIGO` INT NOT NULL AUTO_INCREMENT,
  `CMR_APELIDO` VARCHAR(45) NOT NULL,
  `CMR_DESCRICAO` VARCHAR(250) NULL,
  `CMR_CELULAR` VARCHAR(11) NOT NULL,
  `CMR_FOTO_PERFIL` VARCHAR(45) NULL,
  `CMR_ENDERECO` VARCHAR(256) NOT NULL,
  `CMR_FUN_CODIGO` INT NOT NULL,
  PRIMARY KEY (`CMR_CODIGO`),
  INDEX `fk_FCM_COMERCIANTES_FCM_FUNCOES1_idx` (`CMR_FUN_CODIGO` ASC) VISIBLE,
  CONSTRAINT `fk_FCM_COMERCIANTES_FCM_FUNCOES1`
    FOREIGN KEY (`CMR_FUN_CODIGO`)
    REFERENCES `FCM`.`FCM_FUNCOES` (`FUN_CODIGO`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `FCM`.`FCM_ENTREGADORES`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `FCM`.`FCM_ENTREGADORES` (
  `ENT_CODIGO` INT NOT NULL AUTO_INCREMENT,
  `ENT_CELULAR` VARCHAR(11) NOT NULL,
  `ENT_ENDERECO` VARCHAR(256) NOT NULL,
  `ENT_FOTO_PERFIL` VARCHAR(45) NULL,
  `ENT_DESCRICAO` VARCHAR(250) NULL,
  `ENT_FUN_CODIGO` INT NOT NULL,
  PRIMARY KEY (`ENT_CODIGO`),
  INDEX `fk_FCM_ENTREGADORES_FCM_FUNCOES1_idx` (`ENT_FUN_CODIGO` ASC) VISIBLE,
  CONSTRAINT `fk_FCM_ENTREGADORES_FCM_FUNCOES1`
    FOREIGN KEY (`ENT_FUN_CODIGO`)
    REFERENCES `FCM`.`FCM_FUNCOES` (`FUN_CODIGO`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `FCM`.`FCM_PEDIDOS`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `FCM`.`FCM_PEDIDOS` (
  `PED_CODIGO` INT NOT NULL AUTO_INCREMENT,
  `PED_DATA` DATETIME NOT NULL,
  `PED_QUANTIDADE` INT NOT NULL,
  `PED_VALOR` DECIMAL NOT NULL,
  `PED_TIPO` VARCHAR(8) NOT NULL,
  `PED_ENTREGA_ACEITA` CHAR(1) NULL,
  `PED_FINALIZADO` CHAR(1) NOT NULL,
  `PED_USU_CODIGO` INT NOT NULL,
  `PED_CMR_CODIGO` INT NOT NULL,
  `PED_ENT_CODIGO` INT NULL,
  PRIMARY KEY (`PED_CODIGO`),
  INDEX `fk_FCM_PEDIDOS_FCM_COMERCIANTES1_idx` (`PED_CMR_CODIGO` ASC) VISIBLE,
  INDEX `fk_FCM_PEDIDOS_FCM_ENTREGADORES1_idx` (`PED_ENT_CODIGO` ASC) VISIBLE,
  INDEX `fk_FCM_PEDIDOS_FCM_USUARIOS1_idx` (`PED_USU_CODIGO` ASC) VISIBLE,
  CONSTRAINT `fk_FCM_PEDIDOS_FCM_COMERCIANTES1`
    FOREIGN KEY (`PED_CMR_CODIGO`)
    REFERENCES `FCM`.`FCM_COMERCIANTES` (`CMR_CODIGO`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_FCM_PEDIDOS_FCM_ENTREGADORES1`
    FOREIGN KEY (`PED_ENT_CODIGO`)
    REFERENCES `FCM`.`FCM_ENTREGADORES` (`ENT_CODIGO`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_FCM_PEDIDOS_FCM_USUARIOS1`
    FOREIGN KEY (`PED_USU_CODIGO`)
    REFERENCES `FCM`.`FCM_USUARIOS` (`USU_CODIGO`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `FCM`.`FCM_PRODUTOS`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `FCM`.`FCM_PRODUTOS` (
  `PRO_CODIGO` INT NOT NULL AUTO_INCREMENT,
  `PRO_NOME` VARCHAR(45) NOT NULL,
  `PRO_VALOR` DECIMAL NOT NULL,
  `PRO_CATEGORIA` VARCHAR(45) NOT NULL,
  `PRO_DESCRICAO` VARCHAR(500) NULL,
  PRIMARY KEY (`PRO_CODIGO`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `FCM`.`FCM_PEDIDOS_PRODUTOS`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `FCM`.`FCM_PEDIDOS_PRODUTOS` (
  `PEP_PED_CODIGO` INT NOT NULL,
  `PEP_PRO_CODIGO` INT NOT NULL,
  PRIMARY KEY (`PEP_PED_CODIGO`, `PEP_PRO_CODIGO`),
  INDEX `fk_FCM_PRODUTOS_has_FCM_PEDIDOS_FCM_PEDIDOS1_idx` (`PEP_PED_CODIGO` ASC) VISIBLE,
  INDEX `fk_FCM_PRODUTOS_has_FCM_PEDIDOS_FCM_PRODUTOS1_idx` (`PEP_PRO_CODIGO` ASC) VISIBLE,
  CONSTRAINT `fk_FCM_PRODUTOS_has_FCM_PEDIDOS_FCM_PRODUTOS1`
    FOREIGN KEY (`PEP_PRO_CODIGO`)
    REFERENCES `FCM`.`FCM_PRODUTOS` (`PRO_CODIGO`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_FCM_PRODUTOS_has_FCM_PEDIDOS_FCM_PEDIDOS1`
    FOREIGN KEY (`PEP_PED_CODIGO`)
    REFERENCES `FCM`.`FCM_PEDIDOS` (`PED_CODIGO`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `FCM`.`FCM_USUARIOS_FUNCOES`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `FCM`.`FCM_USUARIOS_FUNCOES` (
  `USF_USU_CODIGO` INT NOT NULL,
  `USF_FUN_CODIGO` INT NOT NULL,
  PRIMARY KEY (`USF_USU_CODIGO`, `USF_FUN_CODIGO`),
  INDEX `fk_FCM_USUARIOS_has_FCM_FUNCOES_FCM_FUNCOES1_idx` (`USF_FUN_CODIGO` ASC) VISIBLE,
  INDEX `fk_FCM_USUARIOS_FUNCOES_FCM_USUARIOS1_idx` (`USF_USU_CODIGO` ASC) VISIBLE,
  CONSTRAINT `fk_FCM_USUARIOS_has_FCM_FUNCOES_FCM_FUNCOES1`
    FOREIGN KEY (`USF_FUN_CODIGO`)
    REFERENCES `FCM`.`FCM_FUNCOES` (`FUN_CODIGO`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_FCM_USUARIOS_FUNCOES_FCM_USUARIOS1`
    FOREIGN KEY (`USF_USU_CODIGO`)
    REFERENCES `FCM`.`FCM_USUARIOS` (`USU_CODIGO`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
