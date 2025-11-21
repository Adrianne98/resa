# resa

Services Booking Application
Description

Cette application est un prototype de gestion de services et de réservations.
Elle permet à des utilisateurs de :

Consulter les services disponibles et leurs créneaux horaires

Réserver des services

Visualiser leurs réservations

(Pour les administrateurs) Ajouter des services et des créneaux

Le projet utilise :

PHP pour le backend et la logique métier

JSON comme "base de données"

JavaScript pour le rafraîchissement dynamique des données

HTML/CSS pour l’interface utilisateur

⚠ Ce projet est conçu comme un prototype et n’est pas sécurisé pour une utilisation publique sans corrections (voir recommandations ci-dessous).

Fonctionnalités
Utilisateur

Connexion avec email et mot de passe

Voir la liste des services disponibles et leurs slots

Réserver un créneau pour un service

Visualiser ses réservations

Annuler une réservation

Administrateur

Ajouter de nouveaux services

Ajouter des créneaux à un service

Voir toutes les réservations des utilisateurs

Installation

Cloner le dépôt :

git clone https://github.com/username/services-booking.git
cd services-booking


Assurez-vous d’avoir un serveur PHP (ex : XAMPP, WAMP, MAMP)

Copier le projet dans le répertoire accessible par le serveur (ex : htdocs)

Donner les permissions d’écriture pour data.json :

chmod 666 data.json


Accéder à l’application via votre navigateur :

php -S localhost:8000


Structure des fichiers
/index.php      - Entrée principale et logique du site
/api.php        - API pour récupérer services et réservations (JSON)
/main.html      - Interface utilisateur (HTML)
/app.js  - Scripts JS pour rafraîchir dynamiquement les données
/data.json      - Base de données JSON (services, utilisateurs, réservations)
/style.css      - Styles CSS pour l’application

Données initiales

Le fichier data.json contient :

Services : liste des services avec leurs ID, nom, type et slots

Users : liste des utilisateurs avec email, rôle et mot de passe hashé

Bookings : liste des réservations (vide au départ)

Exemple d’utilisateur admin :

Email : admin@example.com

Mot de passe : admin123

Exemple d’utilisateur standard :

Email : user@example.com

Mot de passe : user123

Utilisation

Ouvrir la page principale index.php

Se connecter avec un utilisateur existant ou admin

Consulter les services et réserver un créneau

Les réservations de l’utilisateur sont affichées automatiquement

Les administrateurs peuvent ajouter de nouveaux services et slots via le panneau admin

Limitations et recommandations

⚠ Cette application est un prototype. Les points suivants doivent être corrigés avant usage public :

Validation des entrées :
Les formulaires acceptent actuellement des valeurs invalides.

Ajouter menus déroulants pour services et slots

Valider côté serveur les IDs et créneaux

Sécurité :

Ajouter protection CSRF

Échapper toutes les données affichées pour éviter XSS

Placer data.json hors de la racine web

Concurrence :

Verrouiller les écritures sur data.json (LOCK_EX) pour éviter la corruption en cas de requêtes simultanées

Gestion des sessions :

Déconnexion correctement implémentée

Expiration de session recommandée

Système d’ID :

Actuellement, id = count(...) + 1 → risque de collisions

Mieux : utiliser max(id)+1 ou un compteur persistant

Améliorations possibles

Migration vers une base de données SQL (SQLite ou MySQL)

Interface plus dynamique : sélectionner service → charger slots disponibles

API REST complète avec authentification token

Notifications et confirmations de réservation

Licence

Ce projet est fourni à titre pédagogique et n’est pas destiné à une utilisation en production.
Vous pouvez l’adapter librement à vos besoins.