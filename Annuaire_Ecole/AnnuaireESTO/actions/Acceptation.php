<?php

    spl_autoload_register(function ($class_name) {
        include '../Classes/'. $class_name . '.php';
    });

    session_start();

    if(!isset($_SESSION['user_id'])) {
        header('Location: /AnnuaireESTO/');
        die();
    }

    if($_POST['Demande_accepté']) {

        $user = User::findBy($_POST['Code']);
        if(User::AcceptUser($user)) {
            header('Location: /AnnuaireESTO/procedure.php');
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
