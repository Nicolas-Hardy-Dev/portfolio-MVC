<?php

namespace App\Core;

use PDO;
use Exception;

class DbConnect 
{
    protected $connection;
    protected $request;

    public function __construct() 
    {
       $config = require __DIR__ . '/../config/database.php'; 

       try {
        $this->connection = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'] . ';charset=utf8mb4', $config['user'], $config['password']);

        // Activation erreurs PDO
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //Retours de requêtes sous forme de Tableau objet
        $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
       } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
       }
    }
}