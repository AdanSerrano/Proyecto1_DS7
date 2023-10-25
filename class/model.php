<?php
require_once('config.php');

class modeloCredencialesBD
{
    protected $_db;
    public function __construct()
    {
        $this->_db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        if ($this->_db->connect_errno) {
            echo "Fallo al conectar a MySQL a la base de datos: (" . $this->_db->connect_errno . ") ";
            return;
        }
    }
}

class Todolist extends modeloCredencialesBD
{
    public function agregarTarea($titulo, $descripcion, $estado, $fechaCompromiso, $responsable, $tipoTareaID)
    {
        $titulo = $this->_db->real_escape_string($titulo);
        $descripcion = $this->_db->real_escape_string($descripcion);
        $estado = $this->_db->real_escape_string($estado);
        $fechaCompromiso = $this->_db->real_escape_string($fechaCompromiso);
        $responsable = $this->_db->real_escape_string($responsable);
        $tipoTareaID = intval($tipoTareaID);

        $query = "INSERT INTO Tareas (Titulo, Descripcion, Estado, FechaCompromiso, EtiquetaEditado, Responsable, TipoTareaID) VALUES ('$titulo', '$descripcion', '$estado', '$fechaCompromiso', 0, '$responsable', $tipoTareaID)";
        $result = $this->_db->query($query);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function obtenerTareas()
    {
        $query = "SELECT * FROM Tareas";
        $result = $this->_db->query($query);
        $tareas = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tareas[] = $row;
            }
        }

        return $tareas;
    }
}
