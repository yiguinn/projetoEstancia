create database if not exists dbprojetoEstancia
default character set utf8mb4
collate utf8mb4_unicode_ci;
use dbprojetoEstancia;

create table usuario (
idUsuario int auto_increment primary key,
nomeUsuario varchar(255) not null,
telefoneUsuario varchar(11) not null,
emailUsuario varchar(320) not null
);

create table cerimonia (
idCerimonia int auto_increment primary key,
idUsuario int not null,
tipoCerimonia varchar(40) not null,
dataPref date not null,
qtdConvidados int not null,
mensagemCerimonia varchar(5000) not null,
foreign key (idUsuario) references usuario(idUsuario)
);

drop database dbprojetoEstancia;