USE sigma;

SET @Usuario := 'usuario';
SET @Contrasena := 'value';
SET @Tema := '';
SET @Nombres := 'Alejandro';
SET @Apellidos := 'Botero Fernández';
SET @Especialidad := 'Anestesiología y Reanimación';
SET @Registro := '1128456678';

INSERT INTO Usuarios
VALUES (
    @Usuario varchar(16),
    @Contrasena varchar(256),
    @Tema varchar(32),
    @Nombres varchar(32),
    @Apellidos varchar(32),
    @Especialidad varchar(32),
    @Registro varchar(16)
);