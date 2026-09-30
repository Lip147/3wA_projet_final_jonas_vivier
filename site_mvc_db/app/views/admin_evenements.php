<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription ?? "Portfolio artistique d'Annie Roger-Chamoulaud."); ?>">
    <meta name="author" content="Jonas Vivier">
    <link rel="icon" type="image/png" href="<?php echo rtrim(app_url(), '/'); ?>/images/logo_arch_fond_blanc2.png">
    <title>Admin - Événements</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; }
        .container { max-width: 900px; margin: 2rem auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px #0001; padding: 2rem; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 2rem; }
        th, td { border: 1px solid #ddd; padding: 0.5rem; text-align: left; }
        th { background: #222; color: #fff; }
        tr:nth-child(even) { background: #f9f9f9; }
        .actions { text-align: center; }
        form { display: flex; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem; }
        form input, form textarea, form select { flex: 1 1 150px; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; }
        .date-field { display: grid; flex: 1 1 180px; gap: 0.35rem; color: #555; font-size: 0.8rem; font-weight: bold; }
        .date-field input, .date-field select { box-sizing: border-box; width: 100%; color: #222; font: inherit; }
        .date-period { display: flex; flex: 2 1 380px; gap: 1rem; }
        .date-period[hidden] { display: none; }
        form input[type="file"] { background: #fafafa; }
        form button { padding: 0.5rem 1.5rem; background: #222; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
        form button:hover { background: #444; }
        .nav { margin-bottom: 2rem; display: flex; gap: 1rem; justify-content: space-between; }
        .nav a { color: #222; text-decoration: none; font-weight: bold; }
        .nav a:hover { text-decoration: underline; }
        .filter-bar { display: flex; align-items: center; justify-content: space-between; gap: 1rem; margin-bottom: 1.5rem; padding: 1rem; background: #f0f0f0; border-radius: 4px; }
        .filter-bar form { margin: 0; }
        .filter-bar select { min-width: 220px; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; }
        .filter-bar a { color: #222; font-weight: bold; text-decoration: none; }
        .filter-bar a:hover { text-decoration: underline; }
        .admin-error { margin-bottom: 1.5rem; padding: 0.85rem 1rem; border-left: 4px solid #b00020; background: #fff0f2; color: #7a0016; }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav">
            <div>
                <a href="<?php echo rtrim(app_url(), '/'); ?>/">Accueil</a>
                <a href="<?php echo rtrim(app_url(), '/'); ?>/admin" style="margin-left:1rem;">Peintures</a>
                <a href="<?php echo rtrim(app_url(), '/'); ?>/admin/coutures" style="margin-left:1rem;">Arts textiles</a>
                <a href="<?php echo rtrim(app_url(), '/'); ?>/admin/evenements" style="margin-left:1rem;">Événements</a>
                <a href="<?php echo rtrim(app_url(), '/'); ?>/contact" style="margin-left:1rem;">Contact</a>
            </div>
            <a href="<?php echo rtrim(app_url(), '/'); ?>/logout" style="color:#c00;">Déconnexion</a>
        </div>
        <h1>Administration des événements</h1>
        <?php if ($adminError !== ''): ?>
        <p class="admin-error" role="alert"><?php echo e($adminError); ?></p>
        <?php endif; ?>
        <form class="event-form" method="post" action="<?php echo rtrim(app_url(), '/'); ?>/admin/evenements/add" enctype="multipart/form-data">
            <?php echo csrf_input(); ?>
            <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo adminMaxImageBytes(); ?>">
            <input type="text" name="title" placeholder="Titre" required>
            <input type="text" name="image" placeholder="URL ou chemin de l'image">
            <input type="file" name="image_file" accept="image/*">
            <input type="text" name="description" placeholder="Description">
            <label class="date-field">
                Précision de la période
                <select name="date_precision" class="date-precision">
                    <option value="day">Dates précises</option>
                    <option value="month">Mois uniquement</option>
                </select>
            </label>
            <div class="date-period" data-date-period="day">
                <label class="date-field">Date de début<input type="date" name="date"></label>
                <label class="date-field">Date de fin (facultative)<input type="date" name="end_date"></label>
            </div>
            <div class="date-period" data-date-period="month" hidden>
                <label class="date-field">Mois de début<input type="month" name="start_month" disabled></label>
                <label class="date-field">Mois de fin (facultatif)<input type="month" name="end_month" disabled></label>
            </div>
            <input type="text" name="meta" placeholder="Méta (ex. : lieu)">
            <button type="submit">Ajouter</button>
        </form>
        <?php if (!empty($_GET['edit'])): ?>
        <div style="background:#f0f0f0;padding:1rem;margin-bottom:2rem;border-radius:4px;border-left:4px solid #222;">
            <h3>Modifier un événement</h3>
            <?php
            $editId = (int)$_GET['edit'];
            $editEvenement = null;
            if (!empty($evenements)) {
                foreach ($evenements as $e) {
                    if ($e['id'] == $editId) {
                        $editEvenement = $e;
                        break;
                    }
                }
            }
            ?>
            <?php if ($editEvenement): ?>
            <?php
            $editPrecision = $editEvenement['date_precision'] === 'month' ? 'month' : 'day';
            $editStartMonth = !empty($editEvenement['date']) ? substr($editEvenement['date'], 0, 7) : '';
            $editEndMonth = !empty($editEvenement['end_date']) ? substr($editEvenement['end_date'], 0, 7) : $editStartMonth;
            ?>
            <form class="event-form" method="post" action="<?php echo rtrim(app_url(), '/'); ?>/admin/evenements/update" enctype="multipart/form-data">
                <?php echo csrf_input(); ?>
                <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo adminMaxImageBytes(); ?>">
                <input type="hidden" name="id" value="<?php echo (int)$editEvenement['id']; ?>">
                <input type="text" name="title" placeholder="Titre" value="<?php echo htmlspecialchars($editEvenement['title']); ?>" required>
                <input type="text" name="image" placeholder="URL ou chemin de l'image" value="<?php echo htmlspecialchars($editEvenement['image_path'] ?? $editEvenement['image']); ?>">
                <input type="file" name="image_file" accept="image/*">
                <input type="text" name="description" placeholder="Description" value="<?php echo htmlspecialchars($editEvenement['description']); ?>">
                <label class="date-field">
                    Précision de la période
                    <select name="date_precision" class="date-precision">
                        <option value="day" <?php echo $editPrecision === 'day' ? 'selected' : ''; ?>>Dates précises</option>
                        <option value="month" <?php echo $editPrecision === 'month' ? 'selected' : ''; ?>>Mois uniquement</option>
                    </select>
                </label>
                <div class="date-period" data-date-period="day" <?php echo $editPrecision === 'day' ? '' : 'hidden'; ?>>
                    <label class="date-field">Date de début<input type="date" name="date" value="<?php echo htmlspecialchars($editEvenement['date']); ?>" <?php echo $editPrecision === 'day' ? '' : 'disabled'; ?>></label>
                    <label class="date-field">Date de fin (facultative)<input type="date" name="end_date" value="<?php echo htmlspecialchars($editEvenement['end_date'] ?? ''); ?>" <?php echo $editPrecision === 'day' ? '' : 'disabled'; ?>></label>
                </div>
                <div class="date-period" data-date-period="month" <?php echo $editPrecision === 'month' ? '' : 'hidden'; ?>>
                    <label class="date-field">Mois de début<input type="month" name="start_month" value="<?php echo htmlspecialchars($editStartMonth); ?>" <?php echo $editPrecision === 'month' ? '' : 'disabled'; ?>></label>
                    <label class="date-field">Mois de fin (facultatif)<input type="month" name="end_month" value="<?php echo htmlspecialchars($editEndMonth); ?>" <?php echo $editPrecision === 'month' ? '' : 'disabled'; ?>></label>
                </div>
                <input type="text" name="meta" placeholder="Méta (ex. : lieu)" value="<?php echo htmlspecialchars($editEvenement['meta']); ?>">
                <button type="submit">Mettre à jour</button>
                <a href="<?php echo rtrim(app_url(), '/'); ?>/admin/evenements" style="padding:0.5rem 1.5rem;background:#999;color:#fff;text-decoration:none;border-radius:4px;cursor:pointer;">Annuler</a>
            </form>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <div class="filter-bar">
            <form method="get" action="<?php echo rtrim(app_url(), '/'); ?>/admin/evenements">
                <label>
                    Filtrer par année
                    <select name="year" onchange="this.form.submit()">
                        <option value="">Toutes les années</option>
                        <?php foreach (($eventYears ?? []) as $year): ?>
                        <option value="<?php echo (int)$year; ?>" <?php echo $year === ($selectedYear ?? null) ? 'selected' : ''; ?>><?php echo (int)$year; ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
            </form>
            <?php if ($selectedYear !== null): ?>
            <a href="<?php echo rtrim(app_url(), '/'); ?>/admin/evenements">Réinitialiser</a>
            <?php endif; ?>
        </div>
        <table>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Titre</th>
                <th>Description</th>
                <th>Période</th>
                <th>Méta</th>
                <th class="actions">Actions</th>
            </tr>
            <?php if (!empty($evenements)): ?>
            <?php foreach ($evenements as $e): ?>
            <tr>
                <td><?php echo (int)$e['id']; ?></td>
                <td>
                    <?php if (!empty($e['image'])): ?>
                    <img src="<?php echo htmlspecialchars($e['image']); ?>" alt="" style="max-width:80px;">
                    <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($e['title']); ?></td>
                <td><?php echo htmlspecialchars($e['description']); ?></td>
                <td><?php echo htmlspecialchars(formatEvenementPeriod($e)); ?></td>
                <td><?php echo htmlspecialchars($e['meta']); ?></td>
                <td class="actions">
                    <a href="<?php echo rtrim(app_url(), '/'); ?>/admin/evenements?edit=<?php echo (int)$e['id']; ?>" style="padding:0.5rem 1rem;background:#0066cc;color:#fff;text-decoration:none;border-radius:4px;margin-right:0.5rem;">Modifier</a>
                    <form method="post" action="<?php echo rtrim(app_url(), '/'); ?>/admin/evenements/delete" style="display:inline;">
                        <?php echo csrf_input(); ?>
                        <input type="hidden" name="id" value="<?php echo (int)$e['id']; ?>">
                        <button type="submit" onclick="return confirm('Supprimer cet événement ?');">Supprimer</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </div>
    <?php require __DIR__ . '/partials/legal_footer.php'; ?>
    <script>
        document.querySelectorAll('.event-form').forEach((form) => {
            const precisionSelect = form.querySelector('.date-precision');
            const periodGroups = form.querySelectorAll('[data-date-period]');

            const updateDateFields = () => {
                periodGroups.forEach((group) => {
                    const isActive = group.dataset.datePeriod === precisionSelect.value;
                    group.hidden = !isActive;
                    group.querySelectorAll('input').forEach((input) => {
                        input.disabled = !isActive;
                    });
                });
            };

            precisionSelect.addEventListener('change', updateDateFields);
            updateDateFields();
        });
    </script>
</body>
</html>
