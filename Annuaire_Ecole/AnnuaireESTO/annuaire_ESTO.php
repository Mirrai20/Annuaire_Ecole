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
		$afficher_user = array();

?>

<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Annuaire ESTO</title>
			<link rel="stylesheet" href="styles/Procedure.css">
			<link rel="stylesheet" href="styles/menu.css">
			<script type="text/javascript" src="scripts/changer_table.js"></script>
			<script type="text/javascript" src="scripts/login.js"></script>

			<?php if(!empty($_GET['AnnuInv'])): ?>
				<style type="text/css">
							<?php if($_GET['AnnuInv']==1): ?>
										#Acceptation{
												visibility:hidden;
										}
										#Gestion{
												visibility:visible;
										}
						<?php else : ?>
										#Acceptation{
												visibility:visible;
										}
										#Gestion{
												visibility:hidden;
										}
						<?php endif; ?>
				</style>
				<?php endif; ?>
	</head>
	<body>

		<!-- Menu -->
		<?php include("includes/nav_bar.php"); ?>

	<!-- Gestion de recherche -->
		<h1 id="TitreP">Annuaire ESTO</h1>

				<div class="A_menu">
					<div class="champ" id="d1-champ" onclick="info(0)">Annuaire Simple<i class="fas fa-folder-plus"></i></div>
					<div class="champ" id="d1-champ" onclick="info(1)">Annuaire Inversée<i class="fas fa-folder-plus"></i></div>

				</div>

				<!-- Annuaire Simple -->
				<div id="Acceptation" style="margin-top: 47px;">
					<form action="annuaire_ESTO.php?AnnuInv=0"method="POST" style="text-align: center;">
								<input type="text" name="email" class="search-simple" placeholder="Email">
								<?php  if( $user->getDescription() != 'Etudiant' ) : ?>
								<input type="text" name="tele" class="search-simple" placeholder="Téléphone">
								<?php endif; ?>
								<button type="submit" class="search-btn" name="rechercherInv">Search</button>
					</form>
					<table class='table' >
							<thead>
								<th>Nom</th>
								<th>Prenom</th>
								<th>Description</th>
								<th>Filiere</th>
							</thead>
							<tbody>

								<?php if(isset($_POST['rechercherInv'])): ?>
									<?php if($user->getDescription() == 'Etudiant' ) {
												$afficher_user = $user->AnnuaireSimple(strtoupper($_POST['email']),'');
											}else{
												$afficher_user = $user->AnnuaireSimple(strtoupper($_POST['email']),$_POST['tele']);
											}
										?>
								<?php if(count($afficher_user)) : ?>

								<?php foreach($afficher_user as $user) : ?>

									<tr>
										<form action="actions/Acceptation.php" method="POST">
										<td><?= $user->getNom() ?></td>
										<td><?= $user->getPrenom() ?></td>
										<td><?= $user->getDescription() ?></td>
											<?php  if( $user->getDescription() == 'Etudiant' ) : ?>
													<td><?= $user->getFiliere() ?></td>
												<?php else : ?>
													<td style="background-color:darkblue;"></td>
												<?php endif; ?>

										</form>
									</tr>

								<?php endforeach; ?>

							<?php else : echo "<tr><td colspan='4'>Aucun utilisateur a été trouver par ces informations</td></tr>"; endif; ?>
							<?php else : echo "<tr><td colspan='4'>Vous devez saisir les informations d'utilisateur que vous cherchez</td></tr>"; endif; ?>
							</tbody>
					</table>

				</div>


				<!-- Annuaire Inversée -->
				<div id="Gestion" style="	bottom: 160px;">
					<form action="annuaire_ESTO.php?AnnuInv=1"method="POST" style="text-align: center;">
						<input type="text" name="nom" class="search-simple AnnuaireS" placeholder="Nom">
						<input type="text" name="prenom" class="search-simple AnnuaireS" placeholder="Prenom">
						<select name="description" class="search-simple AnnuaireS" onclick="checkdesc(value)">
								<option>Description</option>
								<option value="Enseignant">Enseignant</option>
								<option value="Fonctionnaire">Fonctionnaire</option>
								<option value="Etudiant">Etudiant</option>
						</select>
						<select name="filiere" class="search-simple AnnuaireS"  id="idFi">
							<option>Filiere</option>
							<option value="DAI">DAI</option>
							<option value="ASR">ASR</option>
							<option value="EII">EII</option>
						</select>
						<button type="submit" class="search-btn" name="rechercherSimp">Search</button>
					</form>
					<table class='table' >
							<thead>
								<th>Adresse Email</th>
								<?php  if( $user->getDescription() != 'Etudiant' ) : ?>
								<th style="width: 50%;">Numéro de téléphone</th>
								<?php endif; ?>

							</thead>
							<tbody>

								<?php if(isset($_POST['rechercherSimp'])): ?>
									<?php $afficher_user = $user->AnnuaireInver(strtoupper($_POST['nom']),strtoupper($_POST['prenom']),$_POST['description'],$_POST['filiere']);?>
								<?php if(count($afficher_user)) : ?>

								<?php foreach($afficher_user as $userAff) : ?>

									<tr>
										<form action="actions/Acceptation.php" method="POST">
										<td><?= $userAff->getEmail() ?></td>
											<?php  if( $user->getDescription() != 'Etudiant' ) : ?>
											<td><?= $userAff->getTelephone() ?></td>
											<?php endif; ?>
										</form>
									</tr>

								<?php endforeach; ?>

							<?php else : echo "<tr><td colspan='2'>Aucun utilisateur a été trouver par ces informations</td></tr>"; endif; ?>
							<?php else : echo "<tr><td colspan='2'>Vous devez saisir les informations d'utilisateur que vous cherchez</td></tr>"; endif; ?>
							</tbody>
					</table>
				</div>

</html>
