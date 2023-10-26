<?php
    require_once('config.php');

    class modeloCredencialesBD{
        protected $_db;
        public function __construct(){
            $this->_db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
            if($this->_db->connect_errno){
                echo "Fallo al conectar a MySQL a la base de datos: (" . $this->_db->connect_errno . ") " ;
                return;
            }
        }
    }
?>    
