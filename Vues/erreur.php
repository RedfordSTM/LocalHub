<?php

declare(strict_types=1);

$titrePage = $titrePage ?? 'Erreur - LocalHub';

ob_start();
?>

<h1>Erreur</h1>
<p><?= htmlspecialchars($messageErreur ?? 'Une erreur est survenue.', ENT_QUOTES, 'UTF-8') ?></p>

<?php
$contenu = ob_get_clean();
require __DIR__ . '/gabarit.php';
