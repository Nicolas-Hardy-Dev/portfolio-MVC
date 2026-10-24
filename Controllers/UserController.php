<?php

namespace App\Controllers;


use App\Core\Form;
use App\Entities\User;
use App\Models\UserModel;
use App\Core\CsrfToken;

class UserController extends Controller 
{
    public function login()
    {

        $erreur = "";

       if (Form::validatePost($_POST, ['username', 'password'])) {

            $erreur = CsrfToken::verify();

            if ($erreur === "") {

                $model = new UserModel();
                $user = $model->findByUsername($_POST['username']);

                if (($user !== false) && password_verify($_POST['password'], $user->password)) {
                    session_regenerate_id(true);
                    $_SESSION['username'] = $user->username;
                    header("Location:index.php?controller=creation&action=index");
                    exit;                    
                } else {
                    $erreur = "Les identifiants de connexion sont incorrects.";
                }
            }

       } else {
            // Message d'erreur à afficher
            $erreur = !empty($_POST) ? "Le formulaire n'a pas été correctement rempli !" : "";
       }



        $token = CsrfToken::generate();

        // on instancie la classe Form pour construire le formulaire de connexion
        $form = new Form();

        // on construit le formulaire de connexion
        $form->startForm("#", "POST");
        $form->addInput("hidden", "token", ["value" => $token] );
        $form->addLabel("username", "Pseudo", ["class" => "form-label fw-semibold"]);
        $form->addInput("text", "username", ["id" => "username", "class" => "form-control mb-3", "required" => "required"]);
        $form->addLabel("password", "Mot de Passe", ["class" => "form-label fw-semibold"]);
        $form->addInput("password", "password", ["id" => "password", "class" => "form-control mb-3", "required" => "required"]);
        $form->addInput("submit", "login", ["value" => "Se connecter", "class" => "btn btn-primary d-block mx-auto w-50 py-2 mt-4"]);
        $form->endForm();

        // On envoie le formulaire dans la vue*
        $this->render('user/login', ["loginForm" => $form->getFormElements(), "erreur" => $erreur]);

    }


    public function logout()
    {
        session_unset(); // vide $_SESSION
        session_destroy(); // détruit la session sur le serveur
        header("Location:index.php");
        exit;

    }
}