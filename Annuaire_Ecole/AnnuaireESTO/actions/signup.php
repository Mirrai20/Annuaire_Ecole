<?php

    spl_autoload_register(function ($class_name) {
        include '../Classes/'. $class_name . '.php';
    });

    session_start();
    if(isset($_SESSION['user_id'])) {
        if(User::findBy($_SESSION['user_id'])) {
            header('Location: /AnnuaireESTO/');
            die();
        }
    }

    //Récupération des valeurs entrant
    $user_id = $_POST['signup_code'];
    $nom = $_POST['signup_name'];
    $prenom = $_POST['signup_prenom'];
    $tele = $_POST['signup_tele'];
    $email = $_POST['signup_email'];
    $password = $_POST['signup_password'];
    $description= $_POST['signup_description'];


    if(User::findBy($email, 'email') == null && User::findBy($tele, 'telephone') == null) {
          if(User::findBy($user_id) == null){
                $user = new User();
                $user->setUser_id($user_id);
                $user->setNom($nom);
                $user->setPrenom($prenom);
                $user->setTelephone($tele);
                $user->setEmail($email);
                $user->setPassword($password);
                $user->setAcceptation(0);
                $user->setDescription($description);
                if($description=="Etudiant"){
                  $filiere=$_POST['signup_fil'];
                  $etudiant=new Etudiant();
                  $etudiant->setFiliere($filiere);
                }

                if(User::addUser($user)) {

                    //user added successfully
                    header('Location: /AnnuaireESTO/?'. sha1('user_added'));
                    die();

                } else {

                    //User not added
                    header('Location: /AnnuaireESTO/?'.sha1('exc_problem'));
                    die();

                }
            }else {
              //CNE or PPR already used by another account
              header('Location: /AnnuaireESTO/?'.sha1('code_used'));
              die();

            }

    } else {

        //Email already used by another account
        header('Location: /AnnuaireESTO/?'.sha1('email_used'));
        die();


    }


?>
