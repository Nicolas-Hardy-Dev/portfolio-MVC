<?php

namespace App\Controllers;

use App\Core\Form;
use App\Entities\Creation;
use App\Models\CreationModel;

class CreationController extends Controller 
{
    // permet d'afficher la liste des créations
    public function index() 
    {
        // on instancie la classe CreationModel
        $creation = new CreationModel();

        // on stocke dans une variable le retour de la méthode findAll()
        $list = $creation->findAll();

        $this->render('creation/index', ['list' => $list]);
        
    }

    // Permet d'afficher une seule création
    public function showCreation($id) 
    {
        // On instancie la classe CreationModel
        $creations = new CreationModel();

        // on stocke dans une variable le retour de la méthode find()
        $creation = $creations->find($id);

        $this->render('creation/showCreation', ['creation' => $creation]);

    }

    public function add()
    {
        $erreur = "";
        // On contrôle si les champs du formulaire sont remplis
        if (Form::validatePost($_POST, ['title', 'description', 'date']) && Form::validateFiles($_FILES, ['picture'])) {

            // upload de l'image dans le dossier 'images'
            move_uploaded_file($_FILES['picture']['tmp_name'], 'images/' . $_FILES['picture']['name']);
            // on stocke le chemin de l'image uploadée
            $picture = 'images/' . $_FILES['picture']['name'];

            // on instancie l'entité "Création"
            $creation = new Creation();

            // on l'hydrate
            $creation->setTitle($_POST['title']);
            $creation->setDescription($_POST['description']);
            $creation->setCreated_at($_POST['date']);
            $creation->setPicture($picture);

            // On instancie le model "creation"
            $model = new CreationModel();
            $model->create($creation);

            // On redirige l'utilisateur vers la liste des créations 
            header("Location:index.php?controller=creation&action=index");
            exit;

        } else {
            // Message d'erreur à afficher
            $erreur = !empty($_POST) ? "Le formulaire n'a pas été correctement rempli !" : "";
        }


        // on instancie la classe Form pour construire le formulaire d'ajout
        $form = new Form();

        // on construit le formulaire d'ajout
        $form->startForm("#", "POST", ["enctype" => "multipart/form-data"]);
        $form->addLabel("title", "Titre", ["class" => "form-label fw-semibold"]);
        $form->addInput("text", "title", ["id" => "title", "class" => "form-control mb-3", "placeholder" => "Ajouter un titre", "required" => "required"]);
        $form->addLabel("description", "Description", ["class" => "form-label fw-semibold"]);
        $form->addTextarea("description", "", ["id" => "description", "class" => "form-control mb-3", "rows" => 15, "placeholder" => "Description de la création", "required" => "required"]);
        $form->addLabel("date", "Date de publication", ["class" => "form-label fw-semibold"]);
        $form->addInput("date", "date", ["id" => "date", "class" => "form-control mb-3", "required" => "required"]);
        $form->addLabel("picture", "Image de la création", ["class" => "form-label fw-semibold"]);
        $form->addInput("file", "picture", ["id" => "picture", "class" => "form-control mb-3", "required" => "required"]);
        $form->addInput("submit", "add", ["value" => "Ajouter", "class" => "btn btn-primary d-block mx-auto w-50 py-2 mt-4"]);
        $form->endForm();

        // on envoie le formulaire dans la vue add.php
        $this->render('creation/add', ["addForm" => $form->getFormElements(), "erreur" => $erreur]);
        
    }
}