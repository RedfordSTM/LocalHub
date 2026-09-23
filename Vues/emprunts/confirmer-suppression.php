<?php ob_start(); ?>

<h1>Annuler la demande d'emprunt</h1>

<div style="background: #fef3cd; border: 1px solid #ffc107; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
    <p>
        Vous allez annuler votre demande d'emprunt pour <strong><?= htmlspecialchars($emprunt['titre'], ENT_QUOTES, 'UTF-8') ?></strong>.
    </p>
    <p style="color: #856404;">
        ⚠️ Le propriétaire sera notifié de cette annulation.
    </p>
</div>

<div style="background: #f9f9f9; border: 1px solid #ddd; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
    <p><strong>Outil :</strong> <?= htmlspecialchars($emprunt['titre'], ENT_QUOTES, 'UTF-8') ?></p>
    <p>
        <strong>Dates demandées :</strong> 
        <?= htmlspecialchars($emprunt['date_debut'], ENT_QUOTES, 'UTF-8') ?> 
        → 
        <?= htmlspecialchars($emprunt['date_fin'], ENT_QUOTES, 'UTF-8') ?>
    </p>
    <p><strong>Statut :</strong> 
        <?php 
            $statuts = [
                'en_attente' => 'En attente de réponse',
                'approuvee' => 'Approuvée',
                'rejetee' => 'Rejetée',
                'completee' => 'Complétée',
                'annulee' => 'Annulée'
            ];
            echo htmlspecialchars($statuts[$emprunt['statut']] ?? $emprunt['statut'], ENT_QUOTES, 'UTF-8');
        ?>
    </p>
    <?php if (!empty($emprunt['message'])): ?>
        <p><strong>Votre message :</strong></p>
        <blockquote style="border-left: 3px solid #0066cc; padding-left: 15px; margin: 10px 0; color: #666;">
            <?= nl2br(htmlspecialchars($emprunt['message'], ENT_QUOTES, 'UTF-8')) ?>
        </blockquote>
    <?php endif; ?>
</div>

<form action="index.php?action=annuler-emprunt" method="post">
    <input type="hidden" name="jeton_csrf"
           value="<?= htmlspecialchars(jetonCsrf(), ENT_QUOTES, 'UTF-8') ?>">
    <input type="hidden" name="id_reservation" value="<?= (int) $emprunt['id_reservation'] ?>">

    <button type="submit" style="background: #c00; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 1em;">
        Confirmer l'annulation
    </button>
    <a href="index.php?action=emprunts" style="margin-left: 10px; color: #0066cc; text-decoration: none;">
        Retour
    </a>
</form>

<?php
$contenu = ob_get_clean();
require __DIR__ . '/../gabarit.php';
?>