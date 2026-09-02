<?php

declare(strict_types=1);

$nomProjet = 'SkillyHub';
$auteur = 'Redford S. St-M.';
$versionPhp = PHP_VERSION;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($nomProjet, ENT_QUOTES, 'UTF-8') ?></title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; max-width: 800px; margin: 20px auto; padding: 0 15px; }
        nav { background: #f4f4f4; padding: 10px; margin-bottom: 20px; border-radius: 5px; }
        nav ul { list-style: none; margin: 0; padding: 0; display: flex; gap: 15px; }
        nav a { text-decoration: none; color: #0066cc; font-weight: bold; }
        nav a:hover { text-decoration: underline; }
        .highlight { font-weight: bold; margin-top: 10px; display: block; }
    </style>
</head>
<body>

    <nav>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="recits.php">Récits utilisateurs</a></li>
            <li><a href="#">Activités (À venir)</a></li>
            <li><a href="#">Services (À venir)</a></li>
        </ul>
    </nav>

    <header>
        <h1><?= htmlspecialchars($nomProjet, ENT_QUOTES, 'UTF-8') ?></h1>
        <p><strong>Auteur :</strong> <?= htmlspecialchars($auteur, ENT_QUOTES, 'UTF-8') ?></p>
        <p><small>Version PHP : <?= htmlspecialchars($versionPhp, ENT_QUOTES, 'UTF-8') ?></small></p>
    </header>

    <hr>

    <main>
        <section>
            <h2>Le problème concret</h2>
            <p>
                Le but de ce site Web est de rendre l'échange de compétences et de matériel plus facile et local.
                Il permet à chacun d'organiser, pendant son temps libre, des échanges de services, la vente de matériel de seconde main,
                de proposer des activités ou de demander de l'aide pour une tâche spécifique.
            </p>
            <span class="highlight">Ce dont une personne a besoin peut être quelque chose qu'un autre possède, sait faire ou souhaite partager.</span>
        </section>

        <section>
            <h2>Public cible</h2>
            <p>Les personnes concernées sont les résidents d'une ville ou d'un quartier, selon le type de service offert.</p>
        </section>
    </main>

</body>
</html>