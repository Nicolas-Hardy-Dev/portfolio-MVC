<?php

namespace App\Controllers;

abstract class Controller 
{
    public function render(string $path, array $data = [])
    {
        // On extrait les données sous forme de variables
        extract($data);

        // On créé le buffer de sortie (espace de stockage temporaire)
        ob_start();

        // On crée le chemin et inclut le fichier de la vue souhaitée
        include dirname(__DIR__) . '/Views/' . $path . '.php';

        // On vide le buffer dans les variables $title (géré sur la vue directement) et $content
        $content = ob_get_clean();

        // On fabrique le template
        include dirname(__DIR__) . '/Views/base.php';
    }
}