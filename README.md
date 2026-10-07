## Stack choisie
- Laravel
- MySQL

## Installation et lancement

cd d:\www\examen\laravel
composer install
npm install
cp .env.example .env
php artisan key:generate


Créer la base MySQL `examen`, puis :
php artisan migrate --seed
npm run build
php artisan serve

Ouvrir http://localhost:8000.

## Compte et données de test

- Email : `atif@bibliotech.com`
- Mot de passe : `bibliothecaire`


## Fonctionnalités réalisées

- F1 : CRUD livres (liste, ajout, modification, suppression)
- F2 : CRUD adhérents (liste, ajout, modification, suppression)
- F3 : validation des formulaires avec messages en français
- F4 : enregistrer un emprunt (retour prévu après 14 jours)
- F5 : enregistrer un retour (stock +1)
- F6 : recherche titre/auteur, filtre catégorie, filtre disponibles uniquement
- F7 : liste des emprunts en cours, retards en ligne rouge
- F8 : tableau de bord (livres, adhérents, en cours, retards)
- F9 : authentification bibliothécaire (toutes les pages protégées)
- F10 : pagination de la liste des livres (10 par page)
- F11 : historique des emprunts sur la fiche adhérent
- F12 : export CSV des emprunts en cours


## Limites connues

- Un seul compte bibliothécaire, pas de rôles multiples
- Pas d'inscription publique (compte créé par seeder)
- Historique adhérent sans pagination
- CSV simple
