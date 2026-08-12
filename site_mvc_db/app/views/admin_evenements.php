<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription ?? "Portfolio artistique d'Annie Roger Chamoulaud."); ?>">
    <meta name="author" content="Jonas Vivier">
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
        form input, form textarea { flex: 1 1 150px; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; }
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
        <form method="post" action="<?php echo rtrim(app_url(), '/'); ?>/admin/evenements/add" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Titre" required>
            <input type="text" name="image" placeholder="URL ou chemin de l'image">
            <input type="file" name="image_file" accept="image/*">
            <input type="text" name="description" placeholder="Description">
            <input type="text" name="date" placeholder="Date">
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
            <form method="post" action="<?php echo rtrim(app_url(), '/'); ?>/admin/evenements/update" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $editEvenement['id']; ?>">
                <input type="text" name="title" placeholder="Titre" value="<?php echo htmlspecialchars($editEvenement['title']); ?>" required>
                <input type="text" name="image" placeholder="URL ou chemin de l'image" value="<?php echo htmlspecialchars($editEvenement['image_path'] ?? $editEvenement['image']); ?>">
                <input type="file" name="image_file" accept="image/*">
                <input type="text" name="description" placeholder="Description" value="<?php echo htmlspecialchars($editEvenement['description']); ?>">
                <input type="text" name="date" placeholder="Date" value="<?php echo htmlspecialchars($editEvenement['date']); ?>">
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
                    Filtrer par lieu
                    <select name="category" onchange="this.form.submit()">
                        <option value="">Tous les lieux</option>
                        <?php foreach (($categories ?? []) as $cat): ?>
                        <option value="<?php echo htmlspecialchars($cat['meta']); ?>" <?php echo (($category ?? '') === $cat['meta']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cat['meta']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </label>
            </form>
            <?php if (!empty($category)): ?>
            <a href="<?php echo rtrim(app_url(), '/'); ?>/admin/evenements">Réinitialiser</a>
            <?php endif; ?>
        </div>
        <table>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Titre</th>
                <th>Description</th>
                <th>Date</th>
                <th>Méta</th>
                <th class="actions">Actions</th>
            </tr>
            <?php if (!empty($evenements)): ?>
            <?php foreach ($evenements as $e): ?>
            <tr>
                <td><?php echo $e['id']; ?></td>
                <td>
                    <?php if (!empty($e['image'])): ?>
                    <img src="<?php echo htmlspecialchars($e['image']); ?>" alt="" style="max-width:80px;">
                    <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($e['title']); ?></td>
                <td><?php echo htmlspecialchars($e['description']); ?></td>
                <td><?php echo htmlspecialchars($e['date']); ?></td>
                <td><?php echo htmlspecialchars($e['meta']); ?></td>
                <td class="actions">
                    <a href="<?php echo rtrim(app_url(), '/'); ?>/admin/evenements?edit=<?php echo $e['id']; ?>" style="padding:0.5rem 1rem;background:#0066cc;color:#fff;text-decoration:none;border-radius:4px;margin-right:0.5rem;">Modifier</a>
                    <form method="post" action="<?php echo rtrim(app_url(), '/'); ?>/admin/evenements/delete" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $e['id']; ?>">
                        <button type="submit" onclick="return confirm('Supprimer cet événement ?');">Supprimer</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </div>
    <?php require __DIR__ . '/partials/legal_footer.php'; ?>
</body>
</html>
