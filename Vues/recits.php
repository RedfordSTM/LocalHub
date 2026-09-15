<?php

declare(strict_types=1);

ob_start();
?>

<header>
    <h1>Récits utilisateurs et Critères d'acceptation</h1>
    <p>Projet : <strong><?= htmlspecialchars($nomProjet, ENT_QUOTES, 'UTF-8') ?></strong> | Auteur : <?= htmlspecialchars($auteur, ENT_QUOTES, 'UTF-8') ?></p>
</header>

<hr>

<?php if (empty($recits)): ?>
    <p>Aucun récit n'est disponible pour le moment.</p>
<?php else: ?>
    <?php foreach ($recits as $recit): ?>
        <article class="recit-card">
            <h3>Récit <?= (int) $recit['id'] ?> : <?= htmlspecialchars($recit['titre'], ENT_QUOTES, 'UTF-8') ?></h3>
            <p><em><?= htmlspecialchars($recit['description'], ENT_QUOTES, 'UTF-8') ?></em></p>

            <h4>Critères d'acceptation :</h4>
            <ul class="criteres-list">
                <?php foreach ($recit['criteres'] as $critere): ?>
                    <li><?= htmlspecialchars($critere, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
            </ul>
        </article>
    <?php endforeach; ?>
<?php endif; ?>

<?php
$contenu = ob_get_clean();
require __DIR__ . '/gabarit.php';
