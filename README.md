# API réalisé pour le test technique de HelloCSE

## Travail demandé : 
À l'aide de Laravel 10/11 créer une API qui possède : 
 - une entité adminstrateur permettant de s'authentifier (champs libre)
 - une entité profile possédant les champs suivant : nom / id de l'administateur ayant créer le profil / prénom / image (fichier) / statut (inactif, en attente, actif) / timestamp
 - une entité commentaire lié au profile avec une relation N:1 possédant les champs suivants : contenu / id de l'administrateur ayant posé le commentaire / id du profil / timestamp

Liste des endpoints publics demandés :
 - récupération de l'ensemble des profil ayant le status actif mais sans retourner le champ status accessible uniquement pour les admin authentifier

Liste des endpoints protégé par authentification demandés :
  - création d'une entité profil 
  - ajout de commentaire sur un profil avec une limite de un commentaire par admin par profil
  - modification ou suppression du profil

## Propositions : 

### Installation du projet : 

    git clone https://github.com/SophieAuvergne/helloCSE.git
    docker compose up --build

lancer le volume docker helloCSE_app : 

    docker exec -it helloCSE_app bash

adapter le fichier .env dans le dossier app
    
    cp .env.example .env

préparer et remplisser votre base de donnée 

    php artisan migrate
    php artisan db:seed

### Endpoint existant publics : 
 - POST : /api/login : permet l'authentification
   - email
   - password
 - GET : /api/profiles : récupération des profiles

### Endpoint existant privés : 
 - POST : /api/profiles : 
   - name 
   - firstname
   - image
   - status
 - PUT : /api/profiles/{profile} : 
   - name
   - firstname
   - image
   - status
 - DELETE : /api/profiles/{profile} : 
 - POST : /api/profiles/{profile}/comments : 
   - comment