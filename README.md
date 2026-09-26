# 3wA_projet_final_jonas_vivier

## Creation du premier administrateur

Le fichier `database.sql` ne contient aucun compte administrateur par defaut.
Apres avoir importe la base, definissez temporairement les variables
`ADMIN_USERNAME`, `ADMIN_EMAIL` et `ADMIN_PASSWORD`, puis executez :

```powershell
php .\site_mvc_db\tools\create-admin.php
```

Le mot de passe doit contenir au moins 14 caracteres. Fournissez
`ADMIN_PASSWORD` avec le gestionnaire de secrets de l'hebergeur et supprimez
la variable de l'environnement apres la creation du compte. Ne placez jamais
ces valeurs dans `.env`, dans le dump SQL ou dans une commande versionnee.

## Limites des images

L'application refuse les images de plus de 8 Mio ou 40 millions de pixels.
En production, configurez egalement PHP avec `upload_max_filesize = 8M` et
`post_max_size = 10M`.
