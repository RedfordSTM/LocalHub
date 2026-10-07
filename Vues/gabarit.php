<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/'; ?>
    <base href="<?= htmlspecialchars($baseUrl, ENT_QUOTES, 'UTF-8') ?>">
    <title><?= htmlspecialchars($titrePage ?? 'LocalHub', ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <nav>
        <ul>
            <li><a href="accueil">Accueil</a></li>
            <li><a href="publications">Publications</a></li>
            <li><a href="emprunts">Emprunts</a></li>
            <li><a href="#">Activités (À venir)</a></li>
            <li><a href="#">Services (À venir)</a></li>
        </ul>
    </nav>

    <main>
        <?= $contenu ?>
    </main>

</body>
</html>