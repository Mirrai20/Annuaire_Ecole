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

	//initialisation des variables
	if($user->getDescription()=="Administrateur"){
		$newsUser = array();
		$afficher_user = array();
		$Administrateur = Administrateur::findBy($user->getUser_id());
		$newsUser = $Administrateur->getNewUser();
		$afficher_user = $Administrateur->getALLuser();
	}
	//ERRORS
	$error = '';
	if(isset($_GET[sha1('email_used')])) $error = 'Email already used by another account!';
	if(isset($_GET[sha1('code_used')])) $error = 'Code already used by another account!';
	if(isset($_GET[sha1('exc_problem')])) $error = 'Server issues, please try EDIT again!';
	//SUCCESS
	$success = '';
	if(isset($_GET[sha1('user_edit')])) $success = "Vous avez bien modifier cet utilisateur!";
	if(isset($_GET[sha1('user_added')])) $success = "Vous avez bien ajouter un nouveau utilisateur";
	if(isset($_GET[sha1('user_del')])) $success = "Vous avez bien supprimer cet utilisateur!";


?>

<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>La procédure</title>
			<link rel="stylesheet" href="styles/Procedure.css">
			<link rel="stylesheet" href="styles/menu.css">
			<script type="text/javascript" src="scripts/changer_table.js"></script>
	</head>
	<body>
		<!-- Menu -->
		<?php include("includes/nav_bar.php"); ?>

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

	<!-- Gestion d'admin -->
		<h1 id="TitreP">Suivis la procedure</h1>

				<div class="A_menu">
					<div class="champ" id="d1-champ" onclick="info(0)">Les nouveaux demandes <i class="fas fa-folder-plus"></i></div>
					<div class="champ" id="d1-champ" onclick="info(1)">Gestion d'utilisateurs <i class="fas fa-folder-plus"></i></div>

				</div>


					<table class='table' id="Acceptation">
							<thead>
								<th>CNE/PPR</th>
								<th>Nom</th>
								<th>Prenom</th>
								<th>Description</th>
								<th>Téléphone</th>
								<th>Email</th>
								<th>Acceptation</th>
							</thead>
							<tbody>
								<?php if(count($newsUser)) : ?>

								<?php foreach($newsUser as $user) : ?>

									<tr>
										<form action="actions/Acceptation.php" method="POST">
										<td>
											<input name="Code" type="text" style="border:none;text-align:center;" value="<?= $user->getUser_id() ?>" readonly>
										</td>
										<td><?= $user->getNom() ?></td>
										<td><?= $user->getPrenom() ?></td>
										<td><?= $user->getDescription() ?></td>
										<td><?= $user->getTelephone() ?></td>
										<td><?= $user->getEmail() ?></td>
										<td>
													<input name="Demande_accepté" type="submit"  class="BTNEN ICR" value="Accepter" >
										</td>
										</form>
									</tr>

								<?php endforeach; ?>

							<?php else : echo "<tr><td colspan='7'>Aucun demandes a été trouver</td></tr>"; endif; ?>
							</tbody>
					</table>
					<div id="Gestion">
							<a class="BTNEN ICR" id="ADD" >ADD USER</a>
								<table class='table' >
							<thead>
								<th>CNE/PPR</th>
								<th>Nom</th>
								<th>Prenom</th>
								<th>Description</th>
								<th>Téléphone</th>
								<th>Email</th>
								<th>Modifications</th>
								<th>Suppressions</th>
							</thead>
							<tbody>

								<?php if(count($afficher_user)) : ?>

								<?php for($i=0;$i<count($afficher_user);$i++){ ?>
									<form action="actions/Edit_delUser.php?code=<?=$afficher_user[$i]->getUser_id() ?>" method="POST">
									<tr>
										<td><?= $afficher_user[$i]->getUser_id() ?></td>
										<td><?= $afficher_user[$i]->getNom() ?></td>
										<td><?= $afficher_user[$i]->getPrenom() ?></td>
										<td><?= $afficher_user[$i]->getDescription() ?></td>
										<td><?= $afficher_user[$i]->getTelephone() ?></td>
										<td><?= $afficher_user[$i]->getEmail() ?></td>
										<td>
													<input name="Edit_user" type="button"  class="BTNEN ICR" value="Modifier" onclick="document.getElementById('modifier<?=$i?>').style.display='flex';document.getElementById('ombre').style.display='flex';"  >

										</td>
										<td>
													<input name="Del_user" type="submit"  class="BTNEN ICR del" value="Supprimer" onclick="return confirm('Etes-vous sur de supprimer cet utilisateur ?')" >
										</td>
									</tr>

									<!-- popUP EDIT USER -->
									<div id="modifier<?=$i?>" class="modifier">
										<div class="modal-contents">

											<div class="close" onclick="document.getElementById('modifier<?=$i?>').style.display='none';document.getElementById('ombre').style.display='none';">+</div>
											<!-- EDIT USER  -->
											<?php
											include("includes/edit_user.php");
												?>

										</div>
									</div>
									</form>

								<?php } ?>

							<?php else : echo "<tr><td colspan='8'>Aucun utilisateur a été trouver</td></tr>"; endif; ?>


							</tbody>
					</table>
					</div>

		<!-- popUP ADD USER -->
		<div id="ajouter">
			<div class="modal-contents">

				<div class="close" id="closeADD">+</div>
				<!-- ADD NEW USER  -->
				<?php include("includes/add_user.php"); 	?>

			</div>
		</div>
		<!-- Ombre for popUp edit -->
		<div id="ombre"></div>

	<script>
		let ad=document.getElementById("ADD");
		let clAD=document.getElementById("closeADD");
		ad.onclick = function(){
			document.getElementById("ajouter").style.display="flex";
		};

		clAD.onclick = function(){
			document.getElementById("ajouter").style.display="none";
		};

	</script>

</html>
