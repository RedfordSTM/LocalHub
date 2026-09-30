<?php $premierChampErreur = array_key_first($erreurs ?? []); ?>

<h1>Demander un emprunt</h1>
<p><strong>Outil :</strong> <?= htmlspecialchars($outil['titre'], ENT_QUOTES, 'UTF-8') ?></p>
<p><strong>Propriétaire :</strong> <?= htmlspecialchars($outil['prenom'] . ' ' . $outil['nom'], ENT_QUOTES, 'UTF-8') ?></p>

<?php if (!empty($erreurs)): ?>
    <div id="resume-erreurs" role="alert" style="background: #fee; border: 1px solid #c99; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
        <h2>Le formulaire contient des erreurs</h2>
        <ul>
        <?php foreach ($erreurs as $erreur): ?>
            <li><?= htmlspecialchars($erreur, ENT_QUOTES, 'UTF-8') ?></li>
        <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="index.php?action=ajouter-emprunt" method="post">
    <input type="hidden" name="jeton_csrf"
           value="<?= htmlspecialchars(jetonCsrf(), ENT_QUOTES, 'UTF-8') ?>">
    <input type="hidden" name="id_publication" value="<?= (int) $outil['id_publication'] ?>">

    <fieldset>
        <legend>Dates d'emprunt</legend>

        <label for="date_debut">Date de début *</label>
        <input id="date_debut" name="date_debut" type="date" required
               <?= isset($erreurs['date_debut']) ? 'aria-invalid="true" aria-describedby="erreur-date_debut"' : '' ?>
               <?= $premierChampErreur === 'date_debut' ? 'autofocus' : '' ?>
               value="<?= htmlspecialchars($valeurs['date_debut'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <?php if (isset($erreurs['date_debut'])): ?>
            <p id="erreur-date_debut" style="color: #c00; font-size: 0.9em;">
                <?= htmlspecialchars($erreurs['date_debut'], ENT_QUOTES, 'UTF-8') ?>
            </p>
        <?php endif; ?>

        <label for="date_fin">Date de fin *</label>
        <input id="date_fin" name="date_fin" type="date" required
               <?= isset($erreurs['date_fin']) ? 'aria-invalid="true" aria-describedby="erreur-date_fin"' : '' ?>
               <?= $premierChampErreur === 'date_fin' ? 'autofocus' : '' ?>
               value="<?= htmlspecialchars($valeurs['date_fin'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <?php if (isset($erreurs['date_fin'])): ?>
            <p id="erreur-date_fin" style="color: #c00; font-size: 0.9em;">
                <?= htmlspecialchars($erreurs['date_fin'], ENT_QUOTES, 'UTF-8') ?>
            </p>
        <?php endif; ?>
    </fieldset>

    <fieldset>
        <legend>Détails de la demande</legend>

        <label for="message">Message au propriétaire (optionnel)</label>
        <textarea id="message" name="message" maxlength="500"
                  <?= isset($erreurs['message']) ? 'aria-invalid="true" aria-describedby="erreur-message"' : '' ?>
                  <?= $premierChampErreur === 'message' ? 'autofocus' : '' ?>
                  placeholder="Ex: Je peux m'organiser pour le chercher samedi matin."><?= htmlspecialchars($valeurs['message'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
        <?php if (isset($erreurs['message'])): ?>
            <p id="erreur-message" style="color: #c00; font-size: 0.9em;">
                <?= htmlspecialchars($erreurs['message'], ENT_QUOTES, 'UTF-8') ?>
            </p>
        <?php endif; ?>
        <small>Maximum 500 caractères</small>
    </fieldset>

    <div style="margin-top: 20px;">
        <button type="submit" style="background: #0066cc; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 1em;">
            Soumettre la demande d'emprunt
        </button>
        <a href="index.php?action=emprunts" style="margin-left: 10px; color: #0066cc; text-decoration: none;">
            Annuler
        </a>
    </div>
</form>

<style>
    fieldset { border: 1px solid #ddd; padding: 15px; margin: 15px 0; border-radius: 4px; }
    legend { padding: 0 10px; font-weight: bold; }
    label { display: block; margin-top: 12px; font-weight: bold; }
    input[type="date"], textarea { width: 100%; max-width: 400px; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; font-family: Arial, sans-serif; }
    textarea { resize: vertical; min-height: 100px; }
    input[aria-invalid="true"], textarea[aria-invalid="true"] { border-color: #c00; background-color: #fee; }
    small { display: block; margin-top: 5px; color: #666; }
</style>