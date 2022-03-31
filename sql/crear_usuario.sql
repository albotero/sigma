/*Debe especificar los valores de cada dato para el usuario que se va a crear*/

SELECT @Usuario := 'abotero';
/*La contraseña es un hash de 123456 <?php echo password_hash("123456", PASSWORD_DEFAULT); ?>*/
SELECT @Contrasena := '$2y$10$2V6Mp4Ut/6dEiuWTyL5Fiu8m/G8W2wr95oyKnDyrw0ZckH3q.SHFK';
SELECT @Tema := '';
SELECT @Nombres := 'Alejandro';
SELECT @Apellidos := 'Botero Fernández';
SELECT @Especialidad := 'Anestesiología y Reanimación';
SELECT @Registro := '1128456678';

INSERT INTO usuarios
VALUES (
    @Usuario,
    @Contrasena,
    @Tema,
    @Nombres,
    @Apellidos,
    @Especialidad,
    @Registro
);
