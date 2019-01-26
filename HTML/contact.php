<?php session_start() ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>TechMotion - Contact</title>
    <link rel="stylesheet" href="../CSS/style2.css">
</head>

<body>
    <div id="contenuPage">
        <?php include("statut.php");
	include('header.php'); ?>
        <h1 style="margin-top:5%;">Mes informations</h1>
        <div id="contact">
            <a href="../FICHIER/cv.pdf" id="cv">
                <div id="moncv">Mon CV</div>
            </a>
            <a href="../FICHIER/lm.pdf" id="lettreMotivation">
                <div id="maLettreMotivation">Ma LM</div>
                <a href="mailto:quentin.aman@outlook.com" id="mail">
                    <div id="monMail">Mon Mail</div>
                </a>
            </a>
        </div>
    </div>
    <?php include('footer.php'); ?>
</body>

</html>
