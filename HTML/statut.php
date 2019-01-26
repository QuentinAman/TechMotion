<?php 
if (isset($_SESSION['connecter'])) {
	if ($_SESSION['connecter'] == 1) { ?>
<div id="statutCompte">
    <span class="spanPseudo">
        <?= htmlspecialchars($_SESSION['pseudo'])?>
    </span>
    <a href="compte.php" id="lienCompte">Mon compte</a>
    <a href="deconnexion.php" class="boutonConnexion">Se déconnecter</a>
    <a href="compte.php"><img src="../images/profil.png" class="iconeCompte"></a>
</div>
<?php 
} elseif ($_SESSION['connecter'] == 0) { ?>
<div id="statutCompte">
    <span class="spanPseudo">Anonyme</span>
    <?php $_SESSION['pseudo'] = "Anonyme" ?>
    <a href="compte.php" class="boutonConnexion">Se connecter</a>
    <a href="compte.php"><img src="../images/profil.png" class="iconeCompte"></a>
</div>
<?php
	}
}
else{
	$_SESSION['connecter'] = 0; ?>
<div id="statutCompte">
    <span class="spanPseudo">Anonyme</span>
    <?php $_SESSION['pseudo'] = "Anonyme" ?>
    <a href="compte.php" class="boutonConnexion">Se connecter</a>
    <a href="compte.php"><img src="../images/profil.png" class="iconeCompte"></a>
</div>
<?php
} ?>
