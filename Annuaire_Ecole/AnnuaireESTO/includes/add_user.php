<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Ajouter un nouveau utilisateurs</title>
  </head>
  <body>
    <!-- ADD NEW USER  -->
        <div class="sign-box">

            <div class="upd_choice">
                <h2>ADD NEW USER</h2>
            </div>

              <div class="add-user" >
                    <form action="actions/ajouter_user.php" method="POST">


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
                        <input type="tel" pattern="[0]{1}[6-7]{1}[0-9]{8}" name="signup_tele" id="signup_tele" required>

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

                        <input type="submit" class="btl" name="signup_submit" value="ADD USER" onclick="checkInputs(this, 'up')">

                        <p class="errors" id="signup_errors"><br></p>

                    </form>
            </div>

        </div>
        <!-- CE SCRIPT VA GERER LES INPUT DANS LE CAS D'AJOUTS ou DE modifications -->
      	<script src="scripts/login.js"></script>
  </body>
</html>
