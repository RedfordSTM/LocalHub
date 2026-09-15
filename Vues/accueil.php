<?php

declare(strict_types=1);

ob_start();
?>

<header>
    <h1><?= htmlspecialchars($nomProjet, ENT_QUOTES, 'UTF-8') ?></h1>
    <p><strong>Auteur :</strong> <?= htmlspecialchars($auteur, ENT_QUOTES, 'UTF-8') ?></p>
</header>

<hr>

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

<section>
    <h2>Publications récentes</h2>
    <?php if (empty($publicationsRecentes)): ?>
        <p>Aucune publication n'est disponible pour le moment.</p>
    <?php else: ?>
        <ul class="details-list">
            <?php foreach ($publicationsRecentes as $publication): ?>
                <li>
                    <strong><?= htmlspecialchars($publication['titre'], ENT_QUOTES, 'UTF-8') ?></strong>
                    — <?= htmlspecialchars($publication['ville'], ENT_QUOTES, 'UTF-8') ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <p><a href="ressources.php">Voir toutes les publications</a></p>
    <?php endif; ?>
</section>

<?php
$contenu = ob_get_clean();
require __DIR__ . '/gabarit.php';
