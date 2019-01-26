<?php session_start();
if (isset($_GET['page'])) {
	$numeroPage = ($_GET['page']-1)*10;
}
else {
	$numeroPage = 0;
} ?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>TechMotion - Articles</title>
    <link rel="stylesheet" href="../CSS/style2.css" />
</head>

<body>
    <?php include("statut.php");
	include("header.php");
	$bdd = new PDO('mysql:host=localhost;dbname=article;charset=utf8', 'root', '');
	if (isset($_GET['id']) && intval($_GET['id']) == $_GET['id']) {
		$reponse = $bdd->prepare('SELECT * FROM articles WHERE id = ?');
		$reponse->execute(array( $_GET['id'])); // TODO: vérifier que $_GET['id'] existe (isset - et éventuellement est numérique - filter_var)
		if ($donnees = $reponse->fetch()) {
	   		?>
    <div id="articleComplet">
        <p id="titreArticleComplet">
            <?= htmlspecialchars($donnees['titre'])?>
        </p>
        <img src="<?= htmlspecialchars($donnees['image'])?>" id="photoArticleComplet" />
        <p id="contenuArticleComplet">
            <?php echo $donnees['article']?>
        </p>
    </div>
    <?php
		}
		else {
	    	echo "on dirait bien qu'il y a une erreur sur le numéro de l'article.";
		}
	}
	else {
		?>
    <div id="listeArticles">
        <h1 style="margin-top:5%;" id="h1DerniersArticles">Nos derniers articles</h1>
        <?php
			$reponse = $bdd->query("SELECT * FROM articles WHERE id > '$numeroPage' AND id <= ('$numeroPage'+10) ORDER BY id DESC LIMIT 10");
			while ($donnees = $reponse->fetch()): ?>
        <a href="articles.php?id=<?= htmlspecialchars($donnees['id']) ?>" id="articleAncien">
            <img src="<?= htmlspecialchars($donnees['image']) ?>" id="photoArticleAncien" />
            <div id="divArticleAncien">
                <p id="titreArticleAncien">
                    <?= htmlspecialchars($donnees['titre']) ?>
                </p>
                <p id="resumeArticleAncien">
                    <?= htmlspecialchars($donnees['contenu']) ?>
                </p>
            </div>
            <span id="titrePetitEcran">
                <?= htmlspecialchars($donnees['titre']) ?></span>
        </a>
        <?php endwhile; ?>
    </div>
    <div id="nbPage">
        <?php $reponse = $bdd->query("SELECT COUNT('id') as nbLigne FROM articles");
			$nbArticle = $reponse -> fetch();
			$i = 1;
			if($nbArticle['nbLigne'] % 10 == 0) {
				$nbPageMin = $nbArticle['nbLigne'] / 10;
			}
			else {
				$nbPageMin = ($nbArticle['nbLigne'] / 10) + 1;
			}
			while ( $i <= $nbPageMin) { ?>
        <a href="articles.php?page=<?= htmlspecialchars($i)?>" id="lienPage">
            <?= htmlspecialchars($i);
			 	$i += 1 ;?> </a>
        <?php } ?>
    </div>
    <?php }
	include("footer.php"); ?>
</body>

</html>
