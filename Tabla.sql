CREATE DATABASE base_de_datos_de_registro del formulario;
USE base_de_datos_de_registro del formulario;
CREATE TABLE datos_del_usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    edad INT NOT NULL,
    numero_de_cedula VARCHAR(20) NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    correo_electronico VARCHAR(100) NOT NULL