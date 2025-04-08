-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 01/04/2025 às 02:59
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
-- Banco de dados: `ruralize1`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `a01_produto`
--

CREATE TABLE `a01_produto` (
  `A01_id` int(11) NOT NULL,
  `A02_categoria_A02_id` int(11) NOT NULL,
  `A01_nome` varchar(255) DEFAULT NULL,
  `A01_descricao` varchar(255) DEFAULT NULL,
  `A01_preco` float DEFAULT NULL,
  `A01_imagem_url` varchar(255) DEFAULT NULL,
  `A01_dataCriacao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `a01_produto`
--

INSERT INTO `a01_produto` (`A01_id`, `A02_categoria_A02_id`, `A01_nome`, `A01_descricao`, `A01_preco`, `A01_imagem_url`, `A01_dataCriacao`) VALUES
(3, 1, 'produto1', 'produto1', 19.99, 'produto1.jpg', '2025-03-30 22:34:44'),
(4, 1, 'produto2', 'produto2', 39.99, 'produto2.jpg', '2025-03-30 22:39:14'),
(6, 2, 'produto3', 'produto3', 59.99, 'produto3.jpg', '2025-03-30 22:55:28'),
(8, 2, 'produto4', 'produto4', 9.99, 'sem-imagem.jpg', '2025-03-30 22:56:28');

-- --------------------------------------------------------

--
-- Estrutura para tabela `a02_categoria`
--

CREATE TABLE `a02_categoria` (
  `A02_id` int(11) NOT NULL,
  `A02_nome` varchar(255) DEFAULT NULL,
  `A02_descricao` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `a02_categoria`
--

INSERT INTO `a02_categoria` (`A02_id`, `A02_nome`, `A02_descricao`) VALUES
(1, 'Suplemento', 'Suplementos em geral'),
(2, 'Remedios', 'Remedios em geral');

-- --------------------------------------------------------

--
-- Estrutura para tabela `a03_usuario`
--

CREATE TABLE `a03_usuario` (
  `A03_id` int(11) NOT NULL,
  `A03_nome` varchar(255) NOT NULL,
  `A03_email` varchar(255) NOT NULL,
  `A03_senha` varchar(20) DEFAULT NULL,
  `A03_cep` varchar(9) DEFAULT NULL,
  `A03_endereco` varchar(255) NOT NULL,
  `A03_bairro` varchar(255) DEFAULT NULL,
  `A03_cidade` varchar(255) DEFAULT NULL,
  `A03_estado` varchar(255) DEFAULT NULL,
  `A03_status` enum('ativo','inativo') DEFAULT 'ativo',
  `A03_dataCadastro` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `a03_usuario`
--

INSERT INTO `a03_usuario` (`A03_id`, `A03_nome`, `A03_email`, `A03_senha`, `A03_cep`, `A03_endereco`, `A03_bairro`, `A03_cidade`, `A03_estado`, `A03_status`, `A03_dataCadastro`) VALUES
(1, 'teste', 'teste@teste.com', '123', '04902-005', 'Avenida Guarapiranga', 'Parque Alves de Lima', 'São Paulo', 'SP', 'ativo', '2025-03-30 22:25:27'),
(7, 'teste2', 'teste2@teste.com', '123', '04902-005', 'Avenida Guarapiranga', 'Parque Alves de Lima', 'São Paulo', 'SP', 'ativo', '2025-03-31 11:03:58');

-- --------------------------------------------------------

--
-- Estrutura para tabela `a04_pedido`
--

CREATE TABLE `a04_pedido` (
  `A04_id` int(11) NOT NULL,
  `A03_Usuario_A03_id` int(11) NOT NULL,
  `A04_total` double DEFAULT NULL,
  `A04_status` enum('pendente','cancelado','pago','entregue','enviado') DEFAULT 'pendente',
  `A04_dataPedido` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `a04_pedido`
--

INSERT INTO `a04_pedido` (`A04_id`, `A03_Usuario_A03_id`, `A04_total`, `A04_status`, `A04_dataPedido`) VALUES
(4, 1, 59.98, 'pendente', '2025-03-31 02:15:03'),
(5, 1, 19.98, 'pendente', '2025-03-31 02:18:41'),
(7, 1, 119.98, 'pendente', '2025-03-31 02:34:37'),
(8, 1, 59.98, 'pendente', '2025-03-31 02:36:24'),
(9, 1, 39.99, 'pendente', '2025-03-31 02:37:41'),
(10, 1, 29.97, 'pendente', '2025-03-31 02:49:31'),
(11, 1, 119.97, 'pendente', '2025-03-31 02:51:08'),
(12, 7, 79.98, 'pendente', '2025-03-31 11:04:18');

-- --------------------------------------------------------

--
-- Estrutura para tabela `a05_item_pedido`
--

CREATE TABLE `a05_item_pedido` (
  `A05_id` int(11) NOT NULL,
  `A01_Produto_A01_id` int(11) NOT NULL,
  `A04_Pedido_A04_id` int(11) NOT NULL,
  `A05_quantidade` int(11) DEFAULT NULL,
  `A05_precoUnitario` double DEFAULT NULL,
  `A05_subTotal` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `a05_item_pedido`
--

INSERT INTO `a05_item_pedido` (`A05_id`, `A01_Produto_A01_id`, `A04_Pedido_A04_id`, `A05_quantidade`, `A05_precoUnitario`, `A05_subTotal`) VALUES
(5, 3, 4, 1, 19.99, 19.99),
(6, 4, 4, 1, 39.99, 39.99),
(7, 8, 5, 2, 9.99, 19.98),
(9, 6, 7, 2, 59.99, 119.98),
(10, 4, 8, 1, 39.99, 39.99),
(11, 3, 8, 1, 19.99, 19.99),
(12, 4, 9, 1, 39.99, 39.99),
(13, 8, 10, 3, 9.99, 29.97),
(14, 4, 11, 3, 39.99, 119.97),
(15, 4, 12, 2, 39.99, 79.98);

-- --------------------------------------------------------

--
-- Estrutura para tabela `a06_pagamento`
--

CREATE TABLE `a06_pagamento` (
  `A06_id` int(11) NOT NULL,
  `A03_Usuario_A03_id` int(11) NOT NULL,
  `A04_Pedido_A04_id` int(11) NOT NULL,
  `A06_formaPagamento` enum('pix','credito','debito','boleto') DEFAULT NULL,
  `A06_status` enum('pendente','aprovado','recusado') DEFAULT NULL,
  `A06_dataPagamento` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `a01_produto`
--
ALTER TABLE `a01_produto`
  ADD PRIMARY KEY (`A01_id`),
  ADD KEY `A01_Produto_FKIndex1` (`A02_categoria_A02_id`),
  ADD KEY `IFK_Rel_01` (`A02_categoria_A02_id`);

--
-- Índices de tabela `a02_categoria`
--
ALTER TABLE `a02_categoria`
  ADD PRIMARY KEY (`A02_id`);

--
-- Índices de tabela `a03_usuario`
--
ALTER TABLE `a03_usuario`
  ADD PRIMARY KEY (`A03_id`),
  ADD UNIQUE KEY `A03_idx_unique_email` (`A03_email`);

--
-- Índices de tabela `a04_pedido`
--
ALTER TABLE `a04_pedido`
  ADD PRIMARY KEY (`A04_id`),
  ADD KEY `A04_Pedido_FKIndex1` (`A03_Usuario_A03_id`),
  ADD KEY `IFK_Rel_05` (`A03_Usuario_A03_id`);

--
-- Índices de tabela `a05_item_pedido`
--
ALTER TABLE `a05_item_pedido`
  ADD PRIMARY KEY (`A05_id`),
  ADD KEY `A01_Produto_A01_id` (`A01_Produto_A01_id`),
  ADD KEY `A05_Item_Pedido_FKIndex2` (`A04_Pedido_A04_id`);

--
-- Índices de tabela `a06_pagamento`
--
ALTER TABLE `a06_pagamento`
  ADD PRIMARY KEY (`A06_id`),
  ADD KEY `A06_Pagamento_FKIndex1` (`A04_Pedido_A04_id`),
  ADD KEY `A06_Pagamento_FKIndex2` (`A03_Usuario_A03_id`),
  ADD KEY `IFK_Rel_06` (`A04_Pedido_A04_id`),
  ADD KEY `IFK_Rel_09` (`A03_Usuario_A03_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `a01_produto`
--
ALTER TABLE `a01_produto`
  MODIFY `A01_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `a02_categoria`
--
ALTER TABLE `a02_categoria`
  MODIFY `A02_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `a03_usuario`
--
ALTER TABLE `a03_usuario`
  MODIFY `A03_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `a04_pedido`
--
ALTER TABLE `a04_pedido`
  MODIFY `A04_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `a05_item_pedido`
--
ALTER TABLE `a05_item_pedido`
  MODIFY `A05_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `a06_pagamento`
--
ALTER TABLE `a06_pagamento`
  MODIFY `A06_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `a01_produto`
--
ALTER TABLE `a01_produto`
  ADD CONSTRAINT `a01_produto_ibfk_1` FOREIGN KEY (`A02_categoria_A02_id`) REFERENCES `a02_categoria` (`A02_id`);

--
-- Restrições para tabelas `a04_pedido`
--
ALTER TABLE `a04_pedido`
  ADD CONSTRAINT `a04_pedido_ibfk_1` FOREIGN KEY (`A03_Usuario_A03_id`) REFERENCES `a03_usuario` (`A03_id`);

--
-- Restrições para tabelas `a05_item_pedido`
--
ALTER TABLE `a05_item_pedido`
  ADD CONSTRAINT `a05_item_pedido_ibfk_1` FOREIGN KEY (`A04_Pedido_A04_id`) REFERENCES `a04_pedido` (`A04_id`),
  ADD CONSTRAINT `a05_item_pedido_ibfk_2` FOREIGN KEY (`A01_Produto_A01_id`) REFERENCES `a01_produto` (`A01_id`);

--
-- Restrições para tabelas `a06_pagamento`
--
ALTER TABLE `a06_pagamento`
  ADD CONSTRAINT `a06_pagamento_ibfk_1` FOREIGN KEY (`A04_Pedido_A04_id`) REFERENCES `a04_pedido` (`A04_id`),
  ADD CONSTRAINT `a06_pagamento_ibfk_2` FOREIGN KEY (`A03_Usuario_A03_id`) REFERENCES `a03_usuario` (`A03_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
