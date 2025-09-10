create database if not exists dbprojetoEstancia
default character set utf8mb4
collate utf8mb4_unicode_ci;
use dbprojetoEstancia;

create table info (
idUsuario int auto_increment primary key,
nomeUsuario varchar(255) not null,
telefoneUsuario varchar(15) not null,
emailUsuario varchar(320) not null,
tipoCerimonia varchar(40) not null,
dataPref date not null,
qtdConvidados int not null,
mensagemCerimonia varchar(500) not null
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    telefone VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

select * from info;

drop database dbprojetoEstancia;