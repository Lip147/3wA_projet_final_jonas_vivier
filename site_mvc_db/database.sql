CREATE DATABASE IF NOT EXISTS mamie_gallery
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE mamie_gallery;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS evenement_media;
DROP TABLE IF EXISTS couture_media;
DROP TABLE IF EXISTS peinture_media;
DROP TABLE IF EXISTS couture_categorie;
DROP TABLE IF EXISTS peinture_categorie;
DROP TABLE IF EXISTS evenements;
DROP TABLE IF EXISTS coutures;
DROP TABLE IF EXISTS peintures;
DROP TABLE IF EXISTS medias;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;

SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('super_admin', 'admin') NOT NULL DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE categories (
    id_categorie INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    type ENUM('peinture', 'couture', 'mixte') NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_category_slug_type (slug, type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE medias (
    id_media INT AUTO_INCREMENT PRIMARY KEY,
    file_path VARCHAR(1024) NOT NULL,
    original_name VARCHAR(255),
    extension VARCHAR(20),
    mime_type VARCHAR(100),
    size_bytes INT UNSIGNED,
    width INT UNSIGNED,
    height INT UNSIGNED,
    alt_text VARCHAR(255),
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    uploaded_by INT NULL,
    CONSTRAINT fk_media_user
        FOREIGN KEY (uploaded_by) REFERENCES users(id_user)
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE peintures (
    id_peinture INT AUTO_INCREMENT PRIMARY KEY,
    author_id INT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    creation_date VARCHAR(100),
    dimensions VARCHAR(255),
    technique VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_peinture_author
        FOREIGN KEY (author_id) REFERENCES users(id_user)
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE coutures (
    id_couture INT AUTO_INCREMENT PRIMARY KEY,
    author_id INT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    creation_date VARCHAR(100),
    dimensions_or_size VARCHAR(255),
    material VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_couture_author
        FOREIGN KEY (author_id) REFERENCES users(id_user)
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE evenements (
    id_evenement INT AUTO_INCREMENT PRIMARY KEY,
    author_id INT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    event_date VARCHAR(100),
    location VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_evenement_author
        FOREIGN KEY (author_id) REFERENCES users(id_user)
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE peinture_media (
    id_peinture INT NOT NULL,
    id_media INT NOT NULL,
    is_main TINYINT(1) NOT NULL DEFAULT 1,
    sort_order INT UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (id_peinture, id_media),
    CONSTRAINT fk_peinture_media_peinture
        FOREIGN KEY (id_peinture) REFERENCES peintures(id_peinture)
        ON DELETE CASCADE,
    CONSTRAINT fk_peinture_media_media
        FOREIGN KEY (id_media) REFERENCES medias(id_media)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE couture_media (
    id_couture INT NOT NULL,
    id_media INT NOT NULL,
    is_main TINYINT(1) NOT NULL DEFAULT 1,
    sort_order INT UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (id_couture, id_media),
    CONSTRAINT fk_couture_media_couture
        FOREIGN KEY (id_couture) REFERENCES coutures(id_couture)
        ON DELETE CASCADE,
    CONSTRAINT fk_couture_media_media
        FOREIGN KEY (id_media) REFERENCES medias(id_media)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE evenement_media (
    id_evenement INT NOT NULL,
    id_media INT NOT NULL,
    is_main TINYINT(1) NOT NULL DEFAULT 1,
    sort_order INT UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (id_evenement, id_media),
    CONSTRAINT fk_evenement_media_evenement
        FOREIGN KEY (id_evenement) REFERENCES evenements(id_evenement)
        ON DELETE CASCADE,
    CONSTRAINT fk_evenement_media_media
        FOREIGN KEY (id_media) REFERENCES medias(id_media)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE peinture_categorie (
    id_peinture INT NOT NULL,
    id_categorie INT NOT NULL,
    PRIMARY KEY (id_peinture, id_categorie),
    CONSTRAINT fk_peinture_categorie_peinture
        FOREIGN KEY (id_peinture) REFERENCES peintures(id_peinture)
        ON DELETE CASCADE,
    CONSTRAINT fk_peinture_categorie_categorie
        FOREIGN KEY (id_categorie) REFERENCES categories(id_categorie)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE couture_categorie (
    id_couture INT NOT NULL,
    id_categorie INT NOT NULL,
    PRIMARY KEY (id_couture, id_categorie),
    CONSTRAINT fk_couture_categorie_couture
        FOREIGN KEY (id_couture) REFERENCES coutures(id_couture)
        ON DELETE CASCADE,
    CONSTRAINT fk_couture_categorie_categorie
        FOREIGN KEY (id_categorie) REFERENCES categories(id_categorie)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO users (username, email, password_hash, role) VALUES
('admin', 'admin@example.com', '$2y$10$YBHSDGF2AjZQziEKn1AO/uxppvOAyfa5jNZMXCfCoDKEYvADFmC4a', 'super_admin');

INSERT INTO categories (name, slug, type, description) VALUES
('Abstrait', 'abstrait', 'peinture', 'Categorie de peintures abstraites'),
('Paysage', 'paysage', 'peinture', 'Categorie de peintures de paysages'),
('Broderie', 'broderie', 'couture', 'Categorie de travaux de broderie'),
('Accessoire', 'accessoire', 'couture', 'Categorie de creations textiles accessoires');

INSERT INTO peintures (author_id, title, description, creation_date, dimensions, technique) VALUES
(1, 'Abstraction Rouge', 'Peinture rouge intense', '2026', '100x80 cm', ''),
(1, 'Fusion Bleue', 'Art bleu fluide', '2026', '120x90 cm', '');

INSERT INTO medias (file_path, original_name, extension, mime_type, alt_text, uploaded_by) VALUES
('https://picsum.photos/500?1', 'picsum-1', 'jpg', 'image/jpeg', 'Abstraction Rouge', 1),
('https://picsum.photos/500?2', 'picsum-2', 'jpg', 'image/jpeg', 'Fusion Bleue', 1);

INSERT INTO peinture_media (id_peinture, id_media, is_main, sort_order) VALUES
(1, 1, 1, 0),
(2, 2, 1, 0);

INSERT INTO peinture_categorie (id_peinture, id_categorie) VALUES
(1, 1),
(2, 1);
