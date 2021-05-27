<?php

    spl_autoload_register(function ($class_name) {
        include '../Classes/'. $class_name . '.php';
    });

    session_start();

    if(!isset($_SESSION['user_id'])) {
        header('Location: /AnnuaireESTO/');
        die();
    }

    if($_POST['password_submit']) {

        $user = User::findBy($_SESSION['user_id']);

        if($_POST['password_old'] != $user->getPassword()) {

            //Old password is Wrong
            header('Location: /AnnuaireESTO/home.php?'. sha1('password_wrong'));
            die();

        } else {

            if($_POST['password_new'] != $_POST['password_confirm']) {

                //New Password and Confirmation Password are not matching
                header('Location: /AnnuaireESTO/home.php?'. sha1('password_confirmation_wrong'));
                die();

            } else {

                $user->setPassword($_POST['password_new']);

            }

        }

        if(User::updateUser($user)) {

            //Password Updated
            header('Location: /AnnuaireESTO/home.php?'. sha1('password_updated'));
            die();

        } else {

            //Password Not updated | Server Issues
            header('Location: /AnnuaireESTO/home.php/?'. sha1('exc_problem'));
            die();
        }

    } else {

        header('Location: /AnnuaireESTO/');
        die();

    }

?>
