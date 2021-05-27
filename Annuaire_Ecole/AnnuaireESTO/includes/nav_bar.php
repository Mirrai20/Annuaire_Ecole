<!-- Menu -->
<div class="dropdwn">
		<nav>
			<h2 class="logo">AnnuaireESTO</h2>
			<label for="chk" class="show-menu-btn">
				<span class="circles">
					<span class="circle"></span>
					<span class="circle"></span>
					<span class="circle"></span>
				</span>
			</label>
			<input type="checkbox" id="chk">

				<ul class="menu">
					<li><a href="home.php">Home</a></li>
					<li><a href="annuaire_ESTO.php">Annuaire ESTO</a></li>
						<?php  if( $user->getDescription() == 'Administrateur' ) : ?>
							<li><a href="procedure.php">Procédure </a></li>
								<?php endif; ?>
					<li><a href="#"><span class="icon_user"><span class="rectangle"></span></span> <?= $user->getDescription() ?> <span class="triangle"></span> </a>
						<ul >
							<li><a href="mon_compte.php">Mon compte</a></li>
							<li>
								<form  method="POST">
									<button name="logout_button" type="submit"  id="idlogout">Se déconnecter</button>
								</form>
							</li>
						</ul>
					</li>
					<label for="chk" class="hide-menu-btn">
						<span class="close">X</span>
					</label>
				</ul>
		</nav>
	</div>
