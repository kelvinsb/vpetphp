SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE DATABASE vpet;
USE vpet;

CREATE TABLE `usuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(45) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `pet` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `happy` int(11) DEFAULT NULL,
  `hunger` int(11) DEFAULT NULL,
  `health` int(11) DEFAULT NULL,
  `sick` tinyint(1) DEFAULT NULL,
  `tired` int(11) DEFAULT NULL,
  `dirty` int(11) DEFAULT NULL,
  `sad` tinyint(1) DEFAULT NULL,
  `sleeping` tinyint(1) DEFAULT NULL,
  `faliceu` tinyint(1) DEFAULT NULL,
  `usuario_id` int(11) NOT NULL,
  `deltaTime` datetime(1) DEFAULT NULL,
  `lights` tinyint(1) DEFAULT NULL,
  `pontos` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_pet_usuario1_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_pet_usuario1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB DEFAULT CHARSET=utf8mb4;


