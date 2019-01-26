<?php session_start();
if (isset($_GET['choixCompte']) && $_GET['choixCompte'] == 0) {
	$_SESSION['choixCompte'] = $_GET['choixCompte'];
}
elseif(isset($_GET['choixCompte']) && $_GET['choixCompte'] == 1) {
	$_SESSION['choixCompte'] = $_GET['choixCompte'];
} else {
	$_SESSION['choixCompte'] = 0;
}
$bdd = new PDO('mysql:host=localhost;dbname=article;charset=utf8', 'root', '');
$reponse = $bdd -> query('SELECT * FROM compte');
if (isset($_POST['mail']) && isset($_POST['pseudo']) && isset($_POST['motDePasse']) && $_POST['connexion'] == 0) {
	$dejaUtilise = false;
	$adresseMailValide = false;
	if (filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
		$adresseMailValide = true;
	} else {
		$messageConnexion = "L'adresse mail n'est pas valide.";
		$_SESSION['choixCompte'] = 1;
	}
	while ($donnees = $reponse -> fetch()) {
		if ($_POST['mail'] == $donnees['mail'] || $_POST['pseudo'] == $donnees['pseudo']) {
			$messageConnexion = "L'adresse mail ou le pseudo est déjà utilisé.";
			$dejaUtilise = true;
			$_SESSION['choixCompte'] = 0;
		}
	}
	if ($dejaUtilise == false && $adresseMailValide == true) {
		$messageConnexion = "Votre compte a bien éte créer.";
		$req = $bdd -> prepare('INSERT INTO compte(mail, pseudo, motDePasse) VALUES(:mail, :pseudo, :motDePasse)');
		$req -> execute(array(
			'mail' => $_POST['mail'],
			'pseudo' => $_POST['pseudo'],
			'motDePasse' => $_POST['motDePasse']));
	}
}
elseif(isset($_POST['pseudo']) && isset($_POST['motDePasse']) && $_POST['connexion'] == 1) {
	$bonIdentifiant = false;
	while ($donnees = $reponse -> fetch()) {
		if ($_POST['pseudo'] == $donnees['pseudo'] && $_POST['motDePasse'] == $donnees['motDePasse']) {
			$_SESSION['connecter'] = 1;
			$_SESSION['pseudo'] = $donnees['pseudo'];
			$_SESSION['mail'] = $donnees['mail'];
            $_SESSION['admin'] = $donnees['admin'];
			$bonIdentifiant = true;
            header("Location: index.php");
            exit;
		}
	}
	if ($bonIdentifiant == false) {
		$messageConnexion = "Le pseudo ou le mot de passe n'est pas correct.";
		$_SESSION['choixCompte'] = 0;
	}
} ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>TechMotion - Compte</title>
    <link rel="stylesheet" href="../CSS/style2.css">
</head>

<body>
    <div id="contenuPage">
        <?php include('statut.php');
	include('header.php'); 
	if ($_SESSION['connecter'] == 0) { ?>
        <form method="post" action="compte.php">
            <p id="messageLabel">Pour pouvoir parler sur le forum, vous devez vous inscrire ou vous identifier :</p>
            <p id="formulaire">
                <?php 
				if($_SESSION['choixCompte'] == 1) { ?>
                <label id="labelInscriptionConnexion">S'inscrire</label>
                <?php if (isset($messageConnexion)) {
						 echo "<label id='messageConnexion'>$messageConnexion</label>";
					} ?>
                <label id="labelInputInfos" for="mail">Adresse Mail :</label><input type="text" name="mail" id="inputMail" required placeholder="Ex: rorodu63@gmail.com">
                <label id="labelInputInfos" for="pseudo">Pseudo :</label><input type="text" name="pseudo" required placeholder="Ex: rorodu63">
                <label id="labelInputInfos" for="motDePasse">Mot de passe :</label><input type="password" name="motDePasse" required placeholder="Ex: motdepassederorodu63">
                <input type="hidden" name="connexion" value="0">
                <input type="submit" value="Envoyer" class="boutonEnvoi">
                <a href="compte.php?choixCompte=0" id="boutonChangementInscription">Se connecter</a>
            </p>
            <?php }
				elseif ($_SESSION['choixCompte'] == 0) { ?>
            <label id="labelInscriptionConnexion">S'identifier</label>
            <?php if (isset($messageConnexion)) {
						 echo "<label id='messageConnexion'>$messageConnexion</label>";
					} ?>
            <label id="labelInputInfos" for="pseudo">Pseudo :</label><input type="text" name="pseudo" required placeholder="Ex: rorodu63">
            <label id="labelInputInfos" for="motDePasse">Mot de passe :</label><input type="password" name="motDePasse" required placeholder="Ex: motdepassederorodu63">
            <input type="hidden" name="connexion" value="1">
            <input type="submit" value="Envoyer" class="boutonEnvoi">
            <a href="compte.php?choixCompte=1" id="boutonChangementInscription">S'inscrire</a>
            <?php }; ?>
        </form>
        <?php }
	elseif ($_SESSION['connecter'] == 1) { ?>
        <div id="divCompte">
            <h1>Mes informations</h1>
            <p>Mon adresse mail :
                <?php echo $_SESSION['mail'] ?>
            </p>
            <p>Mon pseudo :
                <?php echo $_SESSION['pseudo'] ?>
            </p>
            <?php if($_SESSION['admin'] == true) { ?>
            <div id="boutonCompte">
                <a href="publication.php" id="creerNouvelArticle">Écrire un nouvel article</a>
                <a href="deconnexion.php" id="deconnexion">Déconnexion</a>
            </div>
            <?php } ?>
        </div>
        <?php }; ?>
    </div>
    <?php include('footer.php'); ?>
</body>

</html>
