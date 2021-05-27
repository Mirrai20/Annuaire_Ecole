<?php

    spl_autoload_register(function ($class_name) {
        include '../Classes/'. $class_name . '.php';
    });

    session_start();

    if(!isset($_SESSION['user_id'])) {
        header('Location: /AnnuaireESTO/');
        die();
    }

    if($_POST['update_submit']) {

        $user = User::findBy($_SESSION['user_id']);

        if(User::findBy($_POST['update_email'], 'email') && ($user->getEmail() != $_POST['update_email']) || User::findBy($_POST['update_tele'], 'telephone') && ($user->getTelephone() != $_POST['update_tele'])) {

            //New Email already Used by another account
            header('Location: /AnnuaireESTO/home.php?'. sha1('email_used'));
            die();

        }

        if($user->getEmail() != $_POST['update_email']) $user->setEmail($_POST['update_email']);
        if($user->getTelephone() != $_POST['update_tele']) $user->setTelephone($_POST['update_tele']);

        if( $user->getDescription() == 'Etudiant' ){
            if($user->getFiliere() != $_POST['update_fil'] ) $user->setFiliere($_POST['update_fil']);
        }

        if(User::updateUser($user)) {

            //user Updated
            header('Location: /AnnuaireESTO/home.php?'. sha1('user_updated'));
            die();

        } else {

            //User Not updated | Server Issues
            header('Location: /AnnuaireESTO/home.php/?'. sha1('exc_problem'));
            die();
        }

    } else {

        header('Location: /AnnuaireESTO/');
        die();

    }

?>
