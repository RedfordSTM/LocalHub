<?php ob_start(); ?>

<style>
    .lending-filters { background: #f9f9f9; padding: 15px; margin-bottom: 20px; border-radius: 5px; }
    .lending-item { border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #fafafa; }
    .lending-item h3 { margin-top: 0; color: #0066cc; }
    .item-details { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; margin: 10px 0; font-size: 0.95em; }
    .item-details strong { color: #333; }
    .btn-borrow { background: #0066cc; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; display: inline-block; margin-top: 10px; }
    .btn-borrow:hover { background: #0052a3; }
    .location { color: #666; font-size: 0.9em; }
    .owner { color: #666; margin-top: 10px; font-size: 0.9em; }
</style>

<h1>Emprunts et partage de matériel</h1>

<div class="lending-filters">
    <p><strong>Filtrer par :</strong></p>
    <form method="get" action="index.php">
        <input type="hidden" name="action" value="emprunts">
        <label>
            Ville : 
            <input type="text" name="ville" placeholder="Montréal, Laval...">
        </label>
        <button type="submit">Rechercher</button>
    </form>
</div>

<?php if (empty($outils)): ?>
    <p>Aucun outil disponible pour le moment dans votre région.</p>
<?php else: ?>
    <?php foreach ($outils as $outil): ?>
        <div class="lending-item">
            <h3><?= htmlspecialchars($outil['titre'], ENT_QUOTES, 'UTF-8') ?></h3>
            
            <p><?= htmlspecialchars($outil['description'], ENT_QUOTES, 'UTF-8') ?></p>
            
            <div class="item-details">
                <div>
                    <strong>Lieu :</strong>
                    <span class="location"><?= htmlspecialchars($outil['ville'], ENT_QUOTES, 'UTF-8') ?></span>
                </div>
                <div>
                    <strong>Catégorie :</strong>
                    <span><?= htmlspecialchars($outil['categorie'], ENT_QUOTES, 'UTF-8') ?></span>
                </div>
            </div>

            <div class="owner">
                <strong>Propriétaire :</strong> 
                <?= htmlspecialchars($outil['prenom'] . ' ' . $outil['nom'], ENT_QUOTES, 'UTF-8') ?>
            </div>

            <a href="index.php?action=demander-emprunt&id=<?= (int) $outil['id_publication'] ?>" class="btn-borrow">
                Demander à emprunter →
            </a>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php
$contenu = ob_get_clean();
require __DIR__ . '/../gabarit.php';
?>