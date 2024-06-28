<?php

class Database{
    public $dsn = 'mysql:dbname=tienda_itos;host=localhost';
    public $user = 'root';
    public $password = '';

    public function Connection(){
        try {
            $connection = new PDO($this->dsn, $this->user, $this->password);
            return $connection;
        } catch (PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
        }
    }

}

