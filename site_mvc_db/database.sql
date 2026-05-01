CREATE DATABASE mamie_gallery;

USE mamie_gallery;

CREATE TABLE peintures (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    description TEXT,
    image TEXT,
    date VARCHAR(100),
    meta VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE coutures (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    description TEXT,
    image TEXT,
    date VARCHAR(100),
    meta VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE evenements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    description TEXT,
    image TEXT,
    date VARCHAR(100),
    meta VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO peintures (title, description, image, date, meta) VALUES
('Abstraction Rouge','Peinture rouge intense','https://picsum.photos/500?1','2026','100x80 cm'),
('Fusion Bleue','Art bleu fluide','https://picsum.photos/500?2','2026','120x90 cm');
