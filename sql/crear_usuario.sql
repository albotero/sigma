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
    @Usuario,
    @Contrasena,
    @Tema,
    @Nombres,
    @Apellidos,
    @Especialidad,
    @Registro
);