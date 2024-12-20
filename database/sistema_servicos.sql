-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 18/12/2024 às 15:42
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sistema_servicos`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `cadastros_servicos`
--

CREATE TABLE `cadastros_servicos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `servico_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `confirmados`
--

CREATE TABLE `confirmados` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `servico_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `confirmados`
--

INSERT INTO `confirmados` (`id`, `usuario_id`, `servico_id`) VALUES
(1, 2, 3),
(3, 2, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `selecionados`
--

CREATE TABLE `selecionados` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `servico_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `selecionados`
--

INSERT INTO `selecionados` (`id`, `usuario_id`, `servico_id`) VALUES
(1, 1, 1),
(2, 1, 1),
(3, 2, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `servicos`
--

CREATE TABLE `servicos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text NOT NULL,
  `quantidade` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `servicos`
--

INSERT INTO `servicos` (`id`, `nome`, `descricao`, `quantidade`) VALUES
(1, 'sdasd', 'asdasdsa', 0),
(2, 'teste', 'sddas', 1),
(3, 'Maria sddsdsd', 'dasd', 4),
(4, 'Po 9', 'sada', 4);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `is_admin`) VALUES
(1, 'João Fernando', 'maria@exemplo.com', '$2y$10$wuYTn18eWr6iZg86lN6wye3RGBcS9wuxzK/ng.g.gKMdajdhpzYpi', 0),
(2, 'Pedro Augusto ew', 'adrianocursos04@gmail.com', '$2y$10$nBJNKAMMGwKK1CbQE0TtruZlwl4AbmuRbD67dfyMaMxAuTJB.jc0G', 0),
(4, 'ROSA CANDIDA PINHEIRO SOUZA', 'direto.passei965@gmal.com', '$2y$10$MQ9PR1cpXwFx6/CigokkROJHNorReJQed73HYiGvFB1owdgxLZmQm', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `voluntarios`
--

CREATE TABLE `voluntarios` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `servico_id` int(11) NOT NULL,
  `estado` enum('inscrito','escalado') NOT NULL DEFAULT 'inscrito'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `voluntarios`
--

INSERT INTO `voluntarios` (`id`, `usuario_id`, `servico_id`, `estado`) VALUES
(2, 2, 1, 'inscrito'),
(3, 2, 1, 'inscrito'),
(4, 2, 1, 'inscrito'),
(5, 2, 1, 'inscrito'),
(6, 2, 1, 'inscrito'),
(9, 1, 1, 'inscrito'),
(10, 1, 1, 'inscrito'),
(11, 1, 1, 'inscrito'),
(12, 1, 1, 'inscrito'),
(13, 1, 1, 'inscrito'),
(14, 1, 1, 'inscrito'),
(15, 1, 1, 'inscrito'),
(16, 1, 1, 'inscrito'),
(17, 1, 1, 'inscrito'),
(18, 1, 1, 'inscrito'),
(22, 1, 3, 'escalado'),
(23, 2, 2, 'inscrito'),
(24, 2, 3, 'escalado'),
(25, 1, 2, 'escalado'),
(26, 1, 4, 'escalado'),
(27, 4, 4, 'escalado'),
(28, 4, 3, 'escalado'),
(29, 4, 2, 'escalado'),
(30, 4, 1, 'inscrito'),
(31, 2, 4, 'inscrito');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `cadastros_servicos`
--
ALTER TABLE `cadastros_servicos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `servico_id` (`servico_id`);

--
-- Índices de tabela `confirmados`
--
ALTER TABLE `confirmados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `servico_id` (`servico_id`);

--
-- Índices de tabela `selecionados`
--
ALTER TABLE `selecionados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `servico_id` (`servico_id`);

--
-- Índices de tabela `servicos`
--
ALTER TABLE `servicos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `voluntarios`
--
ALTER TABLE `voluntarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `servico_id` (`servico_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cadastros_servicos`
--
ALTER TABLE `cadastros_servicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `confirmados`
--
ALTER TABLE `confirmados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `selecionados`
--
ALTER TABLE `selecionados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `servicos`
--
ALTER TABLE `servicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `voluntarios`
--
ALTER TABLE `voluntarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `cadastros_servicos`
--
ALTER TABLE `cadastros_servicos`
  ADD CONSTRAINT `cadastros_servicos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `cadastros_servicos_ibfk_2` FOREIGN KEY (`servico_id`) REFERENCES `servicos` (`id`);

--
-- Restrições para tabelas `confirmados`
--
ALTER TABLE `confirmados`
  ADD CONSTRAINT `confirmados_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `confirmados_ibfk_2` FOREIGN KEY (`servico_id`) REFERENCES `servicos` (`id`);

--
-- Restrições para tabelas `selecionados`
--
ALTER TABLE `selecionados`
  ADD CONSTRAINT `selecionados_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `selecionados_ibfk_2` FOREIGN KEY (`servico_id`) REFERENCES `servicos` (`id`);

--
-- Restrições para tabelas `voluntarios`
--
ALTER TABLE `voluntarios`
  ADD CONSTRAINT `voluntarios_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `voluntarios_ibfk_2` FOREIGN KEY (`servico_id`) REFERENCES `servicos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
