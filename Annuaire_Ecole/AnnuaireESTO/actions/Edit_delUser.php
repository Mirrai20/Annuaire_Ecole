<?php

    spl_autoload_register(function ($class_name) {
        include '../Classes/'. $class_name . '.php';
    });

    session_start();

    if(!isset($_SESSION['user_id'])) {
        header('Location: /AnnuaireESTO/');
        die();
    }
    //modifier USER
    if($_POST['EDIT_submit']) {

        $user = User::findBy($_GET['code']);

        if(User::findBy($_POST['EDIT_email'], 'email') && ($user->getEmail() != $_POST['EDIT_email'])) {

            //New Email already Used by another account
            header('Location: /AnnuaireESTO/procedure.php?'.sha1('email_used'));
            die();

        }

        if($user->getNom() != $_POST['EDIT_name']) $user->setNom($_POST['EDIT_name']);
        if($user->getPrenom() != $_POST['EDIT_prenom']) $user->setPrenom($_POST['EDIT_prenom']);
        if($user->getEmail() != $_POST['EDIT_email']) $user->setEmail($_POST['EDIT_email']);
        if($user->getTelephone() != $_POST['EDIT_tele']) $user->setTelephone($_POST['EDIT_tele']);
        if($user->getPassword() != $_POST['EDIT_password']) $user->setPassword($_POST['EDIT_password']);
        if($user->getDescription() != $_POST['EDIT_description']) {
            if($user->getDescription() =="Enseignant"){
              $user->setDescription($_POST['EDIT_description']);
              if(!(User::updateDesc($user,"enseignant"))){
                header('Location: /AnnuaireESTO/procedure.php?'.sha1('exc_problem'));
                die();
              }
            }else{
              $user->setDescription($_POST['EDIT_description']);
              if(!(User::updateDesc($user,"fonctionnaire"))){
                header('Location: /AnnuaireESTO/procedure.php?'.sha1('exc_problem'));
                die();
              }
            }
        }

        if( $user->getDescription() == 'Etudiant' ){
            if($user->getFiliere() != $_POST['EDIT_fil'] ) $user->setFiliere($_POST['EDIT_fil']);
        }

        if(User::updateUser($user)) {

            //user Updated
            header('Location: /AnnuaireESTO/procedure.php?'.sha1('user_edit'));
            die();

        } else {

            //User Not updated | Server Issues
            header('Location: /AnnuaireESTO/procedure.php?'.sha1('exc_problem'));
            die();
        }

    } else {

      //Supprimer USER
      if($_POST["Del_user"]) {
          $user = User::findBy($_GET['code']);
        if(User::DELUser($user)) {

            //user DELITE
            header('Location: /AnnuaireESTO/procedure.php?'.sha1('user_del'));
            die();

        } else {

            //User Not Delite | Server Issues
            header('Location: /AnnuaireESTO/procedure.php?'.sha1('exc_problem'));
            die();
        }
      } else {

        header('Location: /AnnuaireESTO/');
        die();

      }

    }



?>
