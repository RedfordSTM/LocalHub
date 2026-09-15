<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($titrePage ?? 'LocalHub', ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <nav>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="recits.php">Récits utilisateurs</a></li>
            <li><a href="ressources.php">Publications</a></li>
            <li><a href="#">Activités (À venir)</a></li>
            <li><a href="#">Services (À venir)</a></li>
        </ul>
    </nav>

    <main>
        <?= $contenu ?>
    </main>

</body>
</html>