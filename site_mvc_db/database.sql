CREATE DATABASE mamie_gallery;

USE mamie_gallery;

CREATE TABLE peintures (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    description TEXT,
    image TEXT,
    dimension VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO peintures (title, description, image, dimension) VALUES
('Abstraction Rouge','Peinture rouge intense','https://picsum.photos/500?1','100x80 cm'),
('Fusion Bleue','Art bleu fluide','https://picsum.photos/500?2','120x90 cm');
