<?php session_start();
$bdd = new PDO('mysql:host=localhost;dbname=id8487019_techmotion;charset=utf8', 'id8487019_quentinaman', 'chouchou');
if(isset($_POST['nomArticle'])) {
    $reponse = $bdd -> query("SELECT id FROM articles ORDER BY id DESC");
    $donnees = $reponse-> fetch();
    $requete = $bdd -> prepare('INSERT INTO articles(id, titre, contenu, image, article) VALUES(:id, :titre, :contenu, :image, :article)');
    $requete->execute(array(
        'id' => $donnees['id'] + 1,
        'titre' => $_POST['nomArticle'],
        'contenu' => $_POST['resumeArticle'],
        'image' => $_POST['imageArticle'],
        'article' => $_POST['contenuArticle']
    ));
}
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Publication d'un nouvel article</title>
    <link rel="stylesheet" href="../CSS/style2.css">
</head>

<body>
    <?php include("header.php")?>
    <form method="post" action="publication.php" id="cadreSujet">
        <h1>Création d'un nouvel article</h1>
        <p><label for="nomArticle">Nom de l'article : </label><input type="text" name="nomArticle" required></p>
        <p><label for="imageArticle">Lien de l'image de l'article :</label><input type="text" name="imageArticle" required></p>
        <p><label for="resumeArticle">Résumé de l'article :</label><textarea name="resumeArticle" required></textarea></p>
        <p><label for="contenuArticle">Article complet :<a onClick=insererImage()><img src="../images/insererimage.png" id="insererImage"></a></label><textarea id="contenuArticle" name="contenuArticle" required></textarea></p>
        <input type="submit" value="Envoyer" id="envoiForum">
    </form>
    <?php include("footer.php")?>
    <script>
        function insererImage() {
            var pImage = document.getElementById("insererImage");
            contenuArticle.value += "\n<img src='REMPLACER CE TEXTE PAR LE LIEN DE L\'IMAGE' id='imageArticle'>\n";
        }

    </script>
</body>

</html>
