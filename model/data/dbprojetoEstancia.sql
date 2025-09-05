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

select * from info;

drop database dbprojetoEstancia;