-- Banco de dados: portal_noticia
CREATE DATABASE IF NOT EXISTS `portal_noticia`;
USE `portal_noticia`;

-- Tabela: usuarios
CREATE TABLE `usuarios` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nome` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) UNIQUE NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  `tipo` ENUM('admin', 'escritor') NOT NULL -- Define o tipo de usuário
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabela: noticias
CREATE TABLE `noticias` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `titulo` VARCHAR(255) NOT NULL,
  `conteudo` TEXT NOT NULL,
  `imagem` VARCHAR(255), -- Caminho da imagem da notícia
  `id_escritor` INT NOT NULL,
  `status` ENUM('pendente', 'aprovada', 'rejeitada') DEFAULT 'pendente', -- Status da notícia
  `data_criacao` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_escritor`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabela: escrito_noticia (associação, opcional)
CREATE TABLE `escrito_noticia` (
  `id_escritor` INT(5) NOT NULL,
  `id_noticia` INT(5) NOT NULL,
  PRIMARY KEY (`id_escritor`, `id_noticia`),
  FOREIGN KEY (`id_escritor`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`id_noticia`) REFERENCES `noticias`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
