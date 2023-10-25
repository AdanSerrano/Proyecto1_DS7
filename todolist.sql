-- Tabla de Tipos de Tarea
CREATE TABLE TiposTarea (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    NombreTipo VARCHAR(255) NOT NULL
);

-- Insertar algunos tipos de tarea por defecto (puedes agregar más según sea necesario)
INSERT INTO TiposTarea (NombreTipo) VALUES ('Trabajo'), ('Estudio'), ('Personal');

-- Tabla de Tareas
CREATE TABLE Tareas (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Titulo VARCHAR(255) NOT NULL,
    Descripcion TEXT,
    Estado ENUM('por hacer', 'en progreso', 'terminada') NOT NULL,
    FechaCompromiso DATETIME NOT NULL,
    EtiquetaEditado BOOLEAN NOT NULL,
    Responsable VARCHAR(255) NOT NULL,
    TipoTareaID INT,
    FOREIGN KEY (TipoTareaID) REFERENCES TiposTarea(ID)
);


SELECT TT.NombreTipo, T.Estado, COUNT(*) as TotalTareas
FROM Tareas T
JOIN TiposTarea TT ON T.TipoTareaID = TT.ID
GROUP BY TT.NombreTipo, T.Estado;
