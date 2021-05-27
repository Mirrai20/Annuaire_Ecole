<?php

	session_start();

    spl_autoload_register(function ($class_name) {
        include 'Classes/'. $class_name . '.php';
    });

    if(!isset($_SESSION['user_id'])) {
        header('Location: /AnnuaireESTO/');
        die();
    }

	if(isset($_POST['logout_button'])) {
		session_destroy();
		header('Location: /AnnuaireESTO/');
	}


	$user = User::findBy($_SESSION['user_id']);

?>

<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Mon compte</title>
		<link rel="stylesheet" href="styles/menu.css">
		<style>
			label {
				color: rgb(64, 92, 96);
				position: relative;
			}
			.input{

				margin-top: 4px;
				padding: 10px 0px 11px 26px;
				border: 1px solid rgb(178, 178, 178);
				-webkit-box-sizing: content-box;
				-moz-box-sizing: content-box;
				box-sizing: content-box;
				-webkit-border-radius: 3px;
				-moz-border-radius: 3px;
				border-radius: 3px;
				-webkit-box-shadow: 0px 1px 4px 0px rgba(168, 168, 168, 0.6) inset;
				-moz-box-shadow: 0px 1px 4px 0px rgba(168, 168, 168, 0.6) inset;
				box-shadow: 0px 1px 4px 0px rgba(168, 168, 168, 0.6) inset;
				-webkit-transition: all 0.2s linear;
				-moz-transition: all 0.2s linear;
				-o-transition: all 0.2s linear;
				transition: all 0.2s linear;
				width: 90%;
			}

			.MonP{
				position: absolute;
				width: 291px;
				padding: 18px 6% 25px 6%;
				background: rgb(247, 247, 247);
				border: 1px solid rgba(147, 184, 189,0.8);
				-webkit-box-shadow: 0pt 2px 5px rgba(105, 108, 109, 0.7), 0px 0px 8px 5px rgba(208, 223, 226, 0.4) inset;
				-moz-box-shadow: 0pt 2px 5px rgba(105, 108, 109, 0.7), 0px 0px 8px 5px rgba(208, 223, 226, 0.4) inset;
				box-shadow: 0pt 2px 5px rgba(105, 108, 109, 0.7), 0px 0px 8px 5px rgba(208, 223, 226, 0.4) inset;
				-webkit-box-shadow: 5px;
				-moz-border-radius: 5px;
				border-radius: 5px;
				right: 34%;
				text-align:center;
			}
			td{
				padding: 4% 1% 4% 0;
			}

			.mod_btn {
				width: 30%;
				cursor: pointer;
				background: rgb(61, 157, 179);
				padding: 8px 5px;
				font-family: 'BebasNeueRegular','Arial Narrow',Arial,sans-serif;
				color: #fff;
				font-size: 24px;
				border: 1px solid rgb(28, 108, 122);
				margin-bottom: 10px;
				text-shadow: 0 1px 1px rgba(0, 0, 0, 0.5);
				-webkit-border-radius: 3px;
				-moz-border-radius: 3px;
				border-radius: 3px;
				-webkit-box-shadow: 0px 1px 6px 4px rgba(0, 0, 0, 0.07) inset, 0px 0px 0px 3px rgb(254, 254, 254), 0px 5px 3px 3px rgb(210, 210, 210);
				-moz-box-shadow: 0px 1px 6px 4px rgba(0, 0, 0, 0.07) inset, 0px 0px 0px 3px rgb(254, 254, 254), 0px 5px 3px 3px rgb(210, 210, 210);
				box-shadow: 0px 1px 6px 4px rgba(0, 0, 0, 0.07) inset, 0px 0px 0px 3px rgb(254, 254, 254), 0px 5px 3px 3px rgb(210, 210, 210);
				-webkit-transition: all 0.2s linear;
				-moz-transition: all 0.2s linear;
				-o-transition: all 0.2s linear;
				transition: all 0.2s linear;
			}
			b{
				color:red;
			}
			.A_menu{
				display: -webkit-flex;
				display: -moz-flex;
				display: -ms-flex;
				display: -o-flex;
				display: flex;
				flex-wrap:wrap;
				justify-content:center;
				align-items:center;
				margin: 0;
				padding: 0;
				box-sizing: border-box;
				list-style: none;
				font-family: 'Montserrat', sans-serif;
			}
			.champ{
				    position: relative;
				display: -webkit-flex;
				display: -moz-flex;
				display: -ms-flex;
				display: -o-flex;
				display: flex;
				flex-direction: column;
				align-items: center;
				justify-content: center;
				width: 274px;
				height: auto;
				border-radius: 4px;
				background-color: #9fcdc7;
				text-align: center;
				margin: 2px;
				padding: 15px;
				transition: .3s;
				box-shadow: 1px 0 5px 0 rgba(0,0,0,0.6);

			}
			.champ:hover{
				background-color:#333;
			}
			#MP{
				display:none;
			}
			#TPR{
				padding: 0px 9% 0;
				color: #363842;
				font-size: 3.4em;
			}
		</style>
		<script type="text/javascript">
				function info(a){
					<!-- alert(a); -->
					if(a===1){
						document.getElementById("MI").style.display="inline";
						document.getElementById("MP").style.display="none";

					}
					if(a===0){
						document.getElementById("MI").style.display="none";
						document.getElementById("MP").style.display="inline";

					}
				}
			</script>
	</head>
	<body>
		<!-- Menu -->
		<?php include("includes/nav_bar.php"); ?>

		<h1 id="TPR">Mon Profil</h1>
	<div class="A_menu" id="d1">
		<input type="button" value="Mes informations" class="champ" id="d1-champ" onclick="info(1)"  >
		<input type="button" value="Changer mon mot de passe" class="champ" id="d2-champ" onclick="info(0)"></div>

	</div>


  <div class="MonP" id="MI" >
		<form  action="actions/updateUser.php" method="POST" >

				<label for="ie">Email <b>*</b>:</label><br>
				<input type="text" name="update_email" class="input" placeholder="Email Address" value="<?= $user->getEmail() ?>" >
				<br>
				<label for="it">Téléphone <b>*</b>:</label><br>
				<input type="tel" pattern="[0]{1}[6-7]{1}[0-9]{8}" name="update_tele" class="input" placeholder="Phone" value="<?= $user->getTelephone() ?>" >
				<br>
			<?php  if( $user->getDescription() == 'Etudiant' ) : ?>
			<label for="im">Filiére<b>*</b>:</label><br>
				<select class="input" name="update_fil">
					<option value="ASR" <?php if($user->getFiliere() == "ASR") echo "selected"; ?>>Administrateur Systeme Réseau</option>
					<option value="DAI" <?php if($user->getFiliere() == "DAI") echo "selected"; ?>>Développement d'Application Informatique</option>
					<option value="EII" <?php if($user->getFiliere() == "EII") echo "selected"; ?>>Electronique et Informatique Industrielle</option>
				</select>
				<br>
			<?php endif; ?>


		 <input name="update_submit" type="submit"   class="mod_btn" style="margin-top:10px;" value="Modifier">
		</form>
  </div>
  <!-- Changer le mot de passe -->
		<form action="actions/updatePassword.php" method="POST" class="MonP" id="MP">
				<label for="in">Ancien mot de passe <b>*</b> : </label><br>
				<input name="password_old" type="password" class="input" placeholder="Saisir votre ancien mot de passe" >
				<br>
				<label for="ie">Nouveau mot de passe <b>*</b> : </label><br>
				<input name="password_new" type="password" class="input" placeholder="Saisir votre nouveau mot de passe">
				<br>
				<label for="it">Confirmez le mot de passe <b>*</b> : </label><br>
				<input name="password_confirm" type="password" class="input" placeholder="Confirmez votre mot de passe">
				<br>
			  <input name="password_submit" type="submit"   class="mod_btn" style="margin-top:10px;" value="Modifier">
  </form>
	</body>
</html>
