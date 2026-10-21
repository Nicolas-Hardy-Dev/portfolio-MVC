<?php
namespace App\Core;

class Router 
{
    public function routes() 
    {
        // On crée la variable controller dans laquelle on va stocker le controller demandé. Première lettre en Majuscule et 'home' par défaut.
        $controller = (isset($_GET['controller']) ? ucfirst(array_shift($_GET)) : 'Home');
        // On fabrique le nom complet de la classe. '\\' : un qui échappe et l'autre s'affiche.
        $controller = '\\App\\Controllers\\' . $controller . 'Controller';

        // Pareil que pour le controller, sauf que l'on stocke l'action demandée.
        $action = (isset($_GET['action']) ? array_shift($_GET) : 'index');
        
        // On vérifie l'existence du controller demandé, puis on lui indique la méthode ($action) à exécuter, ou dans le cas contraire l'erreur à afficher.
        if (class_exists($controller) && method_exists($controller, $action)){
             // On instancie le controller
            $controller = new $controller();
            
            // !empty plutôt que isset car $_GET existe toujours (isset toujours vrai), là on vérifie s'il contient d'autres paramètres.
            (!empty($_GET)) ? call_user_func_array([$controller, $action], $_GET) : $controller->$action();
        } else {
            http_response_code(404);
            echo "La page recherchée n'existe pas.";
        }
    }

}