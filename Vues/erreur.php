<?php ob_start(); ?>
 
<h1>Erreur</h1>
<p style="color: #c00; font-weight: bold;"><?= htmlspecialchars($messageErreur, ENT_QUOTES, 'UTF-8') ?></p>
<p><a href="index.php?action=emprunts">← Retour à l'accueil</a></p>
 
<?php
$contenu = ob_get_clean();
require __DIR__ . '/gabarit.php';
?>