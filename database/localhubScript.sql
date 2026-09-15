DROP DATABASE IF EXISTS localhub;

CREATE DATABASE localhub
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE localhub;

CREATE TABLE utilisateur (
    id_utilisateur INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    courriel VARCHAR(255) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    ville VARCHAR(100) NOT NULL,
    date_inscription DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE categorie (
    id_categorie INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL UNIQUE,
    description TEXT
) ENGINE=InnoDB;

CREATE TABLE publication (
    id_publication INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    id_utilisateur INT UNSIGNED NOT NULL,
    id_categorie INT UNSIGNED NOT NULL,

    titre VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,

    type VARCHAR(30) NOT NULL,
    prix DECIMAL(10,2) NULL,

    ville VARCHAR(100) NOT NULL,

    statut VARCHAR(30) NOT NULL DEFAULT 'active',

    date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_publication_utilisateur
        FOREIGN KEY (id_utilisateur)
        REFERENCES utilisateur(id_utilisateur),

    CONSTRAINT fk_publication_categorie
        FOREIGN KEY (id_categorie)
        REFERENCES categorie(id_categorie)

) ENGINE=InnoDB;

CREATE TABLE demande (
    id_demande INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    id_publication INT UNSIGNED NOT NULL,
    id_demandeur INT UNSIGNED NOT NULL,

    message TEXT NOT NULL,

    statut VARCHAR(30) NOT NULL DEFAULT 'en_attente',

    date_demande DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_demande_publication
        FOREIGN KEY (id_publication)
        REFERENCES publication(id_publication),

    CONSTRAINT fk_demande_utilisateur
        FOREIGN KEY (id_demandeur)
        REFERENCES utilisateur(id_utilisateur)

) ENGINE=InnoDB;

CREATE TABLE activite (
    id_activite INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    id_publication INT UNSIGNED NOT NULL UNIQUE,

    date_heure DATETIME NOT NULL,
    lieu VARCHAR(255) NOT NULL,
    max_participants INT UNSIGNED NOT NULL,

    CONSTRAINT fk_activite_publication
        FOREIGN KEY (id_publication)
        REFERENCES publication(id_publication)

) ENGINE=InnoDB;

CREATE TABLE participation (
    id_activite INT UNSIGNED NOT NULL,
    id_utilisateur INT UNSIGNED NOT NULL,

    date_inscription DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id_activite, id_utilisateur),

    CONSTRAINT fk_participation_activite
        FOREIGN KEY (id_activite)
        REFERENCES activite(id_activite),

    CONSTRAINT fk_participation_utilisateur
        FOREIGN KEY (id_utilisateur)
        REFERENCES utilisateur(id_utilisateur)

) ENGINE=InnoDB;

CREATE TABLE evaluation (
    id_evaluation INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    id_evaluateur INT UNSIGNED NOT NULL,
    id_evalue INT UNSIGNED NOT NULL,
    id_publication INT UNSIGNED NOT NULL,

    note TINYINT UNSIGNED NOT NULL,
    commentaire TEXT,

    date_evaluation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT chk_evaluation_note
        CHECK (note BETWEEN 1 AND 5),

    CONSTRAINT chk_evaluation_utilisateur
        CHECK (id_evaluateur <> id_evalue),

    CONSTRAINT fk_evaluation_evaluateur
        FOREIGN KEY (id_evaluateur)
        REFERENCES utilisateur(id_utilisateur),

    CONSTRAINT fk_evaluation_evalue
        FOREIGN KEY (id_evalue)
        REFERENCES utilisateur(id_utilisateur),

    CONSTRAINT fk_evaluation_publication
        FOREIGN KEY (id_publication)
        REFERENCES publication(id_publication)

) ENGINE=InnoDB;

INSERT INTO categorie (nom, description) VALUES
    ('Aide', 'Demandes et offres d''aide entre utilisateurs.'),
    ('Services', 'Services proposés par les utilisateurs.'),
    ('Objets', 'Objets à vendre, donner ou échanger.'),
    ('Outils', 'Outils et équipements disponibles pour le partage.'),
    ('Activités', 'Activités locales auxquelles les utilisateurs peuvent participer.');
    
INSERT INTO utilisateur
    (nom, prenom, courriel, mot_de_passe, ville)
VALUES
    ('Tremblay', 'Alex', 'alex.tremblay@localhub.test', 'TEMPORAIRE', 'Montréal'),
    ('Gagnon', 'Sarah', 'sarah.gagnon@localhub.test', 'TEMPORAIRE', 'Montréal'),
    ('Roy', 'Thomas', 'thomas.roy@localhub.test', 'TEMPORAIRE', 'Laval'),
    ('Bouchard', 'Emma', 'emma.bouchard@localhub.test', 'TEMPORAIRE', 'Longueuil'),
    ('Côté', 'Maxime', 'maxime.cote@localhub.test', 'TEMPORAIRE', 'Montréal');
    
INSERT INTO publication
    (id_utilisateur, id_categorie, titre, description, type, prix, ville, statut)
VALUES

    -- Publication 1 : demande d'aide
    (
        1,
        1,
        'Besoin d''aide pour déplacer un canapé',
        'Je cherche un voisin disponible pour m''aider à déplacer un canapé samedi après-midi.',
        'aide',
        NULL,
        'Montréal',
        'active'
    ),

    -- Publication 2 : prêt d'outil
    (
        2,
        4,
        'Perceuse sans fil à prêter',
        'Je peux prêter ma perceuse sans fil pour des petits travaux. Durée maximale de 3 jours. Une caution peut être demandée.',
        'outil',
        NULL,
        'Montréal',
        'active'
    ),

    -- Publication 3 : service
    (
        3,
        2,
        'Cours particuliers de mathématiques',
        'J''offre des cours particuliers de mathématiques pour les étudiants du secondaire.',
        'service',
        20.00,
        'Laval',
        'active'
    ),

    -- Publication 4 : vente
    (
        4,
        3,
        'Bureau de travail usagé',
        'Bureau en bon état, idéal pour un espace de travail à la maison. Quelques marques d''utilisation.',
        'objet',
        60.00,
        'Longueuil',
        'active'
    ),

    -- Publication 5 : activité
    (
        5,
        5,
        'Nettoyage communautaire du parc',
        'Activité communautaire pour nettoyer le parc du quartier et rencontrer d''autres résidents.',
        'activite',
        NULL,
        'Montréal',
        'active'
    ),

    -- Publication supplémentaire : aide informatique
    (
        1,
        2,
        'Aide pour configurer un ordinateur',
        'Je peux aider les voisins à installer et configurer leur ordinateur ou leurs logiciels.',
        'service',
        NULL,
        'Montréal',
        'active'
    ),

    -- Publication supplémentaire : objet gratuit
    (
        2,
        3,
        'Chaise de bureau à donner',
        'Chaise de bureau encore fonctionnelle. À venir chercher sur place.',
        'objet',
        0.00,
        'Montréal',
        'active'
    ),

    -- Publication supplémentaire : outil
    (
        4,
        4,
        'Escabeau disponible pour partage',
        'Escabeau de 6 pieds disponible pour les voisins qui en ont besoin.',
        'outil',
        NULL,
        'Longueuil',
        'active'
    );
    
INSERT INTO activite
    (id_publication, date_heure, lieu, max_participants)
VALUES
    (
        5,
        '2026-10-10 10:00:00',
        'Parc Jarry, Montréal',
        15
    );