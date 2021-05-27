<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Ajouter un nouveau utilisateurs</title>
  </head>
  <body>
    <!-- EDD USER  -->
        <div class="sign-box">

            <div class="upd_choice" style="background-color: #318700;">
                <h2>Modifications</h2>
            </div>

              <div class="edit-user" >

                        <div class="sign_name">
                            <div style="padding-right: 4%;">
                              <label for="EDIT_name">Nom :</label>
                              <input type="text" name="EDIT_name" id="EDIT_name" value="<?= $afficher_user[$i]->getNom() ?>" required>
                            </div>

                            <div>
                              <label for="EDIT_prenom">Prenom :</label>
                              <input type="text" name="EDIT_prenom" id="EDIT_prenom" value="<?= $afficher_user[$i]->getPrenom() ?>" required>
                            </div>
                        </div>

                        <label for="EDIT_tele">Numéro de téléphone :</label>
                        <input type="tel" pattern="[0]{1}[6-7]{1}[0-9]{8}" name="EDIT_tele" id="EDIT_tele" value="<?= $afficher_user[$i]->getTelephone() ?>" required>

                        <label for="EDIT_email">Email :</label>
                        <input type="email" name="EDIT_email" id="EDIT_email" value="<?= $afficher_user[$i]->getEmail() ?>" required>

                        <label for="EDIT_password">Password :</label>
                        <input type="password" name="EDIT_password" id="EDIT_password" value="<?= $afficher_user[$i]->getPassword() ?>" required>

                        <div class="sign-selects">
                            <div style="padding-right: 4%;">
                                <label for="EDIT_description">Description :</label>
                                <select name="EDIT_description" id="EDIT_description" >
                                  <?php  if($afficher_user[$i]->getDescription() == 'Etudiant' ) : ?>
                                    <option value="Etudiant"<?php if($afficher_user[$i]->getDescription() == "Etudiant") echo "selected"; ?>>Etudiant</option>

                                <?php else : ?>
                                    <option value="Enseignant"<?php if($afficher_user[$i]->getDescription() == "Enseignant") echo "selected"; ?>>Enseignant</option>
                                    <option value="Fonctionnaire"<?php if($afficher_user[$i]->getDescription() == "Fonctionnaire") echo "selected"; ?>>Fonctionnaire</option>
                                <?php endif; ?>

                                </select>
                            </div>

                            <?php  if($afficher_user[$i]->getDescription() == 'Etudiant' ) : ?>
                              <div id="edfi">
                                    <label for="EDIT_fil">Filiere :</label>
                                    <select name="EDIT_fil" id="EDIT_fil">
                                        <option value="DAI" <?php if($afficher_user[$i]->getFiliere() == "DAI") echo "selected"; ?>>DAI</option>
                                        <option value="ASR" <?php if($afficher_user[$i]->getFiliere() == "ASR") echo "selected"; ?>>ASR</option>
                                        <option value="EII" <?php if($afficher_user[$i]->getFiliere() == "EII") echo "selected"; ?>>EII</option>
                                    </select>
                                </div>
                            <?php endif; ?>

                        </div>
                        <?php  if($afficher_user[$i]->getDescription() == 'Etudiant' ) : ?>
                          <label for="EDIT_code" id="edLc">CNE :</label>
                        <?php else : ?>
                          <label for="EDIT_code" id="edLc">PPR :</label>
                        <?php endif; ?>
                        <input type="text" name="EDIT_code" style="cursor:pointer;" id="EDIT_code" value="<?= $afficher_user[$i]->getUser_id() ?>" readonly>

                        <input type="submit" class="btl btnEdit" name="EDIT_submit" value="EDIT" id="EDIT_submit" onclick="return verifInputs()">

                        <p class="errors" id="EDIT_errors"><br></p>

            </div>

        </div>

        <!-- CE SCRIPT VA GERER LES INPUT DANS LE CAS D'AJOUTS ou DE modifications -->
      	<script src="scripts/EDIT.js"></script>
  </body>
</html>
