<?php

namespace App;

class Autoloader 
{
    public static function register(): void {
        spl_autoload_register([__CLASS__, 'autoload']);
    }

    public static function autoload(string $class): void 
    {    
        // Contient "App\", pour éviter de le répéter.
        $prefixe = __NAMESPACE__ . '\\';
        
        // On ne traite que les classes présentes dans le namespace 'App\'
        // strpos() au lieu de str_starts_with(), absente du serveur (PHP < 8.0)
        if (strpos($class, $prefixe) !== 0) { return; }
        
        // On enlève d'abord le préfixe.
        $relative = substr($class, strlen($prefixe) );
        // On remplace les antislashs restants par des slashs.
        $path = str_replace('\\', '/', $relative);
        // Chemin absolu et inclusion si existant
        $file = __DIR__ . '/' . $path . '.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }
}