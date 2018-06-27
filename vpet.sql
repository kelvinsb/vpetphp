SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE vpet;
USE vpet;

CREATE TABLE `game` (
  `id` int(11) NOT NULL,
  `game_name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `game` (`id`, `game_name`) VALUES
(1, 'VPet');

CREATE TABLE `pet` (
  `id` int(11) NOT NULL,
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
  `lights` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `usuario` varchar(45) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `game_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `usuario` (`id`, `usuario`, `senha`, `email`, `game_id`) VALUES
(1, 'teste', '123456', 'teste@teste.com.br', 1);


ALTER TABLE `game`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `pet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pet_usuario1_idx` (`usuario_id`);

ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuario_game1_idx` (`game_id`);

ALTER TABLE `game`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `pet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;


ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `pet`
  ADD CONSTRAINT `fk_pet_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_game1` FOREIGN KEY (`game_id`) REFERENCES `game` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
