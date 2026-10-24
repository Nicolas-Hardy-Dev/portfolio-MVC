<?php

namespace App\Controllers;


use App\Core\Form;
use App\Entities\Creation;
use App\Models\CreationModel;
use App\Core\FileUploader;
use App\Core\CsrfToken;

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
        // Accès réservé aux admins
        $this->requireLogin();

        $erreur = "";

        // On contrôle si les champs du formulaire sont remplis
        if (Form::validatePost($_POST, ['title', 'description', 'date']) && Form::validateFiles($_FILES, ['picture'])) {

            $erreur = CsrfToken::verify();

            if ($erreur === "") {

                // on vérifie et on déplace l'image 
                $upload = FileUploader::upload($_FILES['picture'], "images");

                if ($upload['erreur'] !== "") {
                    $erreur = $upload['erreur'];
                } else {

                    // on instancie l'entité "Création"
                    $creation = new Creation();

                    // on l'hydrate
                    $creation->setTitle($_POST['title']);
                    $creation->setDescription($_POST['description']);
                    $creation->setCreated_at($_POST['date']);
                    $creation->setPicture($upload['filePath']);

                    // On instancie le model "creation"
                    $model = new CreationModel();
                    $model->create($creation);

                    // On redirige l'utilisateur vers la liste des créations 
                    header("Location:index.php?controller=creation&action=index");
                    exit;
                }
            }

        } else {
            // Message d'erreur à afficher
            $erreur = !empty($_POST) ? "Le formulaire n'a pas été correctement rempli !" : "";
        }

        // génération du token
        $token = CsrfToken::generate();

        // on instancie la classe Form pour construire le formulaire d'ajout
        $form = new Form();

        // on construit le formulaire d'ajout
        $form->startForm("#", "POST", ["enctype" => "multipart/form-data"]);
        $form->addInput("hidden", "token", ["value" => $token] );
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


    //méthode pour la mise à jour de la création
    public function updateCreation($id)
    {
        // Accès réservé aux admins
        $this->requireLogin();

        // Initialisation de $erreur
        $erreur = "";

        //on contrôle si les champs du formulaire sont remplis
        if (Form::validatePost($_POST, ['title', 'description', 'date', 'hidden'])) {

            // on contrôle si le token est présent et valide
            $erreur = CsrfToken::verify();

            if ($erreur === "") {

                //on instancie l'entité "Creation"
                $creation = new Creation();

                //on l'hydrate
                $creation->setTitle($_POST['title']);
                $creation->setDescription($_POST['description']);
                $creation->setCreated_at($_POST['date']);

                //si une nouvelle image a été uploadée
                if (Form::validateFiles($_FILES, ['picture'])) {

                    // on vérifie et on déplace l'image 
                    $upload = FileUploader::upload($_FILES['picture'], "images");

                    if ($upload['erreur'] !== "") {
                        // l'image est refusée, on transfère le message d'erreur dans la variable associée
                        $erreur = $upload['erreur'];
                    } else {
                        //on hydrate la propriété picture de la classe "Creation"
                        $creation->setPicture($upload['filePath']);
                    }   

                //sinon on garde le lien de l'image actuelle du champ caché
                } else {
                    $creation->setPicture($_POST['hidden']);
                }

                // Aucune erreur d'upload, donc mise à jour de la création.
                if ($erreur === "") {
                
                    //on instancie le modèle "creation" pour l'update
                    $creations = new CreationModel();
                    $creations->update($id, $creation);
                
                    //on redirige l'utilisateur vers la liste des créations
                    header("Location:index.php?controller=creation&action=index");
                    // Arrêt du script après la redirection
                    exit;
                }   
            }

        } else {

            //on affiche un message d'erreur
            $erreur = !empty($_POST) ? "Le formulaire n'a pas été correctement rempli" : "";
        }

        //on instancie le modèle pour récupérer les informations de la création
        $creations = new CreationModel();
        $creation = $creations->find($id);

        // on crée le token de session
        $token = CsrfToken::generate();

        //on construit le formulaire de mise à jour
        $form = new Form();

        $form->startForm("#", "POST", ["enctype" => "multipart/form-data"]);
        $form->addInput("hidden", "token", ["value" => $token] );
        $form->addLabel("title", "Titre", ["class" => "form-label fw-semibold"]);
        $form->addInput("text", "title", ["id" => "title", "class" => "form-control mb-3", "placeholder" => "Ajouter un titre", "value" => $creation->title]);
        $form->addLabel("description", "Description", ["class" => "form-label fw-semibold"]);
        $form->addTextarea("description", $creation->description, ["id" => "description", "class" => "form-control mb-3", "rows" => 15]);
        $form->addLabel("date", "Date de publication", ["class" => "form-label fw-semibold"]);
        $form->addInput("text", "date", ["id" => "date", "class" => "form-control mb-3", "value" => $creation->created_at, "readonly" => ""]);
        $form->addLabel("picture", "Image de la création", ["class" => "form-label fw-semibold"]);
        $form->addInput("file", "picture", ["id" => "picture", "class" => "form-control mb-3"]);
        // type "hidden" au lieu d'un champ texte avec l'attribut hidden
        $form->addInput("hidden", "hidden", ["id" => "hidden", "value" => $creation->picture]);
        $form->addInput("submit", "update", ["value" => "Modifier", "class" => "btn btn-primary d-block mx-auto w-50 py-2 mt-4"]);
        $form->endForm();

        // On renvoie vers la vue le formulaire de mise à jour, le message d'erreur potentiel et l'image actuelle
        // Ajout de "picture" : la vue en a besoin pour afficher l'image.
        $this->render('creation/updateCreation', ["updateForm" => $form->getFormElements(), "erreur" => $erreur, "picture" => $creation->picture, "titleCreation" => $creation->title]);
        }


    // Méthode pour la suppression d'une création
    public function deleteCreation($id) 
    {
        // Accès réservé aux admins
        $this->requireLogin();

        $erreur = "";

        if (isset($_POST['true'])) {
            
            $erreur = CsrfToken::verify();

            if ($erreur === "") {
                // on instancie la classe CreationModel pour exécuter la suppression avec delete() en récupérant l'id dans l'URL, si l'utilisateur a cliqué sur "OUI".
                $creations = new CreationModel();
                $creations->delete($id);
                // on redirige l'utilisateur vers la liste des créations et on arrête le script.
                header("Location:index.php?controller=creation&action=index");
                exit;
            }
        } elseif (isset($_POST['false'])) {
            // on redirige l'utilisateur vers la liste des créations et on arrête le script.
            header("Location:index.php?controller=creation&action=index");
            exit;
        } 

        // on crée le token de session
        $token = CsrfToken::generate();

        // on récupère la création avec la méthode find()
        $creations = new CreationModel();
        $creation = $creations->find($id);

        // on renvoie vers la vue la création sélectionnée et le token à inséré dans le formulaire de suppression.
        $this->render('creation/deleteCreation', ["creation" => $creation, "token" => $token, "erreur" => $erreur]);
    }
}