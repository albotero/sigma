/*Debe especificar los valores de cada dato para el usuario que se va a crear*/

SELECT @Usuario := 'vjimenez';
/*La contraseña es un hash de 123456 <?php echo password_hash("123456", PASSWORD_DEFAULT); ?>*/
SELECT @Contrasena := '$2y$10$2V6Mp4Ut/6dEiuWTyL5Fiu8m/G8W2wr95oyKnDyrw0ZckH3q.SHFK';
SELECT @Tema := 'gris';
SELECT @Nombres := 'Vanessa';
SELECT @Apellidos := 'Jiménez Galeano';
SELECT @Especialidad := 'Periodoncia';
SELECT @Registro := '1152196622';

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
