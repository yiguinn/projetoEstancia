-- =================================================================
-- Script para a CRIAÇÃO INICIAL do banco de dados e tabelas
-- =================================================================

-- 1. Cria o banco de dados 'dbprojetoEstancia' se ele ainda não existir.
CREATE DATABASE IF NOT EXISTS `dbprojetoEstancia` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- 2. Seleciona o banco de dados recém-criado para os próximos comandos.
USE `dbprojetoEstancia`;

-- -----------------------------------------------------
-- Tabela `users`: Armazena tanto usuários comuns quanto administradores
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `telefone` VARCHAR(20) NOT NULL,
  `password` VARCHAR(255) NOT NULL COMMENT 'Senha deve ser armazenada com hash (password_hash)',
  `role` ENUM('user', 'admin') NOT NULL DEFAULT 'user' COMMENT 'Define se é usuário comum ou administrador',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Tabela `info`: Armazena as solicitações de contato do formulário
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `info` (
  `idUsuario` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NULL DEFAULT NULL COMMENT 'Chave estrangeira para a tabela `users`. Nulo se o envio for de um visitante.',
  `nomeUsuario` VARCHAR(255) NULL,
  `telefoneUsuario` VARCHAR(45) NULL,
  `emailUsuario` VARCHAR(255) NULL,
  `tipoCerimonia` VARCHAR(255) NULL,
  `dataPref` DATE NULL,
  `qtdConvidados` INT NULL,
  `mensagemCerimonia` TEXT NULL,
  PRIMARY KEY (`idUsuario`),
  INDEX `fk_info_users_idx` (`user_id` ASC),
  CONSTRAINT `fk_info_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Tabela `galeria_imagens`: Armazena as imagens das galerias do site
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `galeria_imagens` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(255) NOT NULL,
  `caminho_arquivo` VARCHAR(255) NOT NULL COMMENT 'Apenas o nome do arquivo, ex: img_hash.jpg',
  `categoria` ENUM('casamento', 'cerimonia', 'decoracao', 'espaco', 'evento', 'recepcao') NOT NULL,
  `visivel` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '1 = Visível no site, 0 = Oculto',
  `uploaded_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;
-- Seleciona o banco de dados correto

-- Tabela para armazenar os serviços parceiros (DJ, Fotógrafo, etc.)
CREATE TABLE IF NOT EXISTS `parceiros` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `chave` VARCHAR(50) NOT NULL COMMENT 'Identificador único, ex: "dj", "fotografo"',
  `titulo` VARCHAR(255) NOT NULL,
  `descricao` TEXT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `chave_UNIQUE` (`chave` ASC))
ENGINE = InnoDB;

-- Tabela para armazenar as imagens de cada parceiro
CREATE TABLE IF NOT EXISTS `parceiros_imagens` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `parceiro_id` INT NOT NULL COMMENT 'Chave estrangeira para a tabela `parceiros`',
  `caminho_arquivo` VARCHAR(255) NOT NULL,
  `titulo_alt` VARCHAR(255) NULL,
  `visivel` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  INDEX `fk_imagens_parceiro_idx` (`parceiro_id` ASC),
  CONSTRAINT `fk_imagens_parceiro`
    FOREIGN KEY (`parceiro_id`)
    REFERENCES `parceiros` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

-- Vamos pré-popular a tabela de parceiros com os serviços que você já tem
INSERT INTO `parceiros` (`chave`, `titulo`, `descricao`) VALUES
('fotografo', 'Fotografia Profissional', 'Nossa equipe de fotógrafos parceiros é especialista em casamentos, capturando a emoção e a beleza do seu grande dia com um olhar artístico e sensível.'),
('dj', 'Som & DJ', 'A trilha sonora do seu evento é fundamental. Nossos DJs parceiros criam o clima perfeito para cada momento, com playlists personalizadas e equipamentos de ponta.'),
('bartender', 'Serviço de Bar', 'Surpreenda seus convidados com um serviço de bar premium. Nossos parceiros oferecem desde drinks clássicos a criações exclusivas.'),
('cerimonialista', 'Cerimonialista', 'Para que você possa relaxar e aproveitar cada segundo, nossos cerimonialistas cuidam de todo o planejamento, organização e coordenação do evento.');

-- Mensagem de sucesso
SELECT 'Banco de dados e tabelas criados com sucesso!' AS `status`;
select * from info;
select * from galeria_imagens;
drop database dbprojetoEstancia;