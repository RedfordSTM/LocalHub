<?php

declare(strict_types=1);

ob_start();
?>

<header>
    <h1>Publications disponibles</h1>
    <p>Projet : <strong><?= htmlspecialchars($nomProjet, ENT_QUOTES, 'UTF-8') ?></strong> | Auteur : <?= htmlspecialchars($auteur, ENT_QUOTES, 'UTF-8') ?></p>
</header>

<hr>

<?php if (empty($publications)): ?>
    <p>Aucune publication n'est disponible pour le moment.</p>
<?php else: ?>
    <?php foreach ($publications as $publication): ?>
        <article class="recit-card">
            <h3><?= htmlspecialchars($publication['titre'], ENT_QUOTES, 'UTF-8') ?></h3>
            <p><?= nl2br(htmlspecialchars($publication['description'], ENT_QUOTES, 'UTF-8')) ?></p>

            <ul class="details-list">
                <li><strong>Catégorie :</strong> <?= htmlspecialchars($publication['categorie'], ENT_QUOTES, 'UTF-8') ?></li>
                <li><strong>Ville :</strong> <?= htmlspecialchars($publication['ville'], ENT_QUOTES, 'UTF-8') ?></li>
                <li>
                    <strong>Prix :</strong>
                    <?= $publication['prix'] !== null ? htmlspecialchars((string) $publication['prix'], ENT_QUOTES, 'UTF-8') . ' $' : 'Non applicable' ?>
                </li>
                <li><strong>Auteur :</strong> <?= htmlspecialchars($publication['prenom'] . ' ' . $publication['nom'], ENT_QUOTES, 'UTF-8') ?></li>
            </ul>
        </article>
    <?php endforeach; ?>
<?php endif; ?>

<?php
$contenu = ob_get_clean();
require __DIR__ . '/../gabarit.php';
