<?php

    spl_autoload_register(function ($class_name) {
        include 'Classes/'. $class_name . '.php';
    });

    session_start();

    if(isset($_SESSION['user_id'])) {
		if(User::findBy($_SESSION['user_id']) != null) {
			header('Location: /AnnuaireESTO/home.php');
			die();
		}
    }

    $error = '';
    $success = '';

    //ERRORS
    if(isset($_GET[sha1('not_found')])) $error = 'Email given not found, please sign up first!';
    if(isset($_GET[sha1('wrong_password')])) $error = 'Password given is wrong, try again!';
    if(isset($_GET[sha1('not_verified')])) $error = "Votre demande d'inscription n'a pas encore accepter!";
    if(isset($_GET[sha1('exc_problem')])) $error = 'Server issues, please try signing up again!';
    if(isset($_GET[sha1('email_used')])) $error = 'Email or numéro phone already used by another account!';
    if(isset($_GET[sha1('code_used')])) $error = 'Code already used by another account!';


    //SUCCESS
    if(isset($_GET[sha1('user_added')])) $success = "Vous avez bien inscrire, Vous devez attendre que l'administrateur accept votre demande!";

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>AnnuaireESTO</title>
    <link rel="stylesheet" href="styles/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body>

	<!-- Erreurs -->
	<div class="global-errors" id="global-errors">
		<?php
		if($error != "") {
			echo "<p>$error</p>";
		}
		?>
	</div>

	<div class="global-success" id="global-success">
		<?php
		if($success != "") {
			echo "<p>$success</p>";
		}
		?>
	</div>

	<!-- Login  -->
		<div class="signContainer" id="signContainer">


        <section id="sign" class="sign-section">

            <div class="sign-box">

                <div class="sign-choice">
                    <h2 class="active" onclick="signActive('in')" id="signInToggler">Sign In</h2>
                    <h2 onclick="signActive('up')" id="signUpToggler">Sign Up</h2>
                </div>

                  <div class="sign-option">
                    <div id="signInDiv" class="active">
                        <form action="actions/signin.php" method="POST">
                            <label for="signin_email">Email :</label>
                            <input type="email" name="signin_email" id="signin_email" required>

                            <label for="signin_password">Password :</label>
                            <input type="password" name="signin_password" id="signin_password" required>
                            <input type="submit" class="btl" name="signin_submit" value="Sign in" onclick="checkInputs(this, 'in')">

                            <p class="errors"id="signin_errors"><br></p>
                        </form>
                    </div>

                    <div id="signUpDiv">
                        <form action="actions/signup.php" method="POST">


                            <div class="sign_name">
                                <div style="padding-right: 4%;">
                                  <label for="signup_name">Nom :</label>
                                  <input type="text" name="signup_name" id="signup_name" required>
                                </div>

                                <div>
                                  <label for="signup_prenom">Prenom :</label>
                                  <input type="text" name="signup_prenom" id="signup_prenom" required>
                                </div>
                            </div>

                            <label for="signup_tele">Numéro de téléphone :</label>
                            <input type="text" pattern="[0]{1}[6-7]{1}[0-9]{8}" name="signup_tele" id="signup_tele" required>

                            <label for="signup_email">Email :</label>
                            <input type="email" name="signup_email" id="signup_email" required>

                            <label for="signup_password">Password :</label>
                            <input type="password" name="signup_password" id="signup_password" required>

                            <div class="sign-selects">
                                <div style="padding-right: 4%;">
                                    <label for="signup_description">Description :</label>
                                    <select name="signup_description" id="signup_description"  onclick="checkdesc(value)">
                                        <option value="Enseignant">Enseignant</option>
                                        <option value="Fonctionnaire">Fonctionnaire</option>
                                        <option value="Etudiant">Etudiant</option>

                                    </select>
                                </div>

                                <div id="idFi" style="display:none;">
                                    <label for="signup_fil">Filiere :</label>
                                    <select name="signup_fil" id="signup_fil">
                                        <option value="DAI">DAI</option>
                                        <option value="ASR">ASR</option>
                                        <option value="EII">EII</option>
                                    </select>
                                </div>
                            </div>

                            <label for="signup_code" id="idLc">PPR :</label>
                            <input type="text" name="signup_code" id="signup_code" required>

                            <input type="submit" class="btl" name="signup_submit" value="Sign Up" onclick="checkInputs(this, 'up')">

                            <p class="errors" id="signup_errors"><br></p>

                        </form>
                    </div>
                </div>

            </div>

        </section>
	</div>



	<script src="scripts/login.js"></script>
  </body>
</html>
