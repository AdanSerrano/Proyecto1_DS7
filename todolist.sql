-- Tabla de Usuarios
CREATE TABLE Usuarios (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    NombreUsuario VARCHAR(255) NOT NULL,
    CorreoElectronico VARCHAR(255) NOT NULL,
    ContrasenaHash VARCHAR(255) NOT NULL, 
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

-- CREATE TABLE tareas (
--     ID INT PRIMARY KEY AUTO_INCREMENT,
    -- Titulo VARCHAR(255) NOT NULL,
    -- Descripcion TEXT,
    -- Estado ENUM('por hacer', 'en progreso', 'terminada') NOT NULL,
    -- FechaCompromiso DATE NOT NULL, 
    -- EtiquetaEditado BOOLEAN NOT NULL,
    -- Responsable VARCHAR(255) NOT NULL,
    -- TipoTarea INT,
-- );


SELECT TT.NombreTipo, T.Estado, COUNT(*) as TotalTareas
FROM Tareas T
JOIN TiposTarea TT ON T.TipoTareaID = TT.ID
GROUP BY TT.NombreTipo, T.Estado;
