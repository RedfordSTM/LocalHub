# LocalHub
La plateforme locale pour s'entraider, partager et se retrouver.
LocalHub est une plateforme communautaire conçue pour faciliter les échanges entre les résidents d'une même communauté.
Dans de nombreuses communautés, les habitants disposent de ressources, de compétences ou de temps qu'ils pourraient partager avec leurs voisins, mais il n'existe pas toujours d'espace centralisé et simple pour faciliter ces échanges.
LocalHub rassemble ces interactions au même endroit afin de permettre aux utilisateurs de demander de l'aide, proposer leurs services, partager ou emprunter du matériel, vendre des objets de seconde main et organiser des activités locales.
L'objectif est de créer un espace numérique axé sur les interactions locales et réelles entre les membres d'une communauté.

## 🌐 Fonctionnalités
LocalHub permet notamment aux utilisateurs de :
🤝 Demander de l'aide auprès de personnes à proximité
🛠️ Partager ou prêter du matériel et des outils
💼 Proposer ou rechercher des services locaux
🏷️ Vendre des objets de seconde main
🎉 Créer et rejoindre des activités communautaires
💬 Communiquer avec d'autres utilisateurs
⭐ Évaluer les interactions et les utilisateurs
📍 Découvrir des publications selon leur proximité
Le système est conçu autour d'un principe simple :
Ce dont une personne a besoin peut être quelque chose qu'une autre personne possède, sait faire ou souhaite partager.

## 🏗️ Technologies
LocalHub est développé dans le cadre du cours de développement d'applications Web transactionnelles.
Technologies principales
PHP 8.2
HTML5
CSS3
MySQL 8.0
Apache 2.4
AMPPS 6.3.9
Environnement
Le projet utilise PHP de manière native et ne nécessite aucun framework frontend moderne tel que React ou Vue.

## 📋 Logiciels et versions requis
Logiciel
Version
AMPPS
6.3.9
Apache
2.4 ou version fournie par AMPPS
PHP
8.2
MySQL
8.0 ou version fournie par AMPPS


## 🚀 Installation
1. Cloner le dépôt
Clonez le dépôt GitHub :
git clone https://github.com/RedfordSTM/LocalHub.git
cd LocalHub


2. Préparer la base de données
Ouvrez MySQL Workbench ou phpMyAdmin fourni avec AMPPS.
Créez une base de données pour LocalHub, par exemple :
CREATE DATABASE localhub_bd;

Importez ensuite le script SQL d'initialisation présent dans le projet afin de créer les tables et les données nécessaires.
Le nom de la base de données doit correspondre à celui utilisé dans la configuration de connexion PHP du projet.

### ⚙️ Configuration d'Apache
Pour rendre l'application accessible depuis une URL locale stable, un alias Apache peut être configuré.
1. Ouvrir la configuration Apache
Dans AMPPS, ouvrez le fichier :
httpd.conf

2. Ajouter l'alias
Ajoutez le bloc suivant en adaptant le chemin selon l'emplacement du projet :
Alias /localhub "C:/chemin/vers/LocalHub"

<Directory "C:/chemin/vers/LocalHub">
    Options -Indexes +FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>

3. Redémarrer Apache
Après avoir enregistré les modifications, redémarrez Apache depuis le panneau de contrôle AMPPS.

## ▶️ Démarrage
1. Démarrer les services
Ouvrez AMPPS et démarrez :
Apache
MySQL
2. Accéder à LocalHub
Ouvrez votre navigateur et rendez-vous à :
http://localhost/localhub/

Si vous utilisez une autre configuration Apache, l'URL peut varier selon l'alias configuré.

## 🗄️ Structure générale
L'application repose sur plusieurs types de données reliées afin de gérer les interactions entre les membres de la communauté.
Une représentation simplifiée du système est :
Utilisateur
    │
    ├── Publications
    │      ├── Demande d'aide
    │      ├── Service
    │      ├── Objet
    │      └── Activité
    │
    ├── Interactions
    │      ├── Demandes
    │      ├── Réservations
    │      └── Participations
    │
    ├── Messages
    │
    └── Évaluations

Les opérations transactionnelles permettent notamment de créer, modifier, réserver, accepter, refuser ou compléter différentes interactions entre utilisateurs.

🧪 Développement
Aucune compilation ou étape de build n'est nécessaire.
Le projet utilise PHP côté serveur avec HTML et CSS pour l'interface.
Après toute modification du code, il suffit de recharger la page dans le navigateur.

📁 Structure du projet
La structure peut évoluer au cours du développement, mais le projet suit une organisation permettant de séparer notamment :
LocalHub/
├── css/
├── img/
├── maquettes/
├── index.php
├── recits.php
└── README.md


## 🎯 Objectif du projet
LocalHub est développé dans le cadre d'un projet individuel de développement d'applications Web transactionnelles.
Le projet met en pratique :
la gestion des utilisateurs;
l'authentification;
la gestion de plusieurs types de données;
les relations entre les données;
les opérations CRUD;
les transactions;
la gestion des demandes et réservations;
la persistance des données avec MySQL;
la génération dynamique de pages avec PHP.
À plus long terme, LocalHub pourrait évoluer vers une véritable plateforme communautaire permettant aux utilisateurs d'interagir avec leur communauté locale au-delà du cadre académique.

📌 Statut
Projet en développement — Version 0.x
Les fonctionnalités, l'architecture et l'interface sont susceptibles d'évoluer pendant le développement.

📄 Licence
Projet académique — tous droits réservés, sauf indication contraire.


