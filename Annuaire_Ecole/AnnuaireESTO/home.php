<?php

	session_start();

    spl_autoload_register(function ($class_name) {
        include 'Classes/'. $class_name . '.php';
    });

    if(!isset($_SESSION['user_id'])) {
        header('Location: /AnnuaireESTO/');
        die();
	}

	if(User::findBy($_SESSION['user_id']) == null) {
		header('Location: /AnnuaireESTO/');
		die();
	}

	if(isset($_POST['logout_button'])) {
		session_destroy();
		header('Location: /AnnuaireESTO/');
	}

	$user = User::findBy($_SESSION['user_id']);



    $error = '';
	$success = '';

	//ERRORS
    if(isset($_GET[sha1('exc_problem')])) $error = 'Server issues, please try again!';
    if(isset($_GET[sha1('email_used')])) $error = 'Email or numero phone already used by another account!';
    if(isset($_GET[sha1('password_wrong')])) $error = 'Password given is wrong!';
    if(isset($_GET[sha1('password_confirmation_wrong')])) $error = 'Password Confirmation is wrong!';

    //SUCCESS
    if(isset($_GET[sha1('user_updated')])) $success = 'Your informations are updated now!';
    if(isset($_GET[sha1('password_updated')])) $success = 'Your password is updated now!';

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>AnnuaireESTO</title>
    <link rel="stylesheet" href="styles/menu.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
		<style media="screen">
			.welcome{
				width: 100%;
				height: 90vh;
				background-image: url('imgs/bienvenu.jpg');
				background-size: cover;
			}
			.dear{
				position: absolute;
				width: 100%;
				background-color: #0009;
				top: 50%;
				text-align: center;
				font-size: 4.5em;
				color: white;
			}
		</style>
  </head>
  <body>

	<!-- Erreurs -->
	<div class="global-errors" id="global-errors" title="CLICK TO HIDE">
		<?php
		if($error != "") {
			echo "<p>$error</p>";
		}
		?>
	</div>

	<div class="global-success" id="global-success" title="CLICK TO HIDE">
		<?php
		if($success != "") {
			echo "<p>$success</p>";
		}
		?>
	</div>

		<!-- Menu -->
		<?php include("includes/nav_bar.php"); ?>

		<div class="welcome">
		 <div class="dear">
		 		Bienvenu <?= $user->getNom() ?>
		 </div>
		</div>
	<script>

		document.querySelector('#global-errors').addEventListener('click', ()=>{
			document.querySelector('#global-errors').style.display = 'none';
			window.history.pushState({}, document.title, "/AnnuaireESTO/");
		});

		document.querySelector('#global-success').addEventListener('click', ()=>{
			document.querySelector('#global-success').style.display = 'none';
			window.history.pushState({}, document.title, "/AnnuaireESTO/");
		});

	</script>

  </body>
</html>
