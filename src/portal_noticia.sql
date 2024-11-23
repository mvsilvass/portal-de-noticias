-- Criação do banco de dados
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

-- Tabela: categorias (para categorizar as notícias)
CREATE TABLE `categorias` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nome` VARCHAR(100) NOT NULL UNIQUE -- Nome da categoria
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Inserindo algumas categorias iniciais
INSERT INTO `categorias` (`nome`) VALUES 
('Esportes'),
('Tecnologia'),
('Entretenimento');

-- Tabela: noticias
CREATE TABLE `noticias` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `titulo` VARCHAR(255) NOT NULL,
  `conteudo` TEXT NOT NULL,
  `id_escritor` INT NOT NULL,
  `id_categoria` INT NOT NULL, -- Relaciona a categoria da notícia
  `status` ENUM('pendente', 'aprovada', 'rejeitada') DEFAULT 'pendente', -- Status da notícia
  `data_criacao` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_escritor`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`id_categoria`) REFERENCES `categorias`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabela: escrito_noticia (associação entre escritor e notícia)
CREATE TABLE `escrito_noticia` (
  `id_escritor` INT(5) NOT NULL,
  `id_noticia` INT(5) NOT NULL,
  PRIMARY KEY (`id_escritor`, `id_noticia`),
  FOREIGN KEY (`id_escritor`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`id_noticia`) REFERENCES `noticias`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
