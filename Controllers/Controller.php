<?php

namespace App\Controllers;

abstract class Controller 
{
    public function render(string $path, array $data = [])
    {
        // on extrait les données sous forme de variables
        extract($data);

        // On crée le chemin et inclut le fichier de la vue souhaitée
        include dirname(__DIR__) . '/Views/' . $path . '.php';
    }
}