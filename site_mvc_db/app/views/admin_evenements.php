<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
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
    </style>
</head>
<body>
    <div class="container">
        <div class="nav">
            <div>
                <a href="/site_mvc_db/public/">Accueil</a>
                <a href="/site_mvc_db/public/admin" style="margin-left:1rem;">Peintures</a>
                <a href="/site_mvc_db/public/admin/coutures" style="margin-left:1rem;">Coutures</a>
                <a href="/site_mvc_db/public/admin/evenements" style="margin-left:1rem;">Événements</a>
                <a href="/site_mvc_db/public/contact" style="margin-left:1rem;">Contact</a>
            </div>
            <a href="/site_mvc_db/public/logout" style="color:#c00;">Déconnexion</a>
        </div>
        <h1>Administration des événements</h1>
        <form method="post" action="/site_mvc_db/public/admin/evenements/add" enctype="multipart/form-data">
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
            <form method="post" action="/site_mvc_db/public/admin/evenements/update" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $editEvenement['id']; ?>">
                <input type="text" name="title" placeholder="Titre" value="<?php echo htmlspecialchars($editEvenement['title']); ?>" required>
                <input type="text" name="image" placeholder="URL ou chemin de l'image" value="<?php echo htmlspecialchars($editEvenement['image']); ?>">
                <input type="file" name="image_file" accept="image/*">
                <input type="text" name="description" placeholder="Description" value="<?php echo htmlspecialchars($editEvenement['description']); ?>">
                <input type="text" name="date" placeholder="Date" value="<?php echo htmlspecialchars($editEvenement['date']); ?>">
                <input type="text" name="meta" placeholder="Méta (ex. : lieu)" value="<?php echo htmlspecialchars($editEvenement['meta']); ?>">
                <button type="submit">Mettre à jour</button>
                <a href="/site_mvc_db/public/admin/evenements" style="padding:0.5rem 1.5rem;background:#999;color:#fff;text-decoration:none;border-radius:4px;cursor:pointer;">Annuler</a>
            </form>
            <?php endif; ?>
        </div>
        <?php endif; ?>
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
                    <a href="/site_mvc_db/public/admin/evenements?edit=<?php echo $e['id']; ?>" style="padding:0.5rem 1rem;background:#0066cc;color:#fff;text-decoration:none;border-radius:4px;margin-right:0.5rem;">Modifier</a>
                    <form method="post" action="/site_mvc_db/public/admin/evenements/delete" style="display:inline;">
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
