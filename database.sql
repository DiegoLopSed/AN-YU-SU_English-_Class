CREATE TABLE profesores (
id_profesor INT AUTO_INCREMENT PRIMARY KEY,
nombre VARCHAR(50),
apellido VARCHAR(50),
email VARCHAR(100),
edad INT,
nivel_ingles VARCHAR(50),
contraseña VARCHAR(255)
);

CREATE TABLE clases (
id_clase INT AUTO_INCREMENT PRIMARY KEY,
nombre_clase VARCHAR(100),
id_profesor INT,
FOREIGN KEY (id_profesor) REFERENCES profesores(id_profesor)
);

CREATE TABLE alumnos (
id_alumno INT AUTO_INCREMENT PRIMARY KEY,
nombre VARCHAR(50),
apellido VARCHAR(50),
email VARCHAR(100),
edad INT,
id_clase INT,
contraseña VARCHAR(255),
FOREIGN KEY (id_clase) REFERENCES clases(id_clase)
);