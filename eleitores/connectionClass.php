<?php
include_once("../connections/banco.php");
class connectionClass extends mysqli{
    public $host=HOST,$dbname=DB,$dbpass=PASS,$dbuser=USER;
    public $con;
    
    public function __construct() {
        if($this->connect($this->host, $this->dbuser, $this->dbpass, $this->dbname)){}
        else
        {
            return "<h1>Erro ao conectar Banco de Dados</h1>";
        }
    }
}
