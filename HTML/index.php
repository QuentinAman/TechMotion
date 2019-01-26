<?php session_start() ?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>TechMotion - Actualités</title>
    <link rel="stylesheet" href="../CSS/style2.css" />
</head>

<body>
    <?php
	include("statut.php");
	include("header.php");
    $bdd = new PDO('mysql:host=localhost;dbname=id8487019_techmotion;charset=utf8', 'id8487019_quentinaman', 'chouchou');
	$reponse = $bdd->query('SELECT * FROM articles ORDER BY id DESC LIMIT 9');

	$donnees = $reponse->fetch()
	?>
    <div id="premierGroupe">
        <a href="articles.php?id=<?= htmlspecialchars($donnees['id']) ?>" id="articleJour" style="background-image: url('<?= htmlspecialchars($donnees['image']) ?>');">
            <p id="titreArticleJour">
                <?= htmlspecialchars($donnees['titre']) ?>
            </p>
        </a>
        <div id="groupeArticleSemaine">
            <?php 
		$i = 0;
		while ($i < 4):
			$donnees = $reponse->fetch();
			$i += 1 ?>
            <a href="articles.php?id=<?= htmlspecialchars($donnees['id']) ?>" id="articleSemaine" style="background-image: url('<?= htmlspecialchars($donnees['image']) ?>');">
                <p id="titreArticleSemaine">
                    <?= htmlspecialchars($donnees['titre']) ?>
                </p>
            </a>
            <?php endwhile;
			$i = 0; ?>
        </div>
    </div>
    <h1>Les nouvelles de la semaine</h1>
    <div id="groupeArticleAncien">
        <?php
		while ($i < 4):
			$donnees = $reponse->fetch();
			$i += 1 ?>
        <a href="articles.php?id=<?= htmlspecialchars($donnees['id']) ?>" id="articleAncien">
            <img src="<?= htmlspecialchars($donnees['image']) ?>" id="photoArticleAncien" style="size: 100% 100%;" />
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
    <?php include("footer.php"); ?>
</body>

</html>
