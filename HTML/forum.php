<?php session_start();
$bdd = new PDO('mysql:host=localhost;dbname=id8487019_techmotion;charset=utf8', 'id8487019_quentinaman', 'chouchou');
if(isset($_GET['idSujet']) || isset($_POST['idSujet'])){
    $forum = "sujet";
    if(isset($_GET['idSujet'])) {
        $numeroSujet = $_GET['idSujet'];
    } else {
        $numeroSujet = $_POST['idSujet'];
    }
}else if(isset($_GET['creerSujet'])) {
    $forum = "nouveauSujet";
} else {
    $forum = "accueil";
}
if (isset($_GET['page'])) {
	$numeroPage = ($_GET['page']-1)*20;
}
else {
	$numeroPage = 0;
}
if(isset($_POST['idSujet'])) {
    $reponse = $bdd -> query("SELECT * FROM sujetforum ORDER BY id DESC");
    $donnees = $reponse-> fetch();
    $requete = $bdd -> prepare('INSERT INTO forum(id, numeroSujet, pseudo, commentaire, date) VALUES(:id, :numeroSujet, :pseudo, :commentaire, :date)');
    $requete->execute(array(
        'id' => $donnees['id'] + 1,
        'numeroSujet' => $_POST['idSujet'],
        'pseudo' => $_SESSION['pseudo'],
        'commentaire' => $_POST['commentaire'],
        'date' => date("d/m/Y")
    ));
}
if(isset($_POST['nomDuSujet'])) {
    $reponse = $bdd -> query("SELECT * FROM sujetforum ORDER BY id DESC");
    $donnees = $reponse-> fetch();
    $requete = $bdd -> prepare('INSERT INTO sujetforum(id, titre, createur, date) VALUES(:id, :titre, :createur, :date)');
    $requete->execute(array(
        'id' => $donnees['id'] + 1,
        'titre' => $_POST['nomDuSujet'],
        'createur' => $_SESSION['pseudo'],
        'date' => date("d/m/Y")
    ));
    $reponse = $bdd -> prepare('SELECT id FROM sujetforum WHERE titre = :nomDuSujet AND createur = :pseudo');
    $reponse->execute(array('nomDuSujet' => $_POST['nomDuSujet'], 'pseudo' => $_SESSION['pseudo']));
    $donnees = $reponse->fetch();
    $requete = $bdd->prepare('INSERT INTO forum(numeroSujet, pseudo, commentaire, date) VALUES(:numeroSujet, :pseudo, :commentaire, :date)');
    $requete->execute(array(
        'numeroSujet' => $donnees['id'],
        'pseudo' => $_SESSION['pseudo'],
        'commentaire' => $_POST['message'],
        'date' => date("d/m/Y")
    ));
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>TechMotion - Forum</title>
    <link rel="stylesheet" href="../CSS/style2.css">
</head>

<body>
    <div id="contenuPage">
        <?php include("statut.php");
        include('header.php'); ?>
        <div id="forum">
            <?php
        if($forum === "sujet") { ?>
            <div id="cadreSujet">
                <?php $reponse = $bdd -> query("SELECT * FROM sujetforum WHERE id = '$numeroSujet'");
            $donnees = $reponse -> fetch(); ?>
                <h1>
                    <?= htmlspecialchars($donnees["titre"])?>
                </h1>
                <?php $reponse = $bdd -> query("SELECT * FROM forum WHERE numeroSujet = '$numeroSujet' ORDER BY id");
            while($donnees = $reponse -> fetch()) { ?>
                <div id="commentaire">
                    <div id="infoCommentaire">
                        <span id="auteurCommentaire">
                            <?= htmlspecialchars($donnees["pseudo"])?></span>
                        <span id="dateCommentaire">
                            <?= htmlspecialchars($donnees["date"])?></span>
                    </div>
                    <div id="texteCommentaire">
                        <span>
                            <?= htmlspecialchars($donnees["commentaire"])?></span>
                    </div>
                </div>
                <?php } ?>
                <form method="post" action="forum.php" name="nouveauCommentaire">
                    <textarea name="commentaire" id="inputCommentaire" placeholder="Entrez votre commentaire içi" required></textarea>
                    <input type="hidden" name="idSujet" value="<?= htmlspecialchars($numeroSujet)?>">
                    <input type="submit" value="Envoyer" id="envoiForum">
                </form>
            </div>
            <?php } else if($forum === "nouveauSujet") { ?>
            <form method="post" action="forum.php" id="cadreSujet">
                <h1>Création d'un nouveau sujet</h1>
                <p><label for="nomDuSujet">Nom du sujet : </label><input type="text" name="nomDuSujet" required></p>
                <p><label for="message">Votre message : </label><textarea name="message" required></textarea></p>
                <input type="submit" value="Envoyer" id="envoiForum">
            </form>
            <?php } else {
            $reponse = $bdd -> query("SELECT * FROM sujetforum WHERE id > '$numeroPage' AND id <= ('$numeroPage'+20) ORDER BY id DESC LIMIT 20"); ?>
            <a href="forum.php?creerSujet=true" id="boutonCreerSujet">Créer un sujet</a>
            <?php while ($donnees = $reponse -> fetch()) { ?>
            <a href="forum.php?idSujet=<?= htmlspecialchars($donnees['id']) ?>" id="sujet">
                <p id="titreSujet">
                    <strong>
                        <?= htmlspecialchars($donnees['titre'])?></strong>
                </p>
                <div id="infoSujet">
                    <p id="createurSujet">Crée par
                        <?= htmlspecialchars($donnees['createur'])?>
                    </p>
                    <p id="dateSujet">Crée le
                        <?= htmlspecialchars($donnees['date'])?>
                    </p>
                </div>
            </a>
            <?php } ?>
            <div id="nbPage">
                <?php $reponse = $bdd->query("SELECT COUNT('id') as nbLigne FROM sujetforum");
                $nbArticle = $reponse -> fetch();
                $i = 1;
                if($nbArticle['nbLigne'] % 20 == 0) {
                    $nbPageMin = $nbArticle['nbLigne'] / 20;
                }
                else {
                    $nbPageMin = ($nbArticle['nbLigne'] / 20) + 1;
                }
                while ($i <= $nbPageMin) { ?>
                <a href="forum.php?page=<?= htmlspecialchars($i)?>" id="lienPage">
                    <?= htmlspecialchars($i); ?>
                    <?php $i += 1 ;?> </a>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
    </div>
    <?php include('footer.php'); ?>
</body>

</html>
