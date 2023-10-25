-- Tabla de Usuarios
CREATE TABLE Usuarios (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    NombreUsuario VARCHAR(255) NOT NULL,
    FechaRegistro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Tipos de Tarea
CREATE TABLE TiposTarea (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    NombreTipo VARCHAR(255) NOT NULL
);

-- Tabla de Tareas
CREATE TABLE Tareas (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Titulo VARCHAR(255) NOT NULL,
    Descripcion TEXT,
    Estado ENUM('por hacer', 'en progreso', 'terminada') NOT NULL,
    FechaCompromiso DATE NOT NULL, 
    EtiquetaEditado BOOLEAN NOT NULL,
    Responsable VARCHAR(255) NOT NULL,
    TipoTareaID INT,
    UsuarioID INT,
    FOREIGN KEY (TipoTareaID) REFERENCES TiposTarea(ID),
    FOREIGN KEY (UsuarioID) REFERENCES Usuarios(ID)
);

-- insertar datos en la tabla de usuarios
INSERT INTO Usuarios (NombreUsuario) VALUES ('Juan');

-- insertar datos en la tabla de tipos de tarea
INSERT INTO TiposTarea (NombreTipo) VALUES ('Universidad'), ('Trabajo'), ('Escuela');

-- insertar datos en la tabla de tareas
INSERT INTO Tareas (Titulo, Descripcion, Estado, FechaCompromiso, EtiquetaEditado, Responsable, TipoTareaID, UsuarioID) VALUES ('Tarea 1', 'Descripcion de la tarea 1', 'por hacer', '2021-10-01', 0, 'Juan', 1, 1), ('Tarea 2', 'Descripcion de la tarea 2', 'en progreso', '2021-10-02', 0, 'Juan', 2, 1), ('Tarea 3', 'Descripcion de la tarea 3', 'terminada', '2021-10-03', 0, 'Juan', 3, 1);

-- Procedimiento Almacenado para mostrar las tareas
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_mostrar_tarea`()
BEGIN
    SELECT * FROM Tareas;
END

-- Procedimiento Almacenado para mostrar las tareas por usuario y el total de tareas por estado
SELECT Usuarios.NombreUsuario, Tareas.Estado, COUNT(*) AS Total FROM Tareas INNER JOIN Usuarios ON Tareas.UsuarioID = Usuarios.ID GROUP BY Usuarios.NombreUsuario, Tareas.Estado;