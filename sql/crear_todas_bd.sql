CREATE DATABASE IF NOT EXISTS sigma;
USE sigma;

CREATE TABLE IF NOT EXISTS Pacientes (
    Tipo_ID varchar(4),
    ID varchar(16),
    Nombres varchar(32),
    Apellidos varchar(32),
    Genero varchar(10),
    Fecha_Nacimiento date,
    Grupo_Sanguineo varchar(4),
    Estado_Civil varchar(16),
    Ocupacion varchar(64),
    EPS varchar(32),
    Afiliacion varchar(16),
    Emergencia_Nombre varchar(32),
    Emergencia_Telefono varchar(16),
    Celular varchar(16),
    Telefono varchar(16),
    Email varchar(64),
    Direccion varchar(128),
    Ciudad varchar(32),
    Alertas varchar(512)
);

CREATE TABLE IF NOT EXISTS Usuarios (
    Usuario varchar(16),
    Contrasena varchar(256),
    Tema varchar(32),
    Nombres varchar(32),
    Apellidos varchar(32),
    Especialidad varchar(32),
    Registro varchar(16)
);

CREATE TABLE IF NOT EXISTS Historias (
    Consecutivo smallint,
    Carpeta varchar(16),
    Creacion datetime,
    UsuarioCreacion varchar(16),
    Firma datetime,
    UsuarioFirma varchar(16),
    PacienteTipoId varchar(4),
    PacienteId varchar(16)
);