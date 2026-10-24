<?php

namespace App\Core;

class FileUploader 
{
    public static function upload(array $file, string $folder): array
    {

        $types = ["jpg" => "image/jpeg", "jpeg" => "image/jpeg", "png" => "image/png", "gif" => "image/gif"];

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!array_key_exists($ext, $types)) {
            return ["erreur" => "Format incorrect", "filePath" => ""];
        }

        if ($file['size'] > 2 * 1024 * 1024) {
            return ["erreur" => "Fichier trop lourd (2 Mo maximum)", "filePath" => ""];
        }

        // Type MIME analysé par le serveur, pas l'étiquette du navigateur
        $mime = mime_content_type($file['tmp_name']);

        if ($mime !== $types[$ext]) {
            return ["erreur" => "Le contenu ne correspond pas à l'extension", "filePath" => ""];
        }

        // Nouveau nom unique, puis déplacement dans le dossier dédié
        $fileName = uniqid('', true) . "." . $ext;
        $filePath = $folder . "/" . $fileName;
        
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            // Tout est bon : pas d'erreur, et le chemin à enregistrer en BDD
            return ["erreur" => "", "filePath" => $filePath];
        } else {
            return ["erreur" => "Le fichier n'a pas pu être enregistré", "filePath" => ""];
        }
        
    }

}